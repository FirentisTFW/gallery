<?php include("includes/header.php"); ?>
<?php
    if(!$session->isSignedIn()) {       // user nie jest zalogowany - wyślij go do innej strony
        redirect("login.php");
    }
 ?>

<?php

    if(!isset($_GET['id'])) {redirect("users.php");}       // zabezpieczenie

    $user = User::findById($_GET['id']);

    if(isset($_POST['update'])) {
        if($user) {
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->password = $_POST['password'];

            if(empty($_FILES['user_image'])) {
                $user->save();
            }
            else {
                $user->setFile($_FILES['user_image']);
                $user->saveUserAndImage();
                $user->save();

                redirect("edit_user.php?id={$user->id}");
            }

        }
    }

    if(isset($_POST['delete'])) {
        redirect("delete_user.php?id={$user->id}");
    }

?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->

                <?php include "includes/top_nav.php"; ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

                <?php include "includes/side_nav.php"; ?>

            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users
                            <small>Subheading</small>
                        </h1>

                        <div class="col-md-6">
                            <img class="img-responsive" src="<?php echo $user->imagePathAndPlaceholder(); ?>" alt="">
                        </div>

                        <form class="" method="post" enctype="multipart/form-data">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="user_image">Avatar</label>
                                    <input type="file" name="user_image">
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" class="form-control"value="<?php echo $user->last_name; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control"value="<?php echo $user->first_name; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo $user->password; ?>">
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="delete" class="btn btn-danger pull-left" value="Delete">
                                </div>

                                <div class="form-group">
                                    <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                                </div>

                            </div>

                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
