<!-- php code -->
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ./Dashboards/dashboard.php");
    exit;
}
 
// Include config file
require_once "./login-script.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM students WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: ./Dashboards/dashboard.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!-- php code -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>


    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <!-- header section starts  -->

    <header class="header">

        <a href="#" class="logo"> <i class="fas fa-heartbeat"></i> <strong>IMSRM</strong></a>

        <nav class="navbar">
            <a href="index.html">home</a>
            <a href="index.html#about">about us</a>
            <a href="index.html#courses">courses</a>
            <a href="index.html#faculty">faculty</a>
            <a href="index.html#review">review</a>
            <a href="index.html#blogs">blogs</a>
            <a href="login.html">login</a>
        </nav>

        <div id="menu-btn" class="fas fa-bars"></div>

    </header>

    <!-- header section ends -->
    <section class="appointment" id="appointment">

        <!-- <h1 class="heading" style="margin-top: 10rem;"> <span>Login</h1> -->

        <div class="row">

            <div class="image" style="margin-top: 2rem; flex:1 1 75rem;">
                <img src="image/appointment-img.svg" alt="">
            </div>
            <div class="heading"></div>
            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>

        </div>

    </section>

        <!-- footer section starts  -->

        <section class="footer">

            <div class="box-container">
    
                <!-- <div class="box">
                    <h3>quick links</h3>
                    <a href="#home"> <i class="fas fa-chevron-right"></i> home </a>
                    <a href="#about"> <i class="fas fa-chevron-right"></i> about </a>
                    <a href="#services"> <i class="fas fa-chevron-right"></i> services </a>
                    <a href="#doctors"> <i class="fas fa-chevron-right"></i> doctors </a>
                    <a href="#appointment"> <i class="fas fa-chevron-right"></i> appointment </a>
                    <a href="#review"> <i class="fas fa-chevron-right"></i> review </a>
                    <a href="#blogs"> <i class="fas fa-chevron-right"></i> blogs </a>
                </div> -->
    
                <div class="box">
                    <h3>Diploma Courses</h3>
                    <a href="AdvanceCourses/CriticalCare.html"> <i class="fas fa-chevron-right"></i> Critical Care </a>
                    <a href="AdvanceCourses/ChildHealthCareManagement.html"> <i class="fas fa-chevron-right"></i> Child Health Care Management </a>
                    <a href="AdvanceCourses/MaternityHealthCareManagement.html"> <i class="fas fa-chevron-right"></i> Maternity Health Care Management </a>
                    <a href="AdvanceCourses/Diabetology.html"> <i class="fas fa-chevron-right"></i> Diabetology </a>
                    <a href="AdvanceCourses/EmergencyMedicalServices.html"> <i class="fas fa-chevron-right"></i> Emergency Medical Services </a>
                </div>
    
                
                <div class="box">
                    <h3>Certificate Courses</h3>
                    <a href="CertificateCourses/CSVD.html"> <i class="fas fa-chevron-right"></i> Skin And Venereal Disease (CSVD) </a>
                    <a href="CertificateCourses/ChildHealth.html"> <i class="fas fa-chevron-right"></i> Child Health </a>
                    <a href="CertificateCourses/CGO.html"> <i class="fas fa-chevron-right"></i> Gynecology And Obstetrics (CGO) </a>
                    <!-- <a href="#"> <i class="fas fa-chevron-right"></i> diagnosis </a>
                    <a href="#"> <i class="fas fa-chevron-right"></i> ambulance service </a> -->
                </div>
    
    
                <div class="box">
                    <h3>Contact info</h3>
                    <a href="#"> <i class="fas fa-phone"></i> +8801688238801 </a>
                    <a href="#"> <i class="fas fa-phone"></i> +8801782546978 </a>
                    <a href="#"> <i class="fas fa-envelope"></i> wincoder9@gmail.com </a>
                    <a href="#"> <i class="fas fa-envelope"></i> sujoncse26@gmail.com </a>
                    <a href="#"> <i class="fas fa-map-marker-alt"></i> </a>
                </div>
    
                <div class="box">
                    <h3>follow us</h3>
                    <!-- <a href="#"> <i class="fab fa-faceappointment-f"></i> faceappointment </a> -->
                    <a href="#"> <i class="fab fa-twitter"></i> twitter </a>
                    <!-- <a href="#"> <i class="fab fa-twitter"></i> twitter </a> -->
                    <a href="#"> <i class="fab fa-instagram"></i> instagram </a>
                    <a href="#"> <i class="fab fa-linkedin"></i> linkedin </a>
                    <!-- <a href="#"> <i class="fab fa-pinterest"></i> pinterest </a> -->
                </div>
    
            </div>
    
            <div class="credit"> created by <span>Rajesh</span> | all rights reserved </div>
    
        </section>
    
        <!-- footer section ends -->

    <script src="js/script.js"></script>
</body>

</html>