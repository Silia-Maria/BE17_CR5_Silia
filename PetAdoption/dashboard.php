<?php
// only available for admin!!
session_start();
require_once "components/db_connect.php";

if (!isset($_SESSION['adm']) && !isset($_SESSION['user'])) {
    header("location: index.php");
    exit;
}
if (isset($_SESSION['user'])) {
    header("location: home.php");
    exit;
}

$id = $_SESSION['adm'];
$status = 'adm';
$sql = "SELECT * FROM users WHERE status != '$status'";
$result = mysqli_query($connect, $sql);

// showing the adoption in dashboard
$adopt_query = "SELECT * FROM pets JOIN pet_adoption On (pet_id) = (fk_pet_id)";
$result_adopt = mysqli_query($connect, $adopt_query);
$data = mysqli_fetch_assoc($result_adopt);

// Body for displaying the users
$tbody = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        //if number was empty because its not required to register 
        $number = "";
        if (empty($row['phone_number'])) {
            $number = "no number provided";
        } else {
            $number = $row['phone_number'];
        }
        $tbody .= "<tr>
        <td>
            <img src='pictures/" . $row['picture'] . "' alt='' class='user-pic'>
        " . $row['first_name'] . " " . $row['last_name'] . "
        </td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['address'] . "</td>
        <td>" . $number . "</td>
        <td>" . $data['name'] . "</td>
       
       
    </tr>";
    }
} else {
    $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

// <td>" . $data['name'] . "</td>

// adm details
$query = "SELECT * FROM users WHERE status = '$status'";
$result_adm = mysqli_query($connect, $query);
if ($result_adm->num_rows > 0) {
    $row_adm = mysqli_fetch_assoc($result_adm);
    $adm_name = $row_adm['first_name'] . " " . $row_adm['last_name'];
}

// Pets
$sql_pets = "SELECT * FROM pets";
$result_pets = mysqli_query($connect, $sql_pets);
$pets_body = "";

if ($result_pets->num_rows > 0) {
    while ($row_pets = $result_pets->fetch_array(MYSQLI_ASSOC)) {
        $pets_body .= "<tr>
        <td>
            <img src='pictures/" . $row_pets['picture'] . "' alt='' class='user-pic'>
            " . $row_pets['name'] . "
        </td>
        <td> " . $row_pets['description'] . "</td>
        <td>
        <ul>
            <li>Age: " . $row_pets['age'] . " years</li>
            <li>Size: " . $row_pets['size'] . " cm</li>
            <li>Vaccinated: " . $row_pets['vaccination'] . "</li>
            <li>Breed: " . $row_pets['breed'] . "</li>
           
        </ul>
    </td>
        <td>" . $row_pets['location'] . "</td>
        <td> " . $row_pets['status'] . "</td>
        <td>
        <a href='pets/update.php?id=" . $row_pets['pet_id'] . "'><button class='btn btn-outline-dark btn-sm'>Edit</button></a>
        <a href='pets/delete.php?id=" . $row_pets['pet_id'] . "'><button class='btn btn-outline-dark btn-sm'>Delete</button></a>
        </td>
    </tr>";
    }
} else {
    $hotel_body = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sheltered</title>
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

            <p> <a href="update.php?id=<?php echo $_SESSION['adm'] ?>">Update Profile</a></p>
        </div>
    </nav>

    <!------------------
   Hero
-------------------->
    <div class="dashboard-hero">
        <div class="dashboard-text">
            <img src="pictures/<?php echo $row_adm['picture'] ?>" alt="" width='150' height='150' class="dashboard-pic">
            <h3 class="mt-3"><?php echo $adm_name ?></h3>
        </div>
    </div>

    <!------------------
 User Table
-------------------->
    <div class="container mt-5">
        <!--User Table-->
        <h2>Users</h2>
        <hr>
        <table class="table mb-5">
            <thead class="text-uppercase">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Adoption</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $tbody ?>
            </tbody>
        </table>

        <!--Hotels table-->
        <div class="d-flex justify-content-between">
            <h2>Hotels</h2>
            <a href="pets/create.php"> <button class="btn btn-sm btn-outline-dark"> add new pet</button></a>
        </div>
        <hr>
        <table class="table">
            <thead class="text-uppercase">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Info</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $pets_body ?>

            </tbody>

        </table>


    </div>

</body>

</html>