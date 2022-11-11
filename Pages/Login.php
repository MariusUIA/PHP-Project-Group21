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
    $userName = strip_tags($_REQUEST["userName"]);
    $pass = strip_tags($_REQUEST["pass"]);

    if (empty($userName)) {
        echo("<p> Name Required </p>");
    }
    if (empty($pass)) {
        echo("<p> Password Required </p>");
    }
    if(!empty($userName) && !empty($pass)) {
        $sql = "SELECT * FROM user WHERE userName = '$userName'";
        $result = $connection->query($sql);
        if($result->num_rows > 0) {
            echo ("success11?");
            while($row = $result->fetch_assoc()) {
                if(password_verify($pass, $row["pass"])) {
                    $_SESSION["user"]["userName"] = $row["userName"];
                    header("location: Homepage.php");
                    echo("success!");
                } else {
                    echo "<p>Wrong username or password</p>";
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
    <label for='username'>Username: </label>
    <input name='userName' type='text' /><br>
    <label for='password'>Password: </label>
    <input name='pass' type='password' /><br>
    <button type='submit' name="login_button">Log in</button>
</form>
</body>
</html>
