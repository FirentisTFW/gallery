<?php include("includes/init.php"); ?>

<?php
    if(!$session->isSignedIn()) {       // user nie jest zalogowany - wyślij go do innej strony
        redirect("login.php");
    }
 ?>

<?php

    if(empty($_GET['id'])) {      // zabezpieczenie
        redirect('users.php');
    }

    $user = User::findById($_GET['id']);

    if($user) {
        $user->delete();
        redirect("users.php");
    }
    else {                          // jeśli nie ma zdjecia o takim id
        redirect("users.php");
    }

 ?>
