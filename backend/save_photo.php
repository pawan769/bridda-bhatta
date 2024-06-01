<?php

error_reporting(E_ALL); // Enable error reporting for debugging

// for profile photo
if (isset($_POST['submit'])) {
    $cit_id = $_POST["id"];
    $flag1 = 0;
    $flag2 = 0;

    // Database connection variables
    $server_name = 'localhost';
    $user_name = 'root';
    $password = "";
    $dbname = "e_governance";
    $conn = mysqli_connect($server_name, $user_name, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare file paths
    $Pfilename = basename($_FILES["personal_photo"]["name"]);
    $PtmpName = $_FILES['personal_photo']["tmp_name"];
    $Pfolder = "uploads/" . $Pfilename;

    $Cfilename = basename($_FILES["cit_photo"]["name"]);
    $CtmpName = $_FILES['cit_photo']["tmp_name"];
    $Cfolder = "uploads/" . $Cfilename;

    // Move uploaded files
    if (move_uploaded_file($PtmpName, $Pfolder)) {
        $flag1 = 1;
    }

    if (move_uploaded_file($CtmpName, $Cfolder)) {
        $flag2 = 1;
    }

    if ($flag1 == 1 && $flag2 == 1) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO image_info (cit_id, img_name, cit_image) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $cit_id, $Pfolder, $Cfolder);
        
        if ($stmt->execute()) {
            $amount = 0;
            $current_date = (new DateTime())->format('Y-m-d');

            // Insert into account_info
            $stmt2 = $conn->prepare("INSERT INTO account_info (cit_id, Amount, arrival_date, withdraw_date) VALUES (?, ?, ?, null)");
            $stmt2->bind_param("ids", $cit_id, $amount, $current_date);
            
            if ($stmt2->execute()) {
                header("Location: login.html");
                exit();
            } else {
                echo "<script>alert('Error in creating account');</script>";
            }
        } else {
            header("Location: upload_photos.php?id=" . urlencode($cit_id));
            exit();
        }

        $stmt->close();
        $stmt2->close();
    } else {
        header("Location: upload_photos.php?id=" . urlencode($cit_id));
        exit();
    }

    $conn->close();
}
?>
