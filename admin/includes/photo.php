<?php

    class Photo extends DbObject {

        protected static $dbTable = "photos";
        protected static $dbTableFields = ['id', 'title', 'caption', 'description', 'filename', 'alternate_text', 'type', 'size'];
        public $id;
        public $title;
        public $caption;
        public $description;
        public $filename;
        public $alternate_text;
        public $type;
        public $size;

        public $tmpPath;        // temporary path - ścieżka używana, aby przenieść obrazki do bardziej trwałego folderu
        public $uploadDirectory = "images";
        public $errors = [];      // nasze errory - podczas przesyłania plików itp.


        // This method is passing $_FILES['uploaded_file'] as an argument

        public function setFile($file) {

            $_FILES = $_FILES['file_upload'];
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
                $this->filename = basename($_FILES['name']);
                $this->tmp_path = $_FILES['tmp_name'];
                $this->type = $_FILES['type'];
                $this->size = $_FILES['size'];
            }

        }

        public function picturePath() {

            return $this->uploadDirectory.DS.$this->filename;
        }

        public function save() {

            if($this->id) {
                $this->update();
            }
            else {

                if(!empty($this->errors)) {     // sprawdzenie, czy sa jakies errory
                    return false;
                }

                if(empty($this->filename) || empty($this->tmp_path)) {      // nastepne sprawdzanie
                    $this->errors[] = "The file is not available";
                    return false;
                }

                $targetPath = SITE_ROOT . DS . 'admin' . DS . $this->uploadDirectory . DS . $this->filename;       // ścieżka do pliku

                if(file_exists($targetPath)) {                  // plik o takiej nazwie jest już w folderze z plikami
                    $this->errors[] = "The file {$this->filename} already exists";
                    return false;
                }

                if(move_uploaded_file($this->tmp_path, $targetPath)) {          // wbudowana funkcja php przenosi plik z lokalizacji tymczasowej do właściwej

                    if($this->create()) {
                        unset($this->tmp_path);         // nie potrzebujemy już tej zmiennej
                        return true;
                    }
                    else {              // jeśli nawet to się nie uda - ostatni error checking
                        $this->errors[] = "Error! The file directory probably does not have permission.";
                        return false;
                    }
                }
                // $this->create();        // tworzenie zdjecia
            }
        }

        public function deletePhoto() {        // usuwa rekord z bazy i zdjęcie z serwera (folder images)

            if($this->delete()) {       // rekord usuniete, trzeba teraz usunąć plik

                $targetPath = SITE_ROOT.DS.'admin'.DS.$this->picturePath();       // ścieżka pliku
                return unlink($targetPath) ? true : false;        // wbudowana funkcja php - usuwanie pliku
            }
            else {          // nie udało się usunąć rekordu
                return false;
            }
        }

    }

 ?>
