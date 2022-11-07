<?php
session_start();

if(!isset($_SESSION["user"])) {
    header("location: index.php?msg");
}
echo $_SESSION["user"]["username"];

echo "<a href='Logout.php'>Log out</a>";