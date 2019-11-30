<?php

    class User {

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

        private function hasProperty($property) {

            $objectProperties = get_object_vars($this);         // gotowa funkcja php - zwraca wszystkie atrybuty klasy

            return array_key_exists($property, $objectProperties);      // kolejna gotowa funkcja - sprawdza czy $porperty znajduje się w $objectProperties
        }

    }


 ?>
