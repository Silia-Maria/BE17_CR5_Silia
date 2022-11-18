<?php
session_start();
if (isset($_SESSION['adm']) != "") {
    header("location: ../../dashboard.php");
    exit;
}
if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: ../../index.php");
    exit;
}

require_once "../../components/db_connect.php";

if ($_POST) {
    $pet_id = $_POST['pet_id'];
    $user_id = $_SESSION['user'];
    $adoption_date = $_POST['adoption_date'];
    $new_status = "adopted";
    $sql = "INSERT INTO pet_adoption(adoption_date, fk_user_id, fk_pet_id) VALUES ('$adoption_date',$user_id,$pet_id)";
    $sql_pets = "UPDATE pets set status = '$new_status' WHERE pet_id = {$pet_id}";
    $pets_res = mysqli_query($connect, $sql_pets);

    if (mysqli_query($connect, $sql) === TRUE) {
        $icon = "<i class='fa-regular fa-circle-check text-success icon-alert'></i>";
        $message = "<div>Congrats - you just adopted your Pet!</div>";
    } else {
        $icon = "<i class='fa-regular fa-circle-xmark text-danger'></i>";
        $message = "Error while adopting your Room. Please try again.. <br>" . $connect->error;
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption - Sheltered</title>
    <?php require_once "../../components/style.php" ?>
    <link rel="stylesheet" href="../../style.css">
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
            <p> <a href="../../logout.php?logout">Logout</a></p>
            <p> <a href="../../update.php?id=<?php echo $_SESSION['user'] ?>">Update Profile</a></p>
        </div>
    </nav>

    <!------------------
Alert
-------------------->

    <div class="container mt-5">
        <div class="w-50 mx-auto border rounded text-center p-5">
            <div class="mb-4"><?php echo $icon ?></div>
            <h5><?php echo $message ?></h5>
            <a href="../../home.php"><button class="btn btn-outline-dark mt-3">Go Back</button></a>
        </div>

    </div>
</body>

</html>