<?php

    require_once("new_config.php");

    class Database {

        public $connection;

        function __construct() {        // konstruktor
            $this->openDbConnection();        // wywoływanie metody | nawiązywanie połczenia za każdym razem, gdy tworzony jest obiekt
        }

        public function openDbConnection() {

            // $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);      // stary sposób na połączenie

            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);         // nowy sposób na połączenie

            if($this->connection->connect_errno) {
                die("Error: " . $this->connection->connect_errno);
            }
        }

        public function query($query) {

            $result = $this->connection->query($query);
            $this->confirmQuery($result);

            return $result;
        }

        private function confirmQuery($result) {

            if(!$result) {
                die("Query failed!" . $this->connection->error);
            }
        }

        public function escapeString($string) {

            $escapedString = $this->connection->real_escape_string($string);        // sanityzacja danych
            return $escapedString;
        }

        // public function theInsertId() {
        //
        //     return mysqli_insert_id($this->connection);
        // }

        public function theInsertId() {

            return $this->connection->insert_id;
        }

    }

    $database = new Database();        // tworzenie nowego obiektu | otwieranie połączenia z BD na każdej stronie (ten plik jest zaincludowany w headerze)
?>
