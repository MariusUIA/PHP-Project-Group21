<?php
session_start(); //Original
if(!isset($_SESSION["user"])) {
    header("location: ../Utilities/ErrorPage.php");
}