<?php
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

echo '<p>' . $_SESSION["user"]["email"] . '</p>';

?>
<html lang="NO">
<head>
    <title>Hjemmeside</title>
</head>
<body>
<p><a href='Inbox.php'>Inbox</a></p>
<p><a href='Listings.php'>Listings</a></p>
<p><a href='CreateListing.php'>Create listing</a></p>
<p><a href='MyListings.php'>My listings</a></p>
<p><a href='Logout.php'>Log out</a></p>
</body>
</html>
