<?php require_once "includes/init.php"; ?>

<?php

    if($session->isSignedIn()) {            // jeśli uztykownik już jest zalogowany
        redirect("index.php");
    }

    if(isset($_POST['submit'])) {
        $username = trim($_POST['username']);       // trim() - funkcja usuwająca białe znaki i spacje z początku i końca
        $password = trim($_POST['password']);

        // method to check database user

        $userFound = User::verifyUser($username, $password);        // czy user istnieje | wywoływanie metody statycznej

        if($userFound) {
            $session->login($userFound);       // zaloguj usera
            redirect("index.php");
        }
        else {
            $theMessage = "Your password or username is incorrect";
        }
    }
    else {
        $username = "";
        $password = "";
    }

 ?>

<head>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

 <div class="col-md-4 col-md-offset-4">

 <h4 class="bg-danger"><?php if(isset($theMessage))echo $theMessage; ?></h4>

 <form id="login-id" action="" method="post">

     <div class="form-group">
     	<label for="username">Username</label>
     	<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >
     </div>

     <div class="form-group">
     	<label for="password">Password</label>
     	<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
     </div>


     <div class="form-group">
         <input type="submit" name="submit" value="Submit" class="btn btn-primary">
     </div>


 </form>


 </div>
