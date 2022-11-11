<?php
session_start();

if(!isset($_SESSION["user"])) {
    header("location: ErrorPage.php");
}
echo $_SESSION["user"]["email"];

echo "<p><a href='Logout.php'>Log out</a></p>";