<?php

require_once $_SERVER['DOCUMENT_ROOT']."/_includes/init.php";
ini_set('max_execution_time', 3000000);

$All_Query = $DB->execute("SELECT count(*) FROM converting", true)['count(*)'];
$Attempts = 0; // Try twice

while ($All_Query > 0) {
    //GET LATEST UPLOADED VIDEO TO CONVERT
    $Query = $DB->execute("SELECT converting.*, videos.file_url, videos.privacy, users.username FROM converting INNER JOIN videos ON converting.url = videos.url INNER JOIN users ON videos.uploaded_by = users.username ORDER BY converting.date LIMIT 1", true);

    if ($Query["status"] == 1) {
        $FILE = $Query["file_url"];
        if (!file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE.mp4") && !file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE.720.mp4")) {
            $DB->modify("UPDATE converting SET status = 0, start_date = '0000-00-00 00:00:00' WHERE url = :URL", [":URL" => $Query["url"]]);
            $Query["status"] = 0;
        }
    }

    if ($DB->Row_Num > 0 && $Query["status"] == 0) {
        set_time_limit(0);

        $URL        = $Query["url"];
        $FILE_URL   = $Query["file_url"];
        $PRIVACY    = $Query["privacy"];
        $UPLOADER   = new User($Query["username"],$DB);
        $UPDATING   = $Query["updating"];

        $DB->modify("UPDATE converting SET status = 1, start_date = NOW() WHERE url = :URL", [":URL" => $URL]);

        $Video_File = glob($_SERVER['DOCUMENT_ROOT']."/u/tmp/$FILE_URL.*")[0];

        $Video           = new ffmpeg();
        $Video->Location = $Video_File;

        $Length          = $Video->Get_Length(true);
        $Info = $DB->execute("SELECT users.is_partner FROM users WHERE users.username = ? LIMIT 1", true, [$UPLOADER->Username]);
        $Partner = $Info['is_partner'];
        
    if ($Partner == 0) {
        if ($Length <= 900) {
            $Video->Get_Info();
            $Video->Resize(480);
            $Video->SampleRate   = 44100;
            $Video->CRF          = 23;
            $Video->Framerate    = "30";
            $Video->AudioBitrate = "128k";
            $Video->Output       = $_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.mp4";
            $Log = $Video->Convert();

            if (file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.mp4")) {
                if ($Length <= 7) {
                    $Thumbnail_Sec = 1;
                } else {
                    $Thumbnail_Sec = mt_rand(0, $Length);
                }

                $Log = $Video->Thumbnail($Thumbnail_Sec, $URL);
                if ($Log !== true) {
                    file_put_contents($Video_File . '.log', $Log, FILE_APPEND);
                }

                unlink($Video_File);

                $Attempts = 0;
                $DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $URL]);
                $DB->modify("DELETE FROM converting WHERE url = :URL", [":URL" => $URL]);
                $DB->modify("UPDATE videos SET status = 2, length = :LENGTH WHERE url = :URL", [":LENGTH" => $Length, ":URL" => $URL]);
                $UPLOADER->update_videos();
            }
            else {
                $Attempts += 1;
                if ($Attempts === 2) {
                    file_put_contents($Video_File . '.log', $Log, FILE_APPEND);
                    //unlink($Video_File);
                    $DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $URL]);
                    $DB->modify("DELETE FROM converting WHERE url = :URL", [":URL" => $URL]);
                    $DB->modify("UPDATE videos SET status = -1 WHERE url = :URL", [":URL" => $URL]);
                }
            }
        } else {
            $Video          = new Video($URL, $DB);
            $Video->Exists  = true;
            $Video->delete();
        }
    } else {
        if ($Length <= 3601) {
            $Video->Get_Info();
            $Video->Resize(720);
            $Video->SampleRate   = 44100;
            $Video->CRF          = $Video->HD ? 25 : 23;
            $Video->Framerate    = "30";
            $Video->AudioBitrate = "192k";
            $Video->Output       = $_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.mp4";
            $Log = $Video->Convert();
            $Cond = file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.mp4");

            if ($Video->HD) {
                rename($Video->Output, $_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.720.mp4");
                $HD = 1;
                
                $Video->Resize(360);
                $Video->SampleRate = 44100;
                $Video->Framerate = "30";
                $Video->AudioBitrate = "96k";
                $Video->CRF = 23;
                $Log = $Video->Convert();
                $Cond = file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.mp4") && file_exists($_SERVER['DOCUMENT_ROOT']."/videos/$FILE_URL.720.mp4");
            } else {
                $HD = 0;
            }

            if ($Cond) {
                if ($Length <= 7) {
                    $Thumbnail_Sec = 1;
                } else {
                    $Thumbnail_Sec = mt_rand(0, $Length);
                }

                $Log = $Video->Thumbnail($Thumbnail_Sec, $URL);
                if ($Log !== true) {
                    file_put_contents($Video_File . '.log', $Log, FILE_APPEND);
                }

                unlink($Video_File);

                $Attempts = 0;
                $DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $URL]);
                $DB->modify("DELETE FROM converting WHERE url = :URL", [":URL" => $URL]);
                $DB->modify("UPDATE videos SET status = 2, length = :LENGTH, hd = :HD WHERE url = :URL", [":LENGTH" => $Length, ":HD" => $HD, ":URL" => $URL]);
                $UPLOADER->update_videos();
            }
            else {
                $Attempts += 1;
                if ($Attempts === 2) {
                    file_put_contents($Video_File . '.log', $Log);
                    //unlink($Video_File);
                    $DB->modify("DELETE FROM videos_uploads WHERE vid = :URL", [":URL" => $URL]);
                    $DB->modify("DELETE FROM converting WHERE url = :URL", [":URL" => $URL]);
                    $DB->modify("UPDATE videos SET status = -1 WHERE url = :URL", [":URL" => $URL]);
                }
            }
        } else {
            $Video          = new Video($URL, $DB);
            $Video->Exists  = true;
            $Video->delete();
        }
    }
    } else {
        die();
    }
    //UPDATE VIDEO QUEUE COUNT
    $All_Query = $DB->execute("SELECT count(*) FROM converting", true)['count(*)'];
}
die();