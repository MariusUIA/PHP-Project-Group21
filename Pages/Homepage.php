<?php
include_once "../Utilities/SessionHandler.php";

echo $_SESSION["user"]["email"];

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
