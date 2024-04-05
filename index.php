<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Index page</title>

    <style>
    
    .user-image {
        width: 100%;
        height: 400px; 
        object-fit: cover;
    }

    .card {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%; 
        background-color: #f8f9fa; 
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .btn-group {
        margin-top: auto; 
    }

    .card-title {
        text-align: center; 
    }

    .card-body {
        flex-grow: 1; 
    }
</style>


</head>

<body>

    <div class="container">
        <h1 class="my-4">User List</h1>

        <!-- Success Alerts -->
        <?php
        if (isset($_GET['success']) && $_GET['success'] == true) {
            echo "<div id='successAlert' class='alert alert-success' role='alert'>
              Successfully submitted
            </div>";
        }
        if (isset($_GET['update']) && $_GET['update'] == true) {
            echo "<div id='successAlert' class='alert alert-success' role='alert'>
              Successfully updated
            </div>";
        }
        ?>
       
<div id="successDelete" class="alert alert-danger" role="alert" style="display: none;">
    User deleted successfully.
</div>


        <!-- Register Button -->
        <a href="form.php" class="btn btn-secondary my-4">REGISTER</a>

        
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php
            include("database.php"); // Include your database connection file

            // Fetch data from database
            $query = "SELECT * FROM users";
            $result = mysqli_query($connect, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col">
                        <div class="card">
                            <img src="images/<?php echo $row['Image']; ?>" class="card-img-top user-image" alt="user image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['Name']; ?></h5>
                                <p class="card-text">
                                    <strong>Email:</strong> <?php echo $row['Email']; ?><br>
                                    <strong>Phone:</strong> <?php echo $row['Phone']; ?><br>
                                    <strong>Country:</strong> <?php echo $row['Country']; ?><br>
                                    <strong>State:</strong> <?php echo $row['State']; ?>
                                </p>
                            </div>
                            <div class="btn-group" role="group" aria-label="User actions">
                                <a href="update.php?update_id=<?php echo $row['Id']; ?>" class="btn btn-primary mx-2" role="button">Update</a>
                                <button type="button" class="btn btn-danger delete" data-id="<?php echo $row['Id']; ?>">Delete</button>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    
    <script>
        $(document).ready(function() {
           
            setTimeout(function() {
                $("#successAlert").fadeOut("slow");
            }, 60000);

            
            $(".delete").on("click", function() {
            var del = $(this);
            var id = del.data("id");
            
        
            var confirmDelete = confirm("Are you sure you want to delete this?");
            
            if (confirmDelete) {
                $.ajax({
                    url: "delete.php",
                    type: 'post',
                    data: {
                        id: id
                    },
                    success: function(d) {
                        del.closest('.card').remove();
                        $("#successDelete").fadeIn();
                        setTimeout(function() {
                            
                $("#successDelete").fadeOut("slow");
            }, 60000);
                    },
                });
            }
        });
        });
    </script>

</body>

</html>
