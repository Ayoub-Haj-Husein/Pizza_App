<?php 

    // connnect to database
    $connection = mysqli_connect('localhost', 'ayoub', ']kTQJSMUR/ZU1ERH', 'ninja_pizza');
    // check connection
    if(!$connection):
      echo 'Connection Error' . mysqli_connect_error();
    endif;

?>