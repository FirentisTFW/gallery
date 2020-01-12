<?php include("includes/header.php"); ?>

<?php

    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;     // numer strony

    $itemsPerPage = 3;         // ilość zdjęć na stronę

    $itemsTotalCount = Photo::countAll();

    $pagination = new Pagination($page, $itemsPerPage, $itemsTotalCount);

    $sql = "SELECT * FROM photos LIMIT {$itemsPerPage} OFFSET {$pagination->offset()}";

    $photos = Photo::findByQuery($sql);

    // $photos = Photo::findAll();

 ?>

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-12">
            <div class="thumbnails row">

                <?php foreach ($photos as $photo) { ?>

                    <div class="col-xs-6 col-md-3">
                        <a class="thumbnail" href="show_photo.php?id=<?php echo $photo->id; ?>">
                            <img class="home-page-photo img-responsive" src="admin/<?php echo $photo->picturePath(); ?>" alt="">
                        </a>
                    </div>

                <?php  } ?>

            </div>

            <div class="row">
                <ul class="pager">

                    <?php

                        if($pagination->pageTotal() > 1) {
                            if($pagination->hasNext()) {
                                echo "<li class='next'><a href='index.php?page={$pagination->next()}'>Next</a></li>";
                            }

                            for($i = 1; $i <= $pagination->pageTotal(); $i++) {
                                if($i == $pagination->currentPage) {
                                    echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                                }
                                else {
                                    echo "  <li><a href='index.php?page={$i}'>{$i}</a></li>";
                                }
                            }

                            if($pagination->hasPrevious()) {
                                echo "<li class='previous'><a href='index.php?page={$pagination->previous()}'>Previous</a></li>";
                            }
                        }

                     ?>

                    <!-- <li class='previous'><a href=''>Previous</a> </li> -->
                </ul>
            </div>
        </div>


    <!-- Blog Sidebar Widgets Column -->
        <!-- <div class="col-md-4"> -->
            <?php // include("includes/sidebar.php"); ?>
        <!-- </div> -->
    <!-- /.row -->

    <?php include("includes/footer.php"); ?>
