<?php
include('includes/config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (empty($email) || empty($password)) {
            $error_message = "Email and password are required!";
        } else {
            $hashed_password = md5($password);
            //echo $hashed_password;
            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
            $result = $conn->query($sql);
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Check if the email also exists in the 'members' table
                $member_check_sql = "SELECT * FROM members WHERE email = '$email'";
                $member_result = $conn->query($member_check_sql);
                $memberRow = $member_result->fetch_assoc();
                // Password is correct, set session variables
                if ($member_result->num_rows == 1) {
                    // Member is found, login successful
                    // Set session variables
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['role'] = $memberRow['role'];
                    $_SESSION['member_id'] = $memberRow['id'];
                    $paymentSql = "SELECT date FROM payment WHERE member = '" . $row['id'] . "' ORDER BY created_at DESC LIMIT 1";
                    $resultPayment = $conn->query($paymentSql);
                    $rowPayment = $resultPayment->fetch_assoc();

                    $paymentDate = new DateTime($rowPayment['date']);
                    $currentDate = new DateTime();

                    $interval = $paymentDate->diff($currentDate);
                    if ($interval->m >= 1 || $interval->y > 0) {
                        header("Location: payment.php");
                    } else {
                        // User has paid for this month
                        header("Location: dashboard.php");
                    }
                } else {
                    // Email is not found in the 'members' table
                    $error_message = "Email not found in the members list!";
                }
            } else {
                // Password is incorrect
                $error_message = "Invalid email or password!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="dist/css/admin-login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <div class="wrapper  ">
        <form action="" method="POST" class="">
            <h1>Login</h1>
            <?php
            if (isset($error_message)) {
                echo '<div class="alert alert-danger">' . $error_message . '</div>';
            }
           
            ?>

            <div class="input-box ">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-user' style="color: #93bb3f;"></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt ' style="color: #93bb3f;"></i>
            </div>

            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>
</body>

</html>