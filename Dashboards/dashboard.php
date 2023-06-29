<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php
// session_start();
include_once "./config/dbconnect.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="dashboardstyle.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Admin Dashboard</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">IMSRM Portal</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Enrolled Students</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Students Details</span>
                    </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Like</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Comment</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
            </ul>

            <ul class="logout-mode">
                <li><a href="#">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>

            <!-- <img src="images/profile.jpg" alt=""> -->
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="boxes">
                    <div class="box box1">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="text">Total Students</span>
                        <span class="number">50,120</span>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-comments"></i>
                        <span class="text">Enrolled Students</span>
                        <span class="number">20,120</span>
                    </div>
                    <div class="box box3">
                        <i class="uil uil-share"></i>
                        <span class="text">Not Enrolled Students</span>
                        <span class="number">10,120</span>
                    </div>
                </div>
            </div>
            <div id="ordersBtn">
                <h2>Order Details</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">id</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">number</th>
                            <!-- <th class="text-center">Category Name</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center" colspan="2">Action</th> -->
                        </tr>
                    </thead>
                    <?php
                    include_once "config/dbconnect.php";
                    $sql = "SELECT * from contact_form";
                    $result = $conn->query($sql);
                    $count = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr style="text-align: center;">
                                <td><?= $count ?></td>
                                <!-- <td><img height='100px' src='<?= $row["product_image"] ?>'></td> -->
                                <td><?= $row["name"] ?></td>
                                <td><?= $row["email"] ?></td>
                                <td><?= $row["number"] ?></td>
                                <!-- <td><?= $row["price"] ?></td> -->
                                <!-- <td><button class="btn btn-primary" style="height:40px" onclick="itemEditForm('<?= $row['product_id'] ?>')">Edit</button></td>
                                <td><button class="btn btn-danger" style="height:40px" onclick="itemDelete('<?= $row['product_id'] ?>')">Delete</button></td> -->
                            </tr>
                    <?php
                            $count = $count + 1;
                        }
                    }
                    ?>
                </table>

            </div>

        </div>
    </section>

    <script src="dashboardscript.js"></script>
</body>

</html>