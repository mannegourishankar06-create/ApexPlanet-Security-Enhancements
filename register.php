<?php
include("db.php");

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $rawPassword = $_POST['password'];

    if(empty($username))
    {
        die("Username is required");
    }

    if(empty($email))
    {
        die("Email is required");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        die("Invalid Email");
    }

    if(strlen($rawPassword) < 6)
    {
        die("Password must be at least 6 characters");
    }

    $password = password_hash(
        $rawPassword,
        PASSWORD_DEFAULT
    );

    $stmt = $conn->prepare(
        "INSERT INTO users(username,email,password)
         VALUES(?,?,?)"
    );

    $stmt->bind_param(
        "sss",
        $username,
        $email,
        $password
    );

    $stmt->execute();

    echo "Registration Successful";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>User Registration</h2>

<form method="POST">

    Username:
    <input type="text" name="username" required><br><br>

    Email:
    <input type="email" name="email" required><br><br>

    Password:
    <input type="password" name="password" required><br><br>

    <input type="submit" name="register" value="Register">

</form>

</body>
</html>