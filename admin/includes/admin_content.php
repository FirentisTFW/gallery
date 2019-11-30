            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>

                        <?php

                            // $result = User::findAllUsers();    // korzystanie z metody statycznej klasy User
                            //
                            // while($row = mysqli_fetch_array($result)) {
                            //     echo $row['username'] . "<br>";
                            // }

                            // $foundUser = User::findUserById(2);    // korzystanie z metody statycznej klasy User
                            //
                            // $user = User::instantation($foundUser);
                            //
                            // echo $user->username;

                            // $users = User::findAllUsers();
                            // foreach ($users as $user) {
                            //     echo $user->username . "  ";
                            // }

                            $foundUser = User::findUserById(2);
                            echo $foundUser->username;

                         ?>

                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->
