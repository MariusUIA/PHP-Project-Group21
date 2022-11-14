<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";

$userID = $_SESSION["user"]["userID"];

$sql = "SELECT * FROM listings WHERE userID = $userID";
$result = $connection->query($sql);

if (isset($_GET['button'])) {
    header("location: ListingDetails.php?listingID=" . $_GET['button']);
}
?>

<html lang="NO">
<head>
    <title>Mine annonser</title>
    <link rel="stylesheet" href="../css/MyListings.css" media="screen">
</head>
<body>
<main>
<h1>My listings</h1>

<div class="listingsContainer">
<?php
if($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    $title = $row["listingTitle"];
    echo "<h2>$title<a href=>Visit listing</a></h2>";
    echo "<form action='ListingDetails.php' method='get'><button type='submit' name='listingID' 
    value=" . $row['listingID'] . ">Se hus</button></form>";

    }
}
?>
</div>
</main>

</body>
</html>
