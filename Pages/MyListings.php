<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

$userID = $_SESSION["user"]["userID"];

$sql = "SELECT * FROM listings INNER JOIN listingimages ON listings.listingID=listingimages.listingID WHERE userID = '$userID' AND listingimages.listingMainImg = 1";
$result = $connection->query($sql);

if (isset($_GET['button'])) {
    header("location: ListingDetails.php?listingID=" . $_GET['button']);
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/MyListings.css">
</head>
<body>
<main>
<table class="listingsContainer">
    <tr>
    <th>Title</th>
    <th>Type</th>
    <th>Addresse</th>
    <th>Antall Rom</th>
    <th>Pris</th>
    </tr>
<?php
if($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    $imageType = $row["listingImgType"];
    $image = "../images/" . $row['listingID'] . "." . $imageType;
    $title = $row["listingTitle"];
    $type = $row["listingType"];
    $address = $row["listingAddress"];
    $rooms = $row["listingRooms"];
    $price = $row["listingPrice"];
    echo "<tr>";
    echo "<td>$title</td>";
    echo "<td>$type</td>";
    echo "<td>$address</td>";
    echo "<td>$rooms</td>";
    echo "<td>$price</td>";
    echo "<td><img class='imageLOL' src='$image'></td>";
    echo "<td><form action='ListingDetails.php' method='get'><button type='submit' name='listingID' 
    value=" . $row['listingID'] . ">Se hus</button></form></td>";
    }
    echo "</tr>";
}
?>
</table>
</main>

</body>
</html>

