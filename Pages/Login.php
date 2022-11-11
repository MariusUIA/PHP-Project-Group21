<?php
include_once "../Utilities/DatabaseConnection.php";

session_start();
if(isset($_GET['msg']))
{
    $message = "You need to be logged in to access that page";
    echo $message;
}

if(isset($_SESSION["user"])) header("location: Homepage.php");

if(isset($_REQUEST["login_button"])) {
    $email = strip_tags($_REQUEST["email"]);
    $pass = strip_tags($_REQUEST["pass"]);

    if (empty($email)) {
        echo("<p> Email Required </p>");
    }
    if (empty($pass)) {
        echo("<p> Password Required </p>");
    }
    if(!empty($email) && !empty($pass)) {
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = $connection->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(password_verify($pass, $row["pass"])) {
                    $_SESSION["user"]["email"] = $row["email"];
                    header("location: Homepage.php");
                } else {
                    echo "<p>Wrong email or password</p>";
                }
            }
        }
    }
}
mysqli_close($connection);
?>
<html>
<head>
</head>
<body>
<form action='Login.php' method='post'>
    <label for='email'>Email: </label>
    <input name='email' type='text' /><br>
    <label for='password'>Password: </label>
    <input name='pass' type='password' /><br>
    <button type='submit' name="login_button">Log in</button>
</form>
</body>
</html>
