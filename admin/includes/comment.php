<?php

    class Comment extends DbObject {

        protected static $dbTable = "comments";
        protected static $dbTableFields = ['id', 'photo_id', 'author', 'body'];
        public $id;
        public $photo_id;
        public $author;
        public $body;


        public static function createComment($photo_id, $author="John", $body="") {

            if(!empty($photo_id) && !empty($author) && !empty($body)) {
                $comment = new Comment();

                $comment->photo_id = $photo_id;
                $comment->author = $author;
                $comment->body = $body;

                return $comment;
            }
            else {
                return false;
            }
        }

        public static function findTheComments($photo_id = 0) {

            global $database;

            $sql = "SELECT * FROM " .  self::$dbTable . " WHERE photo_id = " . $database->escapeString($photo_id) . " ORDER BY id ASC";

            return self::findByQuery($sql);
        }

    }


 ?>
