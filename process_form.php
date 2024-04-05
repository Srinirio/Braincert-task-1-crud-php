<?php
include("database.php");
if (isset($_POST["submit"])) {
    // $file_name = $_FILES["image"]['name'];
    $file_temp_name=$_FILES["image"]['tmp_name'];
    $allowed_extentions=['png','jpg','jpeg'];
    $file_type=strtolower(pathinfo( $_FILES["image"]['name'],PATHINFO_EXTENSION));
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $country = $_POST["country"];
    $state = $_POST["state"];
    $phone = $_POST["phone"];
    if(!in_array($file_type,$allowed_extentions)){
        header('Location: form.php?error=Invalid file type');
        exit; 
    }

    $file_name=time().".".$file_type;

    if(move_uploaded_file($file_temp_name,"images/".$file_name)){
        $sql="INSERT INTO `users` (image, name, email, country, state, phone) VALUES ('$file_name', '$name', '$email', '$country', '$state', $phone)";
        $result = mysqli_query($connect,$sql);
        if($result)
        {
            header("location:index.php?success=true");
        }
        else{
            die(mysqli_error($connect));
        }
    }
    else{
        echo "not uploaded";
    }
    

}
?>