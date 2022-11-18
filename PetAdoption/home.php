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

// select logged in user details
$result = mysqli_query($connect, "SELECT * FROM users WHERE user_id =" . $_SESSION['user']);
$row = mysqli_fetch_assoc($result);

// select all from pets
$query_pets = "SELECT * FROM pets";
$resPets = mysqli_query($connect, $query_pets);
$petscard = "";
$seniorcard = "";
$card = "";
$emptycard = "<div class='swiper-slide'>
<div class='card' style='width: 18rem;'>
    <img src='https://images.unsplash.com/photo-1606103897759-4ea5eea942b2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=774&q=80' class='card-img-top'>
    <div class='card-body'>
        <h5 class='card-title'>Sorry no Pets available</h5>
    </div>
</div>
</div>";


if (mysqli_num_rows($resPets) > 0) {
    while ($rowPets = mysqli_fetch_assoc($resPets)) {
        $card = "<div class='swiper-slide'>
        <div class='card' style='width: 18rem;'>
            <img src='pictures/" . $rowPets['picture'] . "' class='card-img-top' alt='" . $rowPets['name'] . "'>
            <div class='card-body'>
                <h5 class='card-title'>" . $rowPets['name'] . "</h5>
                <p class='card-text'>" . $rowPets['description'] . "</p>
                <a href='details.php?id=" . $rowPets['pet_id'] . "' class='btn btn-outline-dark'>About " . $rowPets['name'] . "</a>
            </div>
        </div>
    </div>";

        // Where Seniors and rest should be printed
        if ($rowPets['age'] >= 8) {
            $seniorcard .= $card;
        } else {
            $petscard .= $card;
        }
    }
} else {
    $card = $emptycard;
}
// check if seniors is empty 
$sql_senior = "SELECT * FROM pets WHERE age >= 8";
$senior_row = mysqli_query($connect, $sql_senior);
if (mysqli_num_rows($senior_row) == 0) {
    $seniorcard = $emptycard;
}

// check if pets is empty 
$sql_pets = "SELECT * FROM pets WHERE age < 8";
$pets_row = mysqli_query($connect, $sql_pets);
if (mysqli_num_rows($pets_row) == 0) {
    $petscard = $emptycard;
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sheltered</title>
    <?php require_once "components/style.php"; ?>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
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

    <div class="container mt-5">
        <div class="text-center mb-5">
            <h2>Welcome to Shelterd Animal Adoption</h2>
            <div class="mb-3">____</div>
            <p>A lot of Animals are in need for a new home and a loving and caring Owner. Adopting a Pet is extremly rewarding since Animals are thankful everday and they will let you feel that. Don't Shop - Adopt your loyal Friend and enjoy your new life with them!</p>
        </div>

        <!---Seniors-->

        <h3>Adopt Seniors</h3>
        <hr>
        <div class="swiper mySwiper my-4">
            <div class="swiper-wrapper">
                <?php echo $seniorcard ?>
            </div>
            <div class="swiper-button-next text-light"></div>
            <div class="swiper-button-prev text-light"></div>
        </div>

        <!---Pets-->

        <h3>Adopt Pets</h3>
        <hr>
        <div class="swiper mySwiper my-4">
            <div class="swiper-wrapper">
                <?php echo $petscard ?>
            </div>
            <div class="swiper-button-next text-light"></div>
            <div class="swiper-button-prev text-light"></div>
        </div>
    </div>


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 4,
            spaceBetween: 30,
            slidesPerGroup: 4,
            loop: true,
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>


</body>

</html>