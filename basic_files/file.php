<?php

    echo __FILE__ . "</br>";        // wyświetla ścieżkę do pliku
    echo __LINE__ . "</br>";        // pokazuje nr linii w kodzie
    echo __DIR__ . "</br>";         // directory

    if(file_exists(__DIR__))     // czy plik o takiej ścieżce istnieje
        echo "yes  ";

    if(is_file(__FILE__))
        echo "yes  ";

    if(is_dir(__DIR__))
        echo "yes";
 ?>
