<?php
session_start();
include("db.php");

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE username=?"
    );

    $stmt->bind_param(
        "s",
        $username
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();

        if(password_verify($password,$row['password']))
        {
            $_SESSION['username'] = $row['username'];

            $_SESSION['role'] = $row['role'];

            session_regenerate_id(true);

            header("Location:index.php");
            exit();
        }
        else
        {
            echo "Invalid Password";
        }
    }
    else
    {
        echo "User Not Found";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>User Login</h2>

<form method="POST">

Username:
<input type="text" name="username" required><br><br>

Password:
<input type="password" name="password" required><br><br>

<input type="submit" name="login" value="Login">

</form>

</body>
</html>