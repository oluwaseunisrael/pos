 <?php
include "config/dbcon.php";
session_start();

if (isset($_POST['submit'])) {
    // Use isset to avoid undefined index errors
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

    if ($email == '' || $password == '') {
        $_SESSION['status'] = "Fill the Email or password Box";
        header("Location: login.php");
        exit();
    } else {
        $checkemail = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $checkemail);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];
                // $password_verify = password_verify($password, $hashedPassword);
                if ($password !== $hashedPassword ) {
                    $_SESSION['status'] = "Invalid password";
                    header("Location: login.php");
                    exit();
                } else {
                    if ($row['is_ban'] == 1) {
                        $_SESSION['status'] = "You are banned. Contact the admin.";
                        header("Location: login.php");
                        exit();
                    } else {
    // Successful login
    $_SESSION['loginInUser'] = True;
    $_SESSION['admin'] = $row; // Example of setting a session variable
    header("Location: admin/index.php");
    exit();
}
                }
            } else {
                $_SESSION['status'] = "Invalid email";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "Database query failed";
            header("Location: login.php");
            exit();
        }
    }
}
?>
