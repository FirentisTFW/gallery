<?php

    if(isset($_POST['submit'])) {
        // echo "<pre>";
        // print_r($_FILES['file_upload']);     // informacje o przesyłanym pliku
        // echo "<pre>";

        $tempName = $_FILES['file_upload']['tmp_name'];
        $theFile = $_FILES['file_upload']['name'];
        $directory = "uploads";

        if(move_uploaded_file($tempName, $directory . "/" . $theFile)) {      // wbudowana funkcja php, zwraca true, jeśli przeniesienie pliku się powiedzie
            echo "File uploaded successfully!";
        }
        else {
            echo "Error! File not uploaded!";
        }

    }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <form action="upload.php" enctype="multipart/form-data" method="post"> <!--  enctype - do przesyłania innych typów plików (np. zdjeć) -->
            <input type="file" name="file_upload">
                <br>
            <input type="submit" name="submit">
        </form>

    </body>
</html>
