<?php

    class Session {

        private $signedIn;
        public $userId;

        function __construct() {

            session_start();
        }

        private function checkTheLogin() {

            if(isset($_SESSION['user_id'])) {
                $this->user_id = $_SESSION['user_id'];
                $this->signedIn = true;
            }
            else {
                unset($this->user_id);
                $this->signedIn = false;
            }
        }
    }

    $session = new Session();

 ?>
