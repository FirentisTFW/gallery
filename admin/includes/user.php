<?php

    class User {

        protected static $dbTable = "users";
        protected static $dbTableFields = ['username', 'password', 'first_name', 'last_name'];
        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;

        public static function findAllUsers() {

            global $database;       // uczynienie obiektu $database globalnym, żeby można było użyć jego metody query()

            // $resultSet = $database->query("SELECT * FROM users");
            // return $resultSet;
            return self::findThisQuery("SELECT * FROM users");
        }

        public static function findUserById($id) {

            global $database;

            $resultArray = self::findThisQuery("SELECT * FROM users WHERE id = $id LIMIT 1");

            if(!empty($resultArray)) {
                $firstItem = array_shift($resultArray);
                return $firstItem;
            }
            else {
                return false;
            }

            return $foundUser;
        }

        public static function findThisQuery($sql) {

            global $database;
            $resultSet = $database->query($sql);
            $theObjectArray = [];       // pusta tablica, będziemy do niej dodawać niżej

            while($row = mysqli_fetch_array($resultSet)) {
                $theObjectArray[] = self::instantation($row);
            }

            return $theObjectArray;
        }

        public static function verifyUser($username, $password) {

            global $database;

            $username = $database->escapeString($username);      // sanityzacja
            $password = $database->escapeString($password);

            $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
            $result = self::findThisQuery($sql);

            if(!empty($result)) {               // nie ma takego usera
                $firstItem = array_shift($result);
                return $firstItem;
            }
            else {
                return false;
            }

        }

        public static function instantation($theRecord) {

            $theObject = new self;              // tworzenie nowego obiektu klasy User (self - odwołujemy się do tej samej klasy, w której jest zdefiniowana metoda)

            // $theObject->id = $foundUser['id'];
            // $theObject->username = $foundUser['username'];
            // $theObject->password = $foundUser['password'];
            // $theObject->firstName = $foundUser['first_name'];
            // $theObject->lastName = $foundUser['last_name'];

            foreach ($theRecord as $property => $value) {           // ta pętla robi to samo, co wyżej - jest to zautomatyzowane
                if($theObject->hasProperty($property)) {
                    $theObject->$property = $value;
                }
            }

            return $theObject;
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

        private function hasProperty($property) {

            $objectProperties = get_object_vars($this);         // gotowa funkcja php - zwraca wszystkie atrybuty klasy

            return array_key_exists($property, $objectProperties);      // kolejna gotowa funkcja - sprawdza czy $porperty znajduje się w $objectProperties
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
