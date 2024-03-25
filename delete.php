<?php

include("database.php");
if(isset($_POST["id"]))
{
    $sql="DELETE FROM `users` WHERE Id={$_POST['id']}";
    $result=mysqli_query($connect,$sql);
    if($result)
    {
        echo "deleted";
    }
    else{
        echo "not delete";
    }
}

?>