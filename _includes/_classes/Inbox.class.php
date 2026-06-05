<?php
class Inbox {
    function __construct(private readonly User $Inbox_Owner, private readonly DB $DB)
    {
    }

    public function messages($Amount = 16, int $Type = null, int $Is_ByUser = null, int $Order = 1) {
        if ($Order === 0) { $Order = "ORDER BY submit_on ASC"; } else { $Order = "ORDER BY submit_on DESC"; }
        if (is_a($Amount,"Pagination")) { $LIMIT = "LIMIT $Amount->From, $Amount->To"; } else { $LIMIT = "LIMIT $Amount"; }
        if ($Type == 2) { $Notification = "AND (is_notification = 1 OR type = 2 OR type = 4 OR type = 5)"; }
        else if ($Type < 6 && $Type != 2) { $Notification = "AND type = $Type AND is_notification IS NULL"; }
        else { $Notification = ""; }
        if ($Is_ByUser == 1) { $WhereB = "WHERE by_user = :USERNAME"; } else { $WhereB = "WHERE for_user = :USERNAME"; }

        $Messages = $this->DB->execute("SELECT * FROM users_messages $WhereB $Notification $Order $LIMIT",
                                       false,
                                       [":USERNAME" => $this->Inbox_Owner->Username]);

        if ($Messages) { return $Messages; }

        return false;
    }

    public function send_message($Subject,$Message,$To,string $URL = "", int $Type = 0, int $Is_Notification = null) {

        $Spam = $this->DB->execute("SELECT count(*) as amount FROM users_messages WHERE by_user = :USERNAME AND content = :CONTENT", true, [":USERNAME" => $this->Inbox_Owner->Username, ":CONTENT" => $Message],false)["amount"];

        if ($Spam == 1) { return false; }

        $Send = $this->DB->modify("INSERT INTO users_messages (by_user,for_user,subject,content,attach_url,submit_on,type,is_notification) VALUES (:USERNAME,:TO_USER,:SUBJECT,:MESSAGE,:URL,NOW(),:TYPE,:IS_NOTIFICATION)",
                                  [":USERNAME" => $this->Inbox_Owner->Username, ":TO_USER" => $To, ":SUBJECT" => $Subject, ":MESSAGE" => $Message, ":URL" => $URL, ":TYPE" => $Type, ":IS_NOTIFICATION" => $Is_Notification],false);

        $ID = $this->DB->last_id();
        exec("php send_email.php m $ID > /dev/null 2>&1 &");

        if ($Send) {
            return true;
        }
        return false;
    }
}