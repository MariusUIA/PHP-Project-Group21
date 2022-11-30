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
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .listingsContainer {

        }


         img {
            object-fit: contain;
            width: auto;
            height: 5rem;
        }

        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }

        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }

        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }

        th,
        td {
            font-weight: bold;
            border: 0px solid black;
            padding: 10px;
            text-align: center;
        }

        td {
            font-weight: lighter;
        }


    </style>

</head>
<body>
<main>
<h1>My listings</h1>

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
    $image = "../images/secondaryImages/" . $row['listingID'] . "." . $imageType;
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

