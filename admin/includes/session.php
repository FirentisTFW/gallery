<?php

    class Session {

        private $signedIn = false;
        public $userId;
        public $message;
        public $count;

        function __construct() {

            session_start();
            $this->visitorCount();
            $this->checkTheLogin();
            $this->checkMessage();
        }

        public function visitorCount() {

            if(isset($_SESSION['count'])) {
                return $this->count = $_SESSION['count']++;
            }
            else {
                return $_SESSION['count'] = 1;
            }
        }

        public function message($msg="") {

            if(!empty($msg)) {
                $_SESSION['message'] = $msg;
            }
            else {
                return $this->message;
            }
        }

        public function checkMessage() {

            if(isset($_SESSION['message'])) {
                $this->message = $_SESSION['message'];
                unset($_SESSION['message']);
            }
            else {
                $this->message = "";
            }
        }

        public function isSignedIn() {          // getter, sprawdza, czy user jest zalogowany

            return $this->signedIn;
        }

        public function login($user) {

            if($user) {
                $this->userId = $_SESSION['user_id'] = $user->id;
                $this->signedIn = true;
            }
        }

        public function logout() {

            unset($_SESSION['user_id']);
            unset($this->userId);
            $this->signedIn = false;
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
