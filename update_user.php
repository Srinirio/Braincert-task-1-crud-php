<?php
include("database.php");

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
   
    if (!empty($_FILES["image"]["name"])) {
        $file_temp_name = $_FILES["image"]['tmp_name'];
        $allowed_extensions = ['png', 'jpg', 'jpeg'];
        $file_type = strtolower(pathinfo($_FILES["image"]['name'], PATHINFO_EXTENSION));
        $image_name = $_FILES["image"]["name"];
        $target_path = "images/" . $image_name;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
            
            $update_image_query = "UPDATE users SET Image='$image_name' WHERE Id=$id";
            if (!mysqli_query($connect, $update_image_query)) {
                echo "Error updating image record: " . mysqli_error($connect);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
  
    $name = $_POST["name"];
    $email = $_POST["email"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $phone = $_POST["phone"];

    $update_query = "UPDATE users SET Name='$name', Email='$email', Country='$country', State='$state', Phone='$phone' WHERE Id=$id";
    if (mysqli_query($connect, $update_query)) {
        header("location:index.php");
    } else {
        echo "Error updating record: " . mysqli_error($connect);
    }
}
?>
