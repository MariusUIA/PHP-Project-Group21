<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

$userID = $_SESSION["user"]["userID"];

$sql = "SELECT * FROM listings WHERE userID = $userID";
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
            outline: solid red;
            height: 100vh;
            width: 100%;
        }

        .listingsContainer {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .listingsContainer > img {
            object-fit: contain;
            width: auto;
            height: 5rem;
        }


    </style>

</head>
<body>
<main>
<h1>My listings</h1>

<div class="listingsContainer">
<?php
if($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    $image = "../images/" . $row["userID"] . ".jpg";
    $title = $row["listingTitle"];
    echo "<h2>$title<a href=>Visit listing</a></h2>";
    echo "<img class='imageLOL' src='$image'>";
    echo "<form action='ListingDetails.php' method='get'><button type='submit' name='listingID' 
    value=" . $row['listingID'] . ">Se hus</button></form>";

    }
}
?>
</div>
</main>

</body>
</html>

