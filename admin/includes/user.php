<?php

    class User {

        public static function findAllUsers() {

            global $database;       // uczynienie obiektu $database globalnym, żeby można było użyć jego metody query()

            $resultSet = $database->query("SELECT * FROM users");
            return $resultSet;
        }

        public static function findUserById($id) {
            global $database;

            $result = $database->query("SELECT * FROM users WHERE id = $id LIMIT 1");
            $foundUser = mysqli_fetch_array($result);

            return $foundUser;
        }

    }


 ?>
