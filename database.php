<?php

class database{

    private $db_server;
    private $db_username;
    private $db_password;
    private $db_name;
    private $db_connection;

    function __construct(){
        $this->db_server = 'localhost';
        $this->db_username = 'root';
        $this->db_password = '';
        $this->db_name = 'letszchess';

        $dsn = "mysql:host=$this->db_server;dbname=$this->db_name;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
             $this->db_connection = new PDO($dsn, $this->db_username, $this->db_password, $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // default argument is een empty array; wordt associative array indien named placeholders worden gebruikt
    public function select($sql, $placeholders = []){
        $stmt = $this->db_connection->prepare($sql);
        $stmt->execute($placeholders);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // return alleen resultatenset als er data in zit.
        if(!empty($result)){
            return $result;
        }
        return;
    }

    public function insert($statement, $placeholders, $location=null){
        try {
            print_r($statement);
            print_r($placeholders);
            print_r($location);
            // start database transactie
            $this->db_connection->beginTransaction();

            // create PDOStatementObject and execute
            $stmt = $this->db_connection->prepare($statement);
            $stmt->execute($placeholders);

            // commit database changes
            $this->db_connection->commit();

            // check of er een redirect is
            if(!is_null($location)){
                header("location: $location.php");
            }else{
                // return van lastInsertId voor feature die niet geimplementeerd is.
                return $this->db_connection->lastInsertId();
            }
        }catch (Exception $e){
            // undo databasechanges in geval van error
            $this->db_connection->rollback();
            throw $e;
        }
    }

    // deze functie kan gebruikt worden om een table te updaten óf te deleten
    public function update_or_delete($sql, $placeholders, $location=[]){
        try{
            $stmt = $this->db_connection->prepare($sql);
            if($stmt->execute($placeholders) && !empty($location)){
                header("location: $location.php");
            };
        }catch(\PDOException $e){
            die($e->getMessage());
        }
    }
}

?>