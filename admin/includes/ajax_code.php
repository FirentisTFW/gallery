<?php
    require_once "init.php";

    $user = new User();     // tworzymy nowy obiekt, żeby móc użyć funkcji ajaxSaveUserImage()

    if(isset($_POST['image_name'])) {

        $user->ajaxSaveUserImage($_POST['image_name'], $_POST['user_id']);

        // echo "Data from the server";
    }

 ?>
