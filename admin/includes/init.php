<?php

    defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);      // tenary operator - operator trójargumentowy | DIRECTORY_SEPARATOR - zmienia znaki ścieżki (/, \), zależnie od tego, na jakim systemie jesteś - definiujemy to jako stałą 'DS'

    defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'opt' . DS . 'lampp' . DS . 'htdocs' . DS . 'gallery');       //   /opt/lampp/htdocs/gallery

    defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');

    require_once "functions.php";
    require_once "new_config.php";
    require_once "database.php";
    require_once "db_object.php";
    require_once "photo.php";
    require_once "user.php";
    require_once "comment.php";
    require_once "session.php";

 ?>
