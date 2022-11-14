<?php
session_start(); //Må ikke bruke include her
session_destroy();
header("location: Login.php");