<?php

class Pagination
{
    public $Total_Pages;
    public $Current_Page;
    public $From;
    public $To;
    public $Total;

    function __construct($Item_Per_Page,public $Max_Pages = 99,$Page_Var = NULL) {
            if (isset($Page_Var)) {
                $_GET["p"] = $Page_Var;
            }
            if (isset($_GET["p"])) {
                if ($_GET["p"] < 1 or $_GET["p"] > $this->Max_Pages) {
                    $this->Current_Page = 1;
                } else {
                    $this->Current_Page = (int)$_GET["p"];
                }
            } else {
                $this->Current_Page = 1;
            }
            $this->From = ($this->Current_Page - 1) * $Item_Per_Page;
            $this->To   = $Item_Per_Page;
        }

    public function total(int $Total)
    {
        if ((ceil($Total / $this->To) >= $this->Current_Page && @$_GET["p"] != 1 && (@is_numeric($_GET["p"]) || !isset($_GET["p"]))) || $Total == 0) {
            $this->Total       = (int)$Total;
            $this->Total_Pages = ceil($this->Total / $this->To);

            return true;
        } else {
            if (@!is_numeric($_GET["p"])) {
                header("location: " . str_replace("&p=" . $_GET["p"], "", str_replace("?p=" . $_GET["p"], "", $_SERVER["REQUEST_URI"])));
                exit();
            }
            if (@$_GET["p"] != 1) {
                header("location: " . str_replace("&p=" . $this->Current_Page, "", str_replace("?p=" . $this->Current_Page, "", $_SERVER["REQUEST_URI"])));
                exit();
            } else {
                header("location: " . str_replace("&p=1", "", str_replace("?p=1", "", $_SERVER["REQUEST_URI"])));
                exit();
            }
        }
    }

    public function range()
    {
        if (isset($this->Total,$this->From,$this->To)) {
            if ($this->Total !== 0) {
                $First_Number = $this->From + 1;
            } else {
                $First_Number = 0;
            }
            if (($this->From + $this->To) <= $this->Total) {
                $Second_Number = $this->From + $this->To;
            } else {
                $Second_Number = $this->Total;
            }
            return $First_Number."-".$Second_Number." of ".$this->Total;
        }
    }

    public function show_pages($vars = "")
    {
        if (empty($vars)) {
            $Ext = "?";
        } else {
            $Ext = "&";
            $vars = "?".$vars;
        }

        for($x = 1;$x <= $this->Total_Pages;$x++) {
            if ($x !== 1) {
                $p = $Ext."p=".$x;
            } else {
                $p = "";
            }
            if ($x !== $this->Current_Page) {
                echo "<span style='font-weight:bold;background-color:#CCC;padding:1px 4px 1px 4px;border:1px solid #999;margin-right:5px'><a href='/".basename((string) $_SERVER["SCRIPT_FILENAME"]).$vars.$p."'>$x</a></span>";
            } else {
                echo "<span style='font-weight:bold;background-color:#FFF;padding:1px 4px 1px 4px;border:1px solid #999;margin-right:5px'>$x</span>";
            }
        }
    }

    // added by vistafan12 (for new show_pages layout) new_show_pages_videos
    public function new_show_pages_videos($var1,$Clean = false,$Ajax = true) {
        if (isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".$_COOKIE["lang"].".lang.php")) {
        include $_SERVER['DOCUMENT_ROOT'] . "/lang/".$_COOKIE["lang"].".lang.php";
    } elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php")) {
        include $_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5).".lang.php";
    } elseif (!isset($_COOKIE["lang"]) and file_exists($_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php")) {
        include $_SERVER['DOCUMENT_ROOT'] . "/lang/".substr((string) $_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2).".lang.php";
    } else {
        include $_SERVER['DOCUMENT_ROOT'] . "/lang/en-US.lang.php";
    }
            $this->Total_Pages = ceil($this->Total / $this->To);

            if ($this->Current_Page > $this->Total_Pages and $this->Current_Page !== 1) {
                if (!$Clean) {
                    redirect("?$var1");
                } else {
                    redirect("$var1");
                }
            }

            if ($this->Total_Pages == 0) { $this->Total_Pages = 1; }

            if ($this->Total_Pages > $this->Max_Pages) { $this->Total_Pages = $this->Max_Pages; }

            if (!empty($var1)) {
                if ($Clean === true) {
                    $var1 .= "/";
                } else {
                    $var1 = "?".$var1 . "&p=";
                }
            } else {
                if ($Clean === true) {
                    $var1 = "/";
                } else {
                    $var1 = "?p=";
                }
            }

            if ($Ajax == true) {
                $Onclick = 'onclick="change_page(this);return false;"';
            }
            else {
                $Onclick = "";
            }

            if ($this->Current_Page !== 1) {
                if ($this->Current_Page == 2) {
                    $s_var1 = mb_rtrim($var1,"/");
                    $s_var1 = mb_rtrim($s_var1,"&p=");
                    echo "<a class='pagerNotCurrentPrev' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php").$s_var1."'>".$LANGS['previous']."</a> ";
                } else {
                    $Previous_Page = $this->Current_Page - 1;
                    echo "<a class='pagerNotCurrentPrev' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php").$var1."".$Previous_Page."'>".$LANGS['previous']."</a> ";
                }
            }

            if ($this->Current_Page == 1) {
                for ($x = 1;$x <= $this->Total_Pages && $x <= 5;$x++) {
                    if ($this->Current_Page !== $x) {
                        echo "<a class='pagerNotCurrent' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php")."$var1$x'>". $x . "</a> ";
                    } else {
                        echo "<span class='pagerCurrent'>". $x . "</span> ";
                    }
                }
            } elseif ($this->Current_Page == 2) {
                $s_var1 = mb_rtrim($var1,"/");
                $s_var1 = mb_rtrim($s_var1,"&p=");
                echo "<a class='pagerNotCurrent' ".$Onclick." href='".$s_var1."'>1</a> ";
                for ($x = 2;$x <= $this->Total_Pages && $x <= 5;$x++) {
                    if ($this->Current_Page !== $x) {
                        echo "<a class='pagerNotCurrent' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php")."$var1$x'>". $x . "</a> ";
                    } else {
                        echo "<span class='pagerCurrent'>". $x . "</span> ";
                    }
                }
            } elseif ($this->Current_Page == 3) {
                $s_var1 = mb_rtrim($var1,"/");
                $s_var1 = mb_rtrim($s_var1,"&p=");
                echo "<a class='pagerNotCurrent' ".$Onclick." href='".$s_var1."'>1</a> <a class='pagerNotCurrent' ".$Onclick." href='".$var1."2'>2</a> ";
                for ($x = 3;$x <= $this->Total_Pages && $x <= 5;$x++) {
                    if ($this->Current_Page !== $x) {
                        echo "<a class='pagerNotCurrent' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php")."$var1$x'>". $x . "</a> ";
                    } else {
                        echo "<span class='pagerCurrent'>". $x . "</span> ";
                    }
                }
            } elseif ($this->Current_Page > 3) {
                $Previous_Page = $this->Current_Page - 1;
                $Previous_Previous_Page = $this->Current_Page - 2;

                echo "<a class='pagerNotCurrent' ".$Onclick." href='".$var1."$Previous_Previous_Page'>$Previous_Previous_Page</a> <a class='pagerNotCurrent' ".$Onclick." href='".$var1."$Previous_Page'>$Previous_Page</a> ";
                for ($x = $this->Current_Page;$x <= $this->Total_Pages && $x <= $this->Current_Page + 2;$x++) {
                    if ($this->Current_Page !== $x) {
                        echo "<a class='pagerNotCurrent' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php")."$var1$x'>". $x . "</a> ";
                    } else {
                        echo "<span class='pagerCurrent'>". $x . "</span> ";
                    }
                }
            }

            if ($this->Current_Page < $this->Total_Pages) {
                $Next_Page = $this->Current_Page + 1;
                echo "<a class='pagerNotCurrentNext' ".$Onclick." href='/".basename((string) $_SERVER["SCRIPT_FILENAME"],".php")."$var1$Next_Page'>".$LANGS['next']."</a> ";
            }
        }
}
