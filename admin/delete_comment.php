<?php include("includes/init.php"); ?>

<?php
    if(!$session->isSignedIn()) {       // comment nie jest zalogowany - wyślij go do innej strony
        redirect("login.php");
    }
 ?>

<?php

    if(empty($_GET['id'])) {      // zabezpieczenie
        redirect('comments.php');
    }

    $comment = Comment::findById($_GET['id']);

    if($comment) {
        $comment->delete();
        redirect("comments.php");
    }
    else {                          // jeśli nie ma zdjecia o takim id
        redirect("comments.php");
    }

 ?>
