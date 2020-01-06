<?php include("includes/init.php"); ?>

<?php
    if(!$session->isSignedIn()) {       // user nie jest zalogowany - wyślij go do innej strony
        redirect("login.php");
    }
 ?>

<?php

    if(empty($_GET['id'])) {      // zabezpieczenie
        redirect('../photos.php');
    }

    $photo = Photo::findById($_GET['id']);

    if($photo) {
        $photo->deletePhoto();
        redirect("../photos.php");
    }
    else {                          // jeśli nie ma zdjecia o takim id
        redirect("../photos.php");
    }

 ?>
