<?php
include("database.php");
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
    <style>
        .group-phone-number {
            display: flex;
            flex-direction: row;
            gap: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>User Information Form</h1>
        <form action="process_form.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <!-- <img src="" alt="Sample Image" class="mt-2" style="max-width: 100px;"> -->
                <p id="error-data-image" style="color:red; display: none;"></p>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
                <p id="error-data-name" style="color:red; display: none;"></p>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
                <p id="error-data-email" style="color:red; display: none;"></p>
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country:</label>

                <select class="form-select" aria-label="Default select example" id="country" name="country">
                    <option selected>Select Country</option>
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
                <p id="error-data-country" style="color:red; display: none;">*Please select country</p>
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State:</label>

                <select class="form-select" aria-label="Default select example" id="state" name="state">
                    <option selected>Select State</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label><br>
                <div class="group-phone-number">
                    <input type="text" id="country_phone_code" name="phone_code" class="form-control new-form-control" value="+91" readonly="" style="width: 100px; float: left;">
                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">

                </div>
                <p id="error-data-phone" style="color:red; display: none;"></p>
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

            // document.getElementById("country_phone_code").value = "+" + getCountryCode;
            $("#country_phone_code").val("+" + getCountryCode);

            var country_id = $(this).find('option:selected').attr('id');
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
        //VALIDATION NAME
        $(document).on('focusin', '#name', function() {
            $("#error-data-name").hide();
        });

        $(document).on('focusout', '#name', function() {
            let name = $(this).val();
            if (name === "" || name.length < 3) {
                if (name === "") {
                    $("#error-data-name").html("*Name is required");
                } else {
                    $("#error-data-name").html("*Name must be at least 3 characters long");
                }
                $("#error-data-name").show();
            } else {
                $("#error-data-name").hide();
            }
        });
        //VALIDATION EMAIL
        $(document).on('focusin', '#email', function() {
            $("#error-data-email").hide();
        });

        $(document).on("focusout", "#email", function() {
            let email = $(this).val();
            if (email === "") {
                $("#error-data-email").html("*Email required");
                $("#error-data-email").show();
            } else {
                $("#error-data-email").hide();
            }
        });

        $(document).on("keyup", "#email", function() {
            let email = $(this).val();
            let patten_for_email = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!patten_for_email.test(email)) {
                $("#error-data-email").html("*Please enter valid email");
                $("#error-data-email").show();
            } else {
                $("#error-data-email").hide();
            }
        });
        //VALIDATION NUMBER
        $(document).on('focusin', '#phone', function() {
            $("#error-data-phone").hide();
        });

        $(document).on("focusout", "#phone", function() {
            let phone = $(this).val();
            if (phone === "") {
                $("#error-data-phone").html("*Phone number required");
                $("#error-data-phone").show();
            } else {
                $("#error-data-phone").hide();
            }
        });

        $(document).on("keyup", "#phone", function() {
            let phone = "" + $(this).val();

            if (phone.length <= 10) {
                $("#error-data-phone").html("*Please enter valid number");
                $("#error-data-phone").show();
            } else {
                $("#error-data-phone").hide();
            }
        });

        //VALIDATION COUNTRY
        $(document).on('change', "#country", function() {
            let country = $(this).val();
            if (country === "Select Country") {
                $("#error-data-country").show();
            } else {
                $("#error-data-country").hide();
            }
        });


        $(document).on('click', "#submit", function() {
            let name = $("#name").val();
            let email = $("#email").val();
            let number = $("#phone").val();
            let country = $("#country").val();
            let image = $("#image").val();


            if (name === "" || email === "" || number === "" || country === "Select Country" ||image==="") {
                $("#name").focusout();
                $("#email").focusout();
                $("#phone").focusout();
                $("#error-data-image").html("please image");
                $("#error-data-image").show();
                $('#country').change();
                event.preventDefault();
            }
            console.log(image);
            let fileExtension = image.split('.').pop().toLowerCase();
            if (fileExtension !== 'png' && fileExtension !== 'jpg' && fileExtension !== 'jpeg') {
                $("#error-data-image").html("*Image should be in this formats [png,jpg,jpeg]");
                $("#error-data-image").show();
                event.preventDefault();
            } else {
                $("#error-data-image").hide();
            }
        });


    });
</script>

</html>