<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <title>Index page</title>
</head>

<body>

    <div class="container">
        <a href="form.php" class="btn btn-secondary my-5">REGISTER</a>

        <?php
        include("database.php"); // Include your database connection file

        // Fetch data from database
        $query = "SELECT * FROM users"; // Assuming you have a 'users' table
        $result = mysqli_query($connect, $query);

        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='card'>";
                echo "<div class='row g-0'>";
                echo "<div class='col-md-3'>";
                echo "<img src='images/{$row['Image']}' class='card-img-top' alt='image' object-fit: cover;'>";
                echo "</div>";
                echo "<div class='col-md-9'>";
                echo "<div class='card-body'>";
                echo "<p class='card-text'>";
                echo "<strong>Name:</strong> {$row['Name']}<br>";
                echo "<strong>Email:</strong> {$row['Email']}<br>";
                echo "<strong>Phone:</strong> {$row['Phone']}<br>";
                echo "<strong>Country:</strong> {$row['Country']}<br>";
                echo "<strong>State:</strong> {$row['State']}";
                echo "</p>";
                // Buttons
                echo "<div class='btn-group ' role='group' aria-label='User actions'>";
                echo "<a href='update.php?update_id={$row['Id']}'
        class='btn btn-primary mx-2' >Update</a>";
                echo "<a href='#' class='btn btn-danger delete' data-id={$row['Id']}>Delete</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div> <br>";
            }
        }
        ?>


    </div>



</body>
<script>
    $(document).ready(function() {
        $(document).on("click", ".delete", function() {
            var del = $(this);
            var id = $(this).attr("data-id");
            alert(id);
            $.ajax({
                url: "delete.php",
                type: 'post',
                data: {
                    id: id
                },
                success: function(d) {
                    del.closest('.card').remove();
                }
            });
        });
    });
</script>

</html>