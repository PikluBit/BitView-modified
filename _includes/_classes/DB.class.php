<?php
class DB {
    public $Row_Num;

    private static $Connect = [
        "host"      => "localhost",
        "database"  => "",
        "username"  => "",
        "password"  => "",
        "charset"   => "utf8mb4"
    ];

    protected $Connection;

    function __construct(bool $Show_Errors = true) {
        try {
            $this->Connection = new PDO('mysql:host='.$this::$Connect["host"].';dbname='.$this::$Connect["database"].';charset='.$this::$Connect["charset"],$this::$Connect["username"],$this::$Connect["password"], [
                PDO::ATTR_EMULATE_PREPARES      => true,
                PDO::ATTR_PERSISTENT            => false,
            ]);
             $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            
            return true;
        }
        catch (PDOException) { return false; }
    }

    private function logQuery(string $SQL, array $Execute) {
        return;
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $file = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['file'] ?? 'UNKNOWN';
        $bind_values = json_encode($Execute);
        
        $insertSql = "INSERT INTO sql_log (ip, statement, bind_values, file, execution_count) 
                      VALUES (:ip, :statement, :bind_values, :file, 1) 
                      ON DUPLICATE KEY UPDATE execution_count = execution_count + 1, last_executed = CURRENT_TIMESTAMP";
        $insertStmt = $this->Connection->prepare($insertSql);
        $insertStmt->execute([':ip' => $ip, ':statement' => $SQL, ':bind_values' => $bind_values, ':file' => $file]);
    }

    public function execute(string $SQL, bool $Single = false, array $Execute = [], bool $Log = true) {
        //if ($Log) { $this->logQuery($SQL, $Execute); }
        $Query = $this->Connection->prepare($SQL);
        $Query->execute($Execute);

        $this->Row_Num = $Query->rowCount();

        if ($this->Row_Num == 0) {
            return [];
        } elseif ($Single) {
            return @$Query->fetch(PDO::FETCH_ASSOC);
        } else {
            return @$Query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function modify(string $SQL, array $Execute = [], bool $Log = true) {
        //if ($Log) { $this->logQuery($SQL, $Execute); }
        $Query = $this->Connection->prepare($SQL);
        $Query->execute($Execute);

        $this->Row_Num = $Query->rowCount();

        if ($this->Row_Num > 0) {
            return true;
        }
        return false;
    }

    public function exists($Value, $Column, $Table) {
        $SQL = "SELECT $Column FROM $Table WHERE $Column = :VALUE";
        $Execute = [":VALUE" => $Value];
        //$this->logQuery($SQL, $Execute);
        $Query = $this->Connection->prepare($SQL);
        $Query->execute($Execute);

        if ($Query->rowCount() > 0) {
            $Query = $Query->fetch(PDO::FETCH_ASSOC);
            return $Query[$Column];
        } else {
            return false;
        }
    }
    
    public function last_id() {
        return $this->Connection->lastInsertId();
    }
}
