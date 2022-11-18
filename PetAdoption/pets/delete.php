<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: ../home.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../index.php");
    exit;
}

require_once "../components/db_connect.php";

// From Delete Button Button
if ($_GET['id']) {
    $pet_id = $_GET['id'];
    $sql = "SELECT * FROM pets WHERE pet_id = {$pet_id}";
    $result = mysqli_query($connect, $sql);
    $data = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) == 1) {
        $name = $data['name'];
        $picture = $data['picture'];
        $location = $data['location'];
        $description = $data['description'];
        $size = $data['size'];
        $vaccination = $data['vaccination'];
        $breed = $data['breed'];
        $status = $data['status'];
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete - Sheltered</title>
    <?php require_once "../components/style.php"; ?>
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <!------------------
    Nav Bar
-------------------->
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sheltered</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            </div>

            <p> <a href="../logout.php?logout">Logout</a></p>

        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <h1>Delete Request for: <br> <?php echo $name ?></h1>
        </div>
    </div>

    <!------------------
 Content
-------------------->
    <div class="container">

        <div class="d-flex">
            <img src="../pictures/<?php echo $data['picture'] ?>" class="user-pic">
            <h5><?php echo $name ?> </h5>
        </div>
        <h5>Info about <?php echo $name ?></h5>
        <p>description: <?php echo $description ?></p>

        <ul>
            <li>Age: <?php echo $age ?></li>
            <li>Size: <?php echo $size ?></li>
            <li>Vaccinated: <?php echo $vaccination ?></li>
            <li>Breed: <?php echo $breed ?></li>
            <li>Status: <?php echo $status ?></li>
        </ul>

        <h3>Do you really want to delelte <?php echo $name ?>?</h3>
        <form action="actions/a_delete.php" method="post">
            <input type="hidden" name="pet_id" value="<?php echo $data['pet_id'] ?>">
            <input type="hidden" name="picture" value="<?php echo $data['picture'] ?>">
            <button class="btn btn-outline-dark" type="submit">Yes, delete!</button>
            <a href="../dashboard.php"><button class="btn btn-outline-dark" type="button">No, go back!</button></a>
        </form>

</body>

</html>