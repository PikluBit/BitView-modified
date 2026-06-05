<?php

class Email
{
    private $Config = [
        "Username"      => "",
        "Password"      => "",
        "Host"          => "",
        "Port"          => 465
    ];

    public $To;
    public $To_Name;
    public $Subject;


    public function send_email(string $Content)
    {

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = $this->Config["Host"];
        $mail->SMTPAuth = true;
        $mail->Username = $this->Config["Username"];
        $mail->Password = $this->Config["Password"];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $this->Config["Port"];

        $mail->setFrom($this->Config["Username"], 'BitView');
        $mail->addAddress($this->To, $this->To_Name);                       // Add a recipient
        //$mail->addReplyTo($this->Config["Username"], 'BitView Creators');
        //$mail->addCC($this->Config["Username"]);
        //$mail->addBCC($this->Config["Username"]);

        $mail->isHTML(true);

        $mail->Subject = $this->Subject;
        $mail->Body =
            "<meta charset='utf-8'>".
            "<style>body {font-family: Arial, sans-serif;font-size:12px}</style>"."<table width='100%'>".
            "<tr>".
            "<td>".
            "<img src='https://www.bitview.net/img/bv09logo.png' style='margin-bottom: 8px'>".
            "</td>".
            "<td style='text-align:right'>".
            "<a href='https://www.bitview.net/help'>help center</a> | <a href='https://www.bitview.net/my_account'>e-mail options</a>".
            "</td>".
            "</tr>".
            "</table>".
            "<h2>Dear $this->To_Name:</h2>".
            "<p>$Content</p>".
            "<div style='color:#ccc; text-align: center;'>&copy; 2024 BitView</div>";

        $mail->send();
    }
}
