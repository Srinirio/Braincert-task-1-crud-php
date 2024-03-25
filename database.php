<?php

$connect=new mysqli("localhost","root","","crud");
if(!$connect)
{
    die(mysqli_error($connect));
}
?>