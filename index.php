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

            $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed_password'";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];

                header("Location: dashboard.php");
                exit();
            } else {
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
    <div class="wrapper">
        <form action="" method="POST">
            <h1>Login</h1>
            <?php
                if (isset($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }
            ?>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
