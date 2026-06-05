<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
if (isset($_GET["resumableFilename"])) {
    $fileName = $_GET["resumableFilename"];
}
if (isset($_POST["resumableFilename"])) {
    $fileName = $_POST["resumableFilename"];
}
if (!$_USER->Logged_In || $_GET["resumableTotalSize"] > 2000000000) {
    exit();
}
function generateRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// The main content type for sending data back to the uploader is JSON, so we'll just set this up here.
header("Content-Type: application/json");
$result = []; // Associative array

if (isset($fileName)) {
    // We will query the database for information about the video upload session if it exists.
    $file = $DB->execute(
        // Query:
        "SELECT videos_uploads.iuvid, videos_uploads.vid, videos_uploads.fileName, videos.file_url
         FROM videos_uploads
         INNER JOIN videos 
         ON videos.url = videos_uploads.vid
         WHERE videos_uploads.fileName = :FILE_NAME AND videos_uploads.fileSize = :FILESIZE AND videos_uploads.status = 0
             AND videos_uploads.username = :USERNAME ORDER BY createDate DESC LIMIT 1", 
        // Mode is multiple:
        true,
        // Bindings:
        [
            ":FILESIZE" => $_GET["resumableTotalSize"], 
            ":USERNAME" => $_USER->Username, 
            ":FILE_NAME" => $fileName
        ]
    );
        
    if ($file) {
        // If the aforementioned query succeeded, then we just go with that: we are continuing
        // an existing upload.
        
        $DB->modify("UPDATE videos_uploads SET updateDate = NOW() WHERE iuvid = :IUVID", [":IUVID" => $file["iuvid"]]);
        $Extension  = pathinfo($fileName, PATHINFO_EXTENSION);
        $ID         = $file["vid"];
        $File_URL   = $file["file_url"];

        if (isset($_POST["resumableFilename"])) {
            $_POST["resumableFilename"] = $File_URL . "." . $Extension;
        } else {
            $_GET["resumableFilename"]  = $File_URL . "." . $Extension;
        }
        
        $result["videoId"] = $file["vid"];
    } elseif ($_GET["resumableChunkNumber"] == "1") {
        // If we're on the first resumable chunk, then we're starting the upload,
        // so we add a new video to the database.

        // Avoid clashing file_url
        do {
            $File_URL = generateRandomString(20);
        }
        while ($DB->execute("SELECT file_url FROM videos WHERE file_url = :FILE_URL", true, [":FILE_URL" => $File_URL]));

        $DELETE_ID = generateRandomString(12);
        
        // XXX(izzy): I think it's quite realistic that the generated ID may clash with
        // existing records at some point on the live database. We'll perform a check
        // here and regenerate the ID for as long as anything clashes.
        do {
            $ID = generateRandomString(8);
        }
        while ($DB->execute("SELECT url FROM videos WHERE url = :URL", true, [":URL" => $ID]));
        
        $insertVideoResult = $DB->modify(
            // Query:
            "INSERT INTO videos(url,file_url,title,description,tags,uploaded_by,uploaded_on,privacy,file_name,address,country,date_recorded,category,delete_id,status)
             VALUES(:URL,:FILE_URL,:TITLE,:DESCRIPTION,:TAGS,:UPLOADED_BY,NOW(),0,:FILE_NAME,:ADDRESS,:COUNTRY,:DATE,:CATEGORY,:DELETE_ID,0)",
             
            // Bindings:
            [
                ":URL"          => $ID,
                ":FILE_URL"     => $File_URL,
                ":TITLE"        => "No Title",
                ":DESCRIPTION"  => "",
                ":TAGS"         => "",
                ":FILE_NAME"    => $fileName,
                ":DATE"         => "0000-00-00",
                ":COUNTRY"      => "",
                ":ADDRESS"      => "",
                ":UPLOADED_BY"  => $_USER->Username,
                ":CATEGORY"     => 1,
                ":DELETE_ID"    => $DELETE_ID
            ]
        );
        
        if ($insertVideoResult === false) {
            header("HTTP/1.0 500 Internal Server Error");
            $result["error"] = "DB error: Failed to insert video record.";
            exit();
        }

        $insertUploadResult = $DB->modify(
            // Query:
            "INSERT INTO videos_uploads (vid, filename, filesize, username) 
            VALUES (:URL, :FILENAME, :FILESIZE, :USERNAME)",
            
            // Bindings:
            [":URL" => $ID, ":FILENAME" => $fileName, ":FILESIZE" => (int)$_GET["resumableTotalSize"], ":USERNAME" => $_USER->Username]
        );
        
        if ($insertUploadResult === false) {
            header("HTTP/1.0 500 Internal Server Error");
            $result["error"] = "DB error: Failed to insert upload record.";
            exit();
        }

        if (isset($_POST["resumableFilename"])) {
            $Extension = pathinfo((string) $_POST["resumableFilename"], PATHINFO_EXTENSION);

            $_POST["resumableFilename"] = $File_URL.".$Extension";
        } else {
            $Extension = pathinfo((string) $_GET["resumableFilename"], PATHINFO_EXTENSION);

            $_GET["resumableFilename"] = $File_URL.".$Extension";
        }
        
        $result["videoId"] = $ID;
    } else {
        header("HTTP/1.0 404 Not Found");
        $result["error"] = "DB entry for video not found.";
        exit();
    }
    if (isset($_POST["resumableIdentifier"])) {
        $Identifier                     = explode("-", (string) $_POST["resumableIdentifier"], 2)[0];
        $_POST["resumableIdentifier"]   = $Identifier."-".$_POST["resumableFilename"];
    } else {
        $Identifier                     = explode("-", (string) $_GET["resumableIdentifier"], 2)[0];
        $_GET["resumableIdentifier"]    = $Identifier."-".$_GET["resumableFilename"];
    }
} else {
    $result["error"] = "User is not logged in or video exceeds maximum file size.";
    exit();
}



// THE FUNCTIONS
function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function createFileFromChunks($temp_dir, $fileName, $chunkSize, $totalSize, $total_files)
{
    global $ID;
    global $DB;

    // count all the parts of this file
    $total_files_on_server_size = 0;
    foreach(scandir($temp_dir) as $file) {
        $total_files_on_server_size += filesize($temp_dir.'/'.$file);
    }

    // check that all the parts are present
    // If the Size of all the chunks on the server is equal to the size of the file uploaded.
    if ($total_files_on_server_size >= $totalSize) {
        // create the final destination file
        if (($fp = fopen($_SERVER["DOCUMENT_ROOT"]."/u/tmp/$fileName.video", 'w')) !== false) {
            for ($i=1; $i<=$total_files; $i++) {
                fwrite($fp, file_get_contents($temp_dir.'/'.$fileName.'.part'.$i));
            }
            fclose($fp);

            $DB->modify("UPDATE videos SET status = 1 WHERE url = :URL", [":URL" => $ID]);
            $DB->modify("UPDATE videos_uploads SET status = 1 WHERE vid = :URL", [":URL" => $ID]);
            $DB->modify("INSERT INTO converting (url, date, status) VALUES (:URL, NOW(), 0)", [":URL" => $ID]);
        } else {
            return false;
        }

        // rename the temporary directory (to avoid access from other
        // concurrent chunks uploads) and than delete it
        if (rename($temp_dir, $temp_dir.'_UNUSED')) {
            rrmdir($temp_dir.'_UNUSED');
        } else {
            rrmdir($temp_dir);
        }
    }
}


// THE SCRIPT
//check if request is GET and the requested chunk exists or not. this makes testChunks work
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if(!(isset($_GET['resumableIdentifier']) && trim($_GET['resumableIdentifier'])!='')) {
        $_GET['resumableIdentifier']='';
    }
    $temp_dir = $_SERVER["DOCUMENT_ROOT"].'/u/tmp/'.$ID;
    if(!(isset($_GET['resumableFilename']) && trim($_GET['resumableFilename'])!='')) {
        $_GET['resumableFilename']='';
    }
    if(!(isset($_GET['resumableChunkNumber']) && trim($_GET['resumableChunkNumber'])!='')) {
        $_GET['resumableChunkNumber']='';
    }
    $chunk_file = $temp_dir.'/'.$File_URL.'.part'.(is_numeric($_GET['resumableChunkNumber']) ? (int)$_GET['resumableChunkNumber'] : '');
    if (file_exists($chunk_file)) {
        header("HTTP/1.0 200 Ok");
    } else {
        header("HTTP/1.0 404 Not Found");
    }
}

// loop through files and move the chunks to a temporarily created directory
if (!empty($_FILES)) {
    $converting = false;
    foreach ($_FILES as $curFile) {

        // check the error status
        if ($curFile['error'] != 0) {
            continue;
        }

        // init the destination file (format <filename.ext>.part<#chunk>
        // the file is stored in a temporary directory
        if(isset($_POST['resumableIdentifier']) && trim((string) $_POST['resumableIdentifier'])!='') {
            $temp_dir = $_SERVER["DOCUMENT_ROOT"].'/u/tmp/'.$ID;
        }
        $dest_file = $temp_dir.'/'.$File_URL.'.part'.(is_numeric($_POST['resumableChunkNumber']) ? (int)$_POST['resumableChunkNumber'] : '');

        // create the temporary directory
        if (!is_dir($temp_dir)) {
            mkdir($temp_dir, 0777, true);
        }

        // move the temporary file
        if (move_uploaded_file($curFile['tmp_name'], $dest_file)) {
            createFileFromChunks($temp_dir, $File_URL, $_POST['resumableChunkSize'], $_POST['resumableTotalSize'], $_POST['resumableTotalChunks']);
            if ($converting == false) {
                $_USER->update_videos();
                $converting = true;
            }
        }
    }
}

// Echo the result object in JSON format for the client:
echo json_encode($result);