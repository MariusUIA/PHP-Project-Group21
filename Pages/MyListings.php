<?php
include_once "../Utilities/DatabaseConnection.php";

session_start();
$userID = $_SESSION["user"]["userID"];

$sql = "SELECT * FROM listings WHERE userID = $userID";
$result = $connection->query($sql);
?>

<html>
<head>
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
    }
}
?>
</div>
</main>

</body>
</html>
