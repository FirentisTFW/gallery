<?php

    class User extends DbObject {

        protected static $dbTable = "users";
        protected static $dbTableFields = ['username', 'password', 'first_name', 'last_name'];
        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;


        public static function verifyUser($username, $password) {

            global $database;

            $username = $database->escapeString($username);      // sanityzacja
            $password = $database->escapeString($password);

            $sql = "SELECT * FROM " . self::$dbTable . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
            $result = self::findThisQuery($sql);

            if(!empty($result)) {               // nie ma takego usera
                $firstItem = array_shift($result);
                return $firstItem;
            }
            else {
                return false;
            }

        }

        protected function properties() {       // zwraca wszystkie atrybuty danego obiektu

            $properties = array();

            foreach (self::$dbTableFields as $db_field) {
                if(property_exists($this, $db_field)) {         // obiekt ma atrybut o takiej nazwie jak wartość $db_field
                    $properties[$db_field] = $this->$db_field;      // przed $db_field dajemy "$", bo nie jest to atrybut obiektu, tylko zwykła zmienna
                 }
            }

            return $properties;
        }

        protected function cleanProperties() {      // funkcja do "czyszczenia" tablicy przed przesłaniem jej do bazy

            global $database;

            $cleanProperties = [];

            foreach ($this->properties() as $key => $value) {
                $cleanProperties[$key] = $database->escapeString($value);
            }

            return $cleanProperties;
        }



        public function save() {

            if(isset($this->id)) {          // user istnieje - update'ujemy go
                $this->update();
            }       // user nie istnieje - tworzymy go
            else {
                $this->create();
            }
        }

        public function create() {

            global $database;

            $properties = $this->cleanProperties();      // get object properties

            // niżej - implode(array_keys()) - wstawia nazwy atrybutów obiektu (które są takie same jak w bazie danych), oddzielając je przecinkiem - jest to funkcja uniwersalna, która zadziała na różnych obiektach w różnych klasach
            $sql = "INSERT INTO " . self::$dbTable . "(" .  implode(",", array_keys($properties))   .")" . " VALUES ('" . implode("', '", array_values($properties)) . "')";           // użycie metody z klasy Database do operacji na danych z klasy User

            if($database->query($sql)) {

                $this->id = $database->theInsertId();

                return true;
            }
            else {
                return false;
            }

        }

        public function update() {

            global $database;

            $properties = $this->cleanProperties();      // get object properties

            $propertiesPairs = [];

            foreach ($properties as $key => $value) {
                $propertiesPairs[] = "{$key}='{$value}'";
            }

            $sql = "UPDATE " . self::$dbTable . " SET " . implode(", ", $propertiesPairs) . " WHERE id = " . $database->escapeString($this->id);

            $database->query($sql);

            if(mysqli_affected_rows($database->connection) == 1) {      // sorawdzamy, czy update zadziałał - czy zmieniono jeden wiersz w tabeli
                return true;
            }
            else {
                return false;
            }

        }

        public function delete() {

            global $database;

            $sql = "DELETE FROM " . self::$dbTable . " WHERE id = {$database->escapeString($this->id)} LIMIT 1";

            $database->query($sql);

            if(mysqli_affected_rows($database->connection) == 1) {      // sorawdzamy, czy update zadziałał - czy zmieniono (usunięto) jeden wiersz w tabeli
                return true;
            }
            else {
                return false;
            }
        }

    }


 ?>
