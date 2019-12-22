            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Admin
                            <small>Subheading</small>
                        </h1>

                        <?php

                            // $user = new User();
                            //
                            // $user->username = "Student";
                            // $user->password = "somethingweird";
                            // $user->first_name = "Sol";
                            // $user->last_name = "Lalals";
                            //
                            // $user->create();

                            // $user = User::findUserById(3);          // zwraca wiersz z tabeli users (zwraca jednego usera)
                            // $user->password="hasloziomala";
                            // $user->update();
                            // $user->username="Whatever";
                            // $user->save();

                            // $user = new User();
                            // $user->username="Whatever12121";
                            // $user->save();

                            $users = User::findAll();

                            foreach ($users as $user) {
                                echo $user->username;
                            }
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
