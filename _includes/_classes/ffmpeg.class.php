<?php

class ffmpeg
{
    public $Info;
    public $Location;
    public $Resolution;
    public $Framerate;
    public $SampleRate;
    public $Output;
    public $Bitrate;
    public $AudioBitrate;
    public $CRF;
    public $HD;

    public $FFMPEG;
    public $FFPROBE;

    public function __construct()
    {
        $this->FFMPEG = "ffmpeg";
        $this->FFPROBE = "ffprobe";
    }

    public function Get_Length($Echoseconds = null)
    {

        $ffmpegoutput = shell_exec("$this->FFPROBE -i ". $this->Location ." 2>&1");

        $search='/Duration: (.*?),/';
        preg_match($search, $ffmpegoutput, $matches);
        if (isset($matches[0]) && $matches[1] !== "N/A") {
            $explode = explode(':', $matches[1]);
            $hours = $explode[0];
            $minutes = $explode[1];
            $seconds = substr($explode[2], 0, strpos($explode[2], "."));
            $minutes += $hours * 60;
            if ($Echoseconds == false) {
                return $minutes . "." . $seconds;
            } else {
                $seconds += $minutes * 60;
                return $seconds;
            }
        } else {
            return false;
        }
    }

    public function Get_Info()
    {
        $ffmpegoutput = shell_exec("$this->FFPROBE -i ". $this->Location ." -v quiet -print_format json -show_format -show_streams 2>&1");
        $this->Info = json_decode($ffmpegoutput);
    }

    public function Resize($h_res)
    {
        // Set possible resolutions [Width => Height]
        $resolutions = [
            256 => 144,
            426 => 240,
            640 => 360,
            854 => 480,
            1280 => 720
        ];

        foreach($this->Info->streams as $s) {
            if ($s->codec_type == "video") {
                $vstream = $s;
                break;
            }
        }

        $vwidth = $vstream->width;
        $vheight = $vstream->height;
        $aspect = $vwidth/$vheight;

        if ($aspect != "0:1") { // Correct resolution based on Aspect Ratio
            if (str_contains((string) $aspect, ":")) {
                $aspect = explode(":", (string) $aspect);
                $aspect = (float)((int)$aspect[0] / (int)$aspect[1]);
            } else {
                $aspect = (float)$aspect;
            }

            if ($vheight * $aspect > $vwidth) {
                $vwidth = round($vheight * $aspect);
            } else {
                $vheight = round($vwidth / $aspect);
            }
        }

        // Pick best resolution and resize file accordingly
        $w_res = 256;
        $resize = true;
        foreach($resolutions as $w => $h) {
            if ($h > $h_res) {
                break;
            } else {
                $w_res = $w;
            }

            if ($vwidth <= $w && $vheight <= $h) {
                $width = $vwidth;
                $height = $vheight;
                $resize = false;
                break;
            }
        }

        // If video doesn't fit in the resolution, resize
        if ($resize) {
            $height = $resolutions[$w_res];
            $width = (int)($vwidth * ($height / $vheight));

            if ($width > $w_res) {
                $width = $w_res;
                $height = (int)($vheight * ($width / $vwidth));
            }
        }

        // Turn uneven numbers into even numbers for conversion
        if ($width % 2 == 1) {
            $width++;
        }
        if ($height % 2 == 1) {
            $height++;
        }

        // Set resolution
        $this->Resolution = $width."x".$height;
        $this->HD = $resolutions[$w_res] >= 720 ? true : false;
    }

    public function Convert()
    {
        $command = "$this->FFMPEG -i ". $this->Location ." -c:v libx264 -profile:v main -level 3.1 -preset medium -s ". $this->Resolution ." -crf ". $this->CRF ." -r ". $this->Framerate ." -pix_fmt yuv420p -b:a ". $this->AudioBitrate ." -ar ". $this->SampleRate ." -strict -1 -movflags +faststart ".$this->Output." 2>&1"; // Don't use -c:a, it'll select an aac encoder as the default one for mp4 files
        //echo "Conversion started: $command\n\n";
        return shell_exec($command);
    }

    public function Thumbnail($sec = null, $URL = null) // New Method
    {
        $Output = '../u/thmp/' . $URL . '.jpg';
        $Log = shell_exec($this->FFMPEG . ' -y -i '. $this->Location .' -an -ss ' . $sec . ' -filter:v "scale=\'if(gt(iw,ih),-2,120):if(gt(iw,ih),90,-2)\':sws_flags=bicubic,crop=120:90" -update 1 -frames:v 1 -q:v 20 ' . $Output . ' 2>&1');
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/u/thmp/' . $URL . '.jpg')) {
          return $Log;
        }
        $Output = '../u/thmp/' . $URL . '_m.jpg';
        $Log = shell_exec($this->FFMPEG . ' -y -i '. $this->Location .' -an -ss ' . $sec . ' -filter:v "scale=\'if(gt(iw,ih),-2,480):if(gt(iw,ih),360,-2)\':sws_flags=bicubic,crop=480:360" -update 1 -frames:v 1 -q:v 20 ' . $Output . ' 2>&1');
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/u/thmp/' . $URL . '_m.jpg')) {
          return $Log;
        }
        return true;
    }

    public function Preview($sec = null, $URL = null, $i = null) // Generate prvws
    {
        $Filename = $URL."_".$i;
        $Output = "../u/prvw/$Filename.jpg";
        shell_exec($this->FFMPEG . ' -y -i ' . $this->Location . ' -an -ss ' . $sec . ' -filter:v "scale=\'if(gt(iw,ih),-2,120):if(gt(iw,ih),90,-2)\':sws_flags=bicubic,crop=120:90" -update 1 -frames:v 1 -q:v 20 ' . $Output . ' 2>&1');
    }
}
