<?php
include_once "../Utilities/DatabaseConnection.php";

session_start();
if(isset($_SESSION["user"])) {
    header("location: homePage.php");
}

if(isset($_REQUEST["register_btn"])) {
    $username = filter_var($_REQUEST["username"], FILTER_SANITIZE_STRING);
    $email = filter_var($_REQUEST["email"], FILTER_SANITIZE_EMAIL);
    $password = strip_tags($_REQUEST["password"]);

    if (empty($username)) {
        $errorMsg[0][] = "Name Required";
    }
    if (empty($email)) {
        $errorMsg[1][] = "Email Required";
    }
    if (empty($password)) {
        $errorMsg[2][] = "Password Required";
    }
    if(empty($errorMsg)) {

        $sql = "SELECT email FROM users WHERE email = '$email'";
        $result = $connection->query($sql);
        if($result->num_rows == 0) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username,password,email) 
                VALUES ('$username', '$hashed_password', '$email')";
            $connection->query($sql);
            header("location: index.php");
        } else {
            $errorMsg[1][] = "Email already taken";
        }
    }
}
?>
<html>
<head>
</head>
<body>
<form action='register.php' method='post'>

    <?php
    if(isset($errorMsg[0])) {
        foreach($errorMsg[0] as $usernameErrors) {
            echo "<p>$usernameErrors</p>";
        }
    }
    if(isset($errorMsg[1])) {
        foreach($errorMsg[1] as $emailErrors) {
            echo "<p>$emailErrors</p>";
        }
    }
    if(isset($errorMsg[2])) {
        foreach($errorMsg[2] as $passwordErrors) {
            echo "<p>$passwordErrors</p>";
        }
    }
    ?>

    <label for='username'>Username: </label>
    <input name='username' type='text' maxlength="64" /><br>

    <label for='email'>Email: </label>
    <input name='email' type='text' maxlength="256" /><br>

    <label for='password'>Password: </label>
    <input name='password' type='password' maxlength="256" minlength="6" /><br>

    <button type='submit' name="register_btn">Register</button>
</form>
</body>
</html>

