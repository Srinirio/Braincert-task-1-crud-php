<?php
include("database.php");
if(isset($_POST['country_id']))
{
    $country_id = $_POST['country_id'];
    $sql = "SELECT * FROM `states` WHERE Parent_id=$country_id";
    $result = mysqli_query($connect, $sql);
    
    if($result)
    {
        
        while($row = mysqli_fetch_assoc($result))
        {
            $state = $row['Name'];
            $id=$row['Id'];
            echo "<option value='$state' id=$id >$state</option>"; 
        }
        
    }
    else
    {
        echo json_encode(array('error' => mysqli_error($connect))); 
    }
}
else
{
    echo json_encode(array('error' => 'Country ID is not set.')); 
}
?>
