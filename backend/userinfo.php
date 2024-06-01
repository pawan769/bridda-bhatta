<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Info</title>
    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Include Bootstrap JavaScript with jQuery dependency -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="userinfo.css">
</head>
<body>
    <?php
    require 'connection.php';

    // Fetch cit_id from URL parameter
    $_cit_id = isset($_GET['cit_id']) ? $_GET['cit_id'] : null;

    // Ensure cit_id is provided
    if (!$_cit_id) {
        die("Citizen ID is required.");
    }

    // Fetch user information
    $sql = "SELECT * FROM register_info WHERE cit_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_cit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['cit_id'];
        $full_name = $row['full_name'];
        $phone = $row['phone_no'];
        $email = $row['email'];
        $date_birth = $row['DOB'];
        $gender = $row['gender'];

        // Calculate age
        $d_of_birth = new DateTime($date_birth);
        $now = new DateTime();
        $age = $now->diff($d_of_birth);
    } else {
        die("No user found with the provided ID.");
    }

    // Fetch user image
    $img_path = "";
    $sql = "SELECT * FROM image_info WHERE cit_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_cit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $img_path = $row['img_name'];
    } else {
        $img_path = 'path/to/default_image.png'; // Default image path
    }

    $stmt->close();
    $conn->close();
    ?>
    <div class="head_imgs">
      <img src="../images/coatOfArms.png" />
      <div class="middleText">
        <h4 style="color: red">Government of Nepal</h4>
        <h2>Senior Allowance Scheme</h2>
      </div>
      <img src="../images/nepal_flag.gif" />
    </div>

    <nav>
      <div class="nav-links" id="navLinks">
        <i class="fa-solid fa-xmark" onclick="hideMenu()"></i>
        <ul>
          <li><a href="../index.html">Home</a></li>
          <li><a href="#abt">About</a></li>
          <li><a href="about.pdf" target="_blank">Policy</a></li>
          <li><a href="#ftr">Contact</a></li>
          <li><a href="./login.html">LOGIN</a></li>
        </ul>
      </div>
      <i class="fa-solid fa-bars" onclick="showMenu()"></i>
    </nav>

    <section class="vh-80" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-10 mb-4 mb-lg-0">
                    <div class="card mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="<?php echo htmlspecialchars($img_path); ?>" alt="Loading" class="img-fluid my-5" style="width: 200px;height:200px; border-radius:50%;" />
                                <h5><?php echo htmlspecialchars($full_name); ?></h5>
                                <p><?php echo htmlspecialchars($email); ?></p>
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6 class="text-center">User Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Citizenship ID</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($_cit_id); ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Phone</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($phone); ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col-6 mb-3">
                                            <h6>Date of Birth</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($date_birth); ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>Gender</h6>
                                            <p class="text-muted"><?php echo htmlspecialchars($gender); ?></p>
                                        </div>
                                    </div>
                                    <div class="row pt-3">
                                        <div class="col-6 mb-3">
                                            <h6>Age</h6>
                                            <p class="text-muted"><?php echo $age->y . " Years " . $age->m . " Months " . $age->d . " Days"; ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <form action="account_info.php" method="get">
                                                <input type="hidden" name="cit_id" value="<?php echo htmlspecialchars($_cit_id); ?>">
                                                <button class="btn btn-primary profile-button" type="submit">View Account</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
