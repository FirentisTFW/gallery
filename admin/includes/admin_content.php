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
                            // $user->username = "Example2";
                            // $user->password = "Pass2";
                            // $user->first_name = "First2";
                            // $user->last_name = "Last2";
                            //
                            // $user->create();

                            $user = User::findUserById(4);          // zwraca wiersz z tabeli users (zwraca jednego usera)

                            $user->delete();

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
