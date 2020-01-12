<?php

    class DbObject {

        public static function findAll() {

            global $database;       // uczynienie obiektu $database globalnym, żeby można było użyć jego metody query()

            // $resultSet = $database->query("SELECT * FROM users");
            // return $resultSet;
            return static::findByQuery("SELECT * FROM " . static::$dbTable . " ");      // static:: - late static binding - sprawdzić na php.net
        }

        public static function findById($id) {

            global $database;

            $resultArray = static::findByQuery("SELECT * FROM " . static::$dbTable . " WHERE id = $id LIMIT 1");

            if(!empty($resultArray)) {
                $firstItem = array_shift($resultArray);
                return $firstItem;
            }
            else {
                return false;
            }
        }


        public static function findByQuery($sql) {

            global $database;
            $resultSet = $database->query($sql);
            $theObjectArray = [];       // pusta tablica, będziemy do niej dodawać niżej

            while($row = mysqli_fetch_array($resultSet)) {
                $theObjectArray[] = static::instantation($row);
            }

            return $theObjectArray;
        }

        public static function instantation($theRecord) {

            $callingClass = get_called_class();         // klasa dziedzicząca z klasy rodzica (klasa potomna)

            $theObject = new $callingClass;              // tworzenie nowego obiektu klasy potomnej

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


        private function hasProperty($property) {

            $objectProperties = get_object_vars($this);         // gotowa funkcja php - zwraca wszystkie atrybuty klasy

            return array_key_exists($property, $objectProperties);      // kolejna gotowa funkcja - sprawdza czy $porperty znajduje się w $objectProperties
        }

        protected function properties() {       // zwraca wszystkie atrybuty danego obiektu

            $properties = array();

            foreach (static::$dbTableFields as $db_field) {
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
            $sql = "INSERT INTO " . static::$dbTable . "(" .  implode(",", array_keys($properties))   .")" . " VALUES ('" . implode("', '", array_values($properties)) . "')";           // użycie metody z klasy Database do operacji na danych z klasy User

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

            $sql = "UPDATE " . static::$dbTable . " SET " . implode(", ", $propertiesPairs) . " WHERE id = " . $database->escapeString($this->id);

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

            $sql = "DELETE FROM " . static::$dbTable . " WHERE id = {$database->escapeString($this->id)} LIMIT 1";

            $database->query($sql);

            if(mysqli_affected_rows($database->connection) == 1) {      // sorawdzamy, czy update zadziałał - czy zmieniono (usunięto) jeden wiersz w tabeli
                return true;
            }
            else {
                return false;
            }
        }

        public static function countAll() {

            global $database;

            $sql = "SELECT COUNT(*) FROM " . static::$dbTable;
            $resultSet = $database->query($sql);

            $row = mysqli_fetch_array($resultSet);

            return array_shift($row);       // array_shift() - usuwa pierwszy element z tablicy
        }


    }


 ?>
