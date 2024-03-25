<?php
include("database.php");
if(!isset($_GET['update_id']))
{
    die(mysqli_error($connect));
}
$id=$_GET['update_id'];
$sql="SELECT * FROM `users` WHERE Id=$id";
$result=mysqli_query($connect,$sql);
$row = mysqli_fetch_assoc($result);
$name=$row['Name'];
$email=$row["Email"];
$image=$row["Image"];
$country=$row["Country"];
$phone=$row['Phone'];
$state=$row['State'];

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Registration Form</title>
</head>

<body>
    <div class="container">
        <h1>User Information Form</h1>
        <form action="update_user.php" method="POST" enctype="multipart/form-data">
            <!-- <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" value=<//?php echo $image;?>>
                <!-- <img src="" alt="Sample Image" class="mt-2" style="max-width: 100px;"> -->
            <!-- </div> --> -->
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
    <label for="image" class="form-label">Image:</label>
    <input type="file" class="form-control" id="image" name="image" accept="image/*">
    <!-- Display current image -->
    <img src="images/<?php echo $image; ?>" alt="Current Image" class="mt-2" style="max-width: 100px;">
</div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name" value=<?php echo $name;?>>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email" value=<?php echo $email;?>>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>
              
                <select class="form-select" aria-label="Default select example" id="country" name="country">
                    <option selected value=<?php echo $country;?> id=<?php echo $id;?> ><?php echo $country;?></option>
                    <?php

                    $sql = "SELECT * FROM `Countrys`";
                    $result = mysqli_query($connect, $sql);
                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row["Id"];
                            $country = $row["Name"];
                            $country_code = $row["Country_code"];
                            echo "<option value='$country' id='$id' country-code='$country_code' >$country</option>";
                        }
                    } else {
                        die(mysqli_error($connect));
                    }

                    ?>

                </select>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State:</label>
               
                <select class="form-select" aria-label="Default select example" id="state" name="state">
                    <option value=<?php echo $state;?> id=<?php echo $id;?> ><?php echo $state;?></option>
                </select>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label><br>
                <input type="text" id="country_phone_code" name="phone_code" class="form-control new-form-control " <?php
                $sql="SELECT * FROM `countrys` WHERE Name='$country'";
                $result=mysqli_query($connect,$sql);
                $row=mysqli_fetch_assoc($result);
                echo "value='{$row['Country_code']}'";
                
                ?> style="width: 100px; float: left;">
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value=<?php echo $phone;?>>
            </div>
            <button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
        </form>
    </div>



</body>
<script>
    $(document).ready(function() {
        //CHANGE COUNTRY CODE AND STATE
        $('#country').on('change', function() {

            var getCountryCode = $(this).find('option:selected').attr('country-code');

            document.getElementById("country_phone_code").value = getCountryCode;

            var country_id = $(this).find('option:selected').attr('id');;
            //    alert(country_id);
            $.ajax({
                url: 'get_state.php',
                type: 'post',
                data: {
                    country_id: country_id
                },
                success: function(result) {
                    $('#state').html(result);
                }
            });
        });
        
    });
</script>
</html>