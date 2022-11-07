<?php
include_once "../Utilities/DatabaseConnection.php";

session_start();
if(isset($_GET['msg']))
{
    $message = "You need to be logged in to access that page";
    echo $message;
}

if(isset($_SESSION["user"])) header("location: homePage.php");

if(isset($_REQUEST["login_btn"])) {
    $username = filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
    $password = strip_tags($_REQUEST["password"]);

    if (empty($username)) {
        $errorMsg[0][] = "Name Required";
    }
    if (empty($password)) {
        $errorMsg[1][] = "Password Required";
    }
    if(empty($errorMsg)) {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(password_verify($password, $row["password"])) {
                    $_SESSION["user"]["username"] = $row["username"];
                    $_SESSION["user"]["email"] = $row["email"];
                    header("location: homePage.php");
                } else {
                    echo "<p>Wrong email or password</p>";
                }
            }
        }
    }
}
?>
<html>
<head>
</head>
<body>

<?php
if(isset($errorMsg[0])) {
    foreach($errorMsg[0] as $usernameErrors) {
        echo "<p>$usernameErrors</p>";
    }
}
if(isset($errorMsg[1])) {
    foreach($errorMsg[1] as $passwordErrors) {
        echo "<p>$passwordErrors</p>";
    }
}

?>
<form action='index.php' method='post'>
    <label for='username'>Username: </label>
    <input name='username' type='text' /><br>
    <label for='password'>Password: </label>
    <input name='password' type='password' /><br>
    <button type='submit' name="login_btn">Log in</button>
</form>
</body>
</html>


