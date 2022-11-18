<?php
session_start();
if (isset($_SESSION['adm']) != "") {
    header("location: ../dashboard.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}
require_once "../components/db_connect.php";

// Select all from pets
if ($_POST) {
    $pet_id = $_POST['pet_id'];
    $query = "SELECT * FROM pets WHERE pet_id = {$pet_id}";
    $pet_res = mysqli_query($connect, $query);
    $data = mysqli_fetch_assoc($pet_res);
    $name = $data['name'];
    $age = $data['age'];
    $picture = $data['picture'];
    $location = $data['location'];
    $description = $data['description'];
    $size = $data['size'];
    $vaccination = $data['vaccination'];
    $breed = $data['breed'];
    $status = $data['status'];
}

//user 
$query_user = "SELECT * FROM users WHERE user_id = {$_SESSION['user']}";
$user_res = mysqli_query($connect, $query_user);
$data_user = mysqli_fetch_assoc($user_res);
$fname = $data_user['first_name'];
$lname = $data_user['last_name'];
$picture_user = $data_user['picture'];
$email = $data_user['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt - Sheltered</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-paw me-3"></i>Sheltered</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>

            <p> <a href="logout.php?logout">Logout</a></p>

            <p> <a href="update.php?id=<?php echo $_SESSION['user'] ?>">Update Profile</a></p>
        </div>
    </nav>


    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>Adopt <?php $name ?></h1>
            <img src="../pictures/<?php echo $picture; ?>" alt="" width='150' height='150' class="dashboard-pic">
        </div>
    </div>

    <!------------------
 Form
-------------------->

    <div class="container">



        <form action="actions/a_adopt.php" method="post">
            <input type="date" name="adoption_date" />
            <input type='hidden' name='pet_id' value='<?php echo $pet_id ?>' />
            <input type="hidden" name='new_status' value="adopted">
            <button type='submit' name='submit' class='btn btn-outline-dark'>adopt!</button>
        </form>


    </div>

</body>

</html>