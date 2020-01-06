<?php

    class User extends DbObject {

        protected static $dbTable = "users";
        protected static $dbTableFields = ['username', 'password', 'first_name', 'last_name', 'user_image'];
        public $id;
        public $username;
        public $password;
        public $first_name;
        public $last_name;
        public $user_image;
        public $uploadDirectory = "images";
        public $imagePlaceholder = "http://placehold.it/400x400&text=image";
        public $errors = [];      // nasze errory - podczas przesyłania plików itp.


        public static function verifyUser($username, $password) {

            global $database;

            $username = $database->escapeString($username);      // sanityzacja
            $password = $database->escapeString($password);

            $sql = "SELECT * FROM " . self::$dbTable . " WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
            $result = self::findByQuery($sql);

            if(!empty($result)) {               // nie ma takego usera
                $firstItem = array_shift($result);
                return $firstItem;
            }
            else {
                return false;
            }

        }

        public function imagePathAndPlaceholder() {

            return empty($this->user_image) ? $this->imagePlaceholder : $this->uploadDirectory . DS. $this->user_image;
        }

        public function setFile($file) {

            $_FILES = $_FILES['user_image'];       // mój dodatek - usunięcie zagnieżdżenia (podwójnej tabeli)
            // print_r($_FILES);


            if(empty($file) || !$_FILES || !is_array($_FILES)) {        // sprawdzenie, czy plik się przesłał
                $this->errore[] = "There was no fle uploaded here";
                return false;
            }
            elseif($_FILES['error'] != 0) {                     // error checking c.d.
                $this->errors[] = "Error!";
                return false;
            }
            else {                          // wszystko ok, plik przesłany
                $this->user_image = basename($_FILES['name']);
                $this->tmp_path = $_FILES['tmp_name'];
                $this->type = $_FILES['type'];
                $this->size = $_FILES['size'];
            }

        }

        public function saveUserAndImage() {

            if(!empty($this->errors)) {     // sprawdzenie, czy sa jakies errory
                return false;
            }

            if(empty($this->user_image) || empty($this->tmp_path)) {      // nastepne sprawdzanie
                $this->errors[] = "The file is not available";
                return false;
            }

            $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->user_image;       // ścieżka do pliku

            if(file_exists($targetPath)) {                  // plik o takiej nazwie jest już w folderze z plikami
                $this->errors[] = "The file {$this->user_image} already exists";
                return false;
            }

            if(move_uploaded_file($this->tmp_path, $targetPath)) {          // wbudowana funkcja php przenosi plik z lokalizacji tymczasowej do właściwej
                unset($this->tmp_path);         // nie potrzebujemy już tej zmiennej
                return true;
            }
            else {              // jeśli nawet to się nie uda - ostatni error checking
                    $this->errors[] = "Error! The file directory probably does not have permission.";
                    return false;
            }

        }


    }


 ?>
