<?php

    class DbObject {

        public static function findAll() {

            global $database;       // uczynienie obiektu $database globalnym, żeby można było użyć jego metody query()

            // $resultSet = $database->query("SELECT * FROM users");
            // return $resultSet;
            return static::findThisQuery("SELECT * FROM " . static::$dbTable . " ");      // static:: - late static binding - sprawdzić na php.net
        }

        public static function findById($id) {

            global $database;

            $resultArray = static::findThisQuery("SELECT * FROM " . static::$dbTable . " WHERE id = $id LIMIT 1");

            if(!empty($resultArray)) {
                $firstItem = array_shift($resultArray);
                return $firstItem;
            }
            else {
                return false;
            }
        }


        public static function findThisQuery($sql) {

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

    }


 ?>
