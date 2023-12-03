<?php
    $con = new mysqli("localhost","root","","client02");

    if(!$con){
        die(mysqli_error($con));
    }
?>