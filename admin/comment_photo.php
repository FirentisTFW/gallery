<?php include("includes/header.php"); ?>
<?php
    if(!$session->isSignedIn()) {       // comment nie jest zalogowany - wyślij go do innej strony
        redirect("login.php");
    }
 ?>

 <?php

    if(empty($_GET['id'])) {redirect("photos.php");}

    $comments = Comment::findTheComments($_GET['id']);

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
                            Comments
                        </h1>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo Id</th>
                                        <th>Author</th>
                                        <th>Body</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comments as $comment) {   ?>

                                    <tr>
                                        <td>
                                            <?php echo $comment->id; ?>
                                            <div class="action_link">
                                                <a href="delete_comment_photo.php?id=<?php echo $comment->id ?>">Delete</a>
                                                <a href="edit_comment.php?id=<?php echo $comment->id ?>">Edit</a>
                                            </div>
                                        </td>
                                        <td><?php echo $comment->photo_id ?></td>
                                        <td><?php echo $comment->author; ?></td>
                                        <td><?php echo $comment->body; ?></td>
                                    </tr>

                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>
