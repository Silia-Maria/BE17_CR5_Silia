<?php
session_start();
require_once "components/db_connect.php";

if (isset($_SESSION['adm'])) {
    header("location: dashboard.php");
    exit;
}

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}

if ($_GET['id']) {
    $pet_id = $_GET['id'];
    $sql = "SELECT * FROM pets WHERE pet_id = {$pet_id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $age = $data['age'];
        $picture = $data['picture'];
        $location = $data['location'];
        $description = $data['description'];
        $size = $data['size'];
        $vaccination = $data['vaccination'];
        $breed = $data['breed'];
        $status = $data['status'];
        // print data
        $detail = "<div class='row my-5'>
        <img src='./pictures/" . $picture . "' class='col-6' alt='" . $name . "'>
        <div class='col-6 '>
            <div class='m-5'>
                <h3 class='mb-5'>" . $name . " is...</h3>
                <p><em>" . $description . "</em></p>
                <h4>Info:</h4>
                <ul>
                    <li>Age: " . $age . " years</li>
                    <li>Size: " . $size . " cm</li>
                    <li>Vaccinated: " . $vaccination . "</li>
                    <li>Breed: " . $breed . "</li>
                    <li>Status: " . $status . "</li>
                </ul>
                
                <input type='hidden' name='pet_id' value='" . $pet_id . "'/>
                <button type='submit' name='submit' class='btn btn-outline-dark'>Adopt Me!</button>
                <a href='home.php'><button class='btn btn-outline-dark' type='button'>Go Back</button></a>

                
            
                
            </div>
        </div>
    </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details - Shelterd</title>
    <?php require_once "components/style.php"; ?>
    <link rel="stylesheet" href="style.css">
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

    <div class="home-hero">
        <div class="hero-text">
            <h2>Don't Shop, Adopt!</h2>
        </div>
    </div>

    <!------------------
  Content
-------------------->

    <div class="container">
        <?php echo $detail ?>

    </div>

</body>

</html>