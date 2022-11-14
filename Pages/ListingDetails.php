<?php

$listingID = "";
if(isset($_GET['listingID'])) {
    $listingID = $_GET['listingID'];
}

include_once "../Utilities/DatabaseConnection.php";

session_start();
if(!isset($_SESSION["user"])) {
    header("location: Login.php?msg");
}
$userID = $_SESSION["user"]["userID"];

if(isset($_REQUEST["create_listing_btn"])) {
    $listingID = filter_var($_REQUEST["listingID"]);
    $title = filter_var($_REQUEST["title"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
    $description = filter_var($_REQUEST["description"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
    $address = filter_var($_REQUEST["address"]);
    $rooms = filter_var($_REQUEST["rooms"], FILTER_SANITIZE_SPECIAL_CHARS);
    $price = filter_var($_REQUEST["price"], FILTER_SANITIZE_SPECIAL_CHARS);
    $area = filter_var($_REQUEST["area"], FILTER_SANITIZE_SPECIAL_CHARS);
    $type = filter_var($_REQUEST["type"]);

    $petAllowed = (isset($_REQUEST["petAllowed"]));
    if($petAllowed) {$petAllowed = 1;} else {$petAllowed = 0;}

    $hasParking = (isset($_REQUEST["hasParking"]));
    if($hasParking) {$hasParking = 1;} else {$hasParking = 0;}

    $hasShed = (isset($_REQUEST["hasShed"]));
    if($hasShed) {$hasShed = 1;} else {$hasShed = 0;}

    $isFurnished = (isset($_REQUEST["isFurnished"]));
    if($isFurnished) {$isFurnished = 1;} else {$isFurnished = 0;}

    $hasAppliances = (isset($_REQUEST["hasAppliances"]));
    if($hasAppliances) {$hasAppliances = 1;} else {$hasAppliances = 0;}

    $hasBalcony = (isset($_REQUEST["hasBalcony"]));
    if($hasBalcony) {$hasBalcony = 1;} else {$hasBalcony = 0;}

    $hasGarden = (isset($_REQUEST["hasGarden"]));
    if($hasGarden) {$hasGarden = 1;} else {$hasGarden = 0;}

    $wcFriendly = (isset($_REQUEST["wcFriendly"]));
    if($wcFriendly) {$wcFriendly = 1;} else {$wcFriendly = 0;}

    $incElectricity = (isset($_REQUEST["incElectricity"]));
    if($incElectricity) {$incElectricity = 1;} else {$incElectricity = 0;}

    $incWifi = (isset($_REQUEST["incWifi"]));
    if($incWifi) {$incWifi = 1;} else {$incWifi = 0;}

    $canSmoke = (isset($_REQUEST["canSmoke"]));
    if($canSmoke) {$canSmoke = 1;} else {$canSmoke = 0;}

    $forMen = (isset($_REQUEST["forMen"]));
    if($forMen) {$forMen = 1;} else {$forMen = 0;}

    $forWomen = (isset($_REQUEST["forWomen"]));
    if($forWomen) {$forWomen = 1;} else {$forWomen = 0;}

}

if(!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['address']) && !empty($_POST['rooms'])) {
    $sql = "UPDATE listings SET listingTitle = ?, listingDesc = ?, listingAddress = ?, listingRooms = ?, listingType = ?, 
                    listingPrice = ?, listingArea = ?, petAllowed = ?, hasParking = ?, hasShed = ?, isFurnished = ?, 
                    hasAppliances = ?, hasBalcony = ?, hasGarden = ?, wcFriendly = ?, incElectricity = ?, incWifi = ?, canSmoke = ?,
                      forMen = ?, forWomen = ?, userID = ? WHERE listingID = '$listingID'";

    $test = $connection->prepare($sql);
    $test->bind_param('sssisiiiiiiiiiiiiiiii', $title, $description, $address, $rooms, $type, $price, $area, $petAllowed,
        $hasParking, $hasShed, $isFurnished, $hasAppliances, $hasBalcony, $hasGarden, $wcFriendly,
        $incElectricity, $incWifi, $canSmoke, $forMen, $forWomen, $userID);
    $test->execute();
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
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            outline: solid red;
        }

        .listingContainer {
            display: flex;
            justify-content: center;
            align-content: center;
            flex-direction: column;
            width: max-content;
        }

        .listingContainer > img {
            object-fit: contain;
            width: auto;
            height: 20rem;
        }

        .listingTags {
            display: flex;
        }

        .listingTags > .listingTag {
            background-color: #E4E4E4;
            border-radius: 15px;
            padding: 0.25rem 1rem;
            width: max-content;
            margin-right: 0.5rem;
            margin-bottom: 2rem;
        }

        .createListingForm > img {
            object-fit: contain;
            width: auto;
            height: 5rem;
        }
    </style>
</head>
<body>
<main>


    <?php
    $sql = "SELECT * FROM listings WHERE listingID = '$listingID'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $listingTitle = $row["listingTitle"];
            $listingDesc = $row["listingDesc"];
            $listingPrice = $row["listingPrice"];
            $listingArea = $row["listingArea"];
            $imagePath = "../images/" . $row["listingID"] . ".jpg";

            $facilities = "";
            if($row["hasShed"]) $facilities = $facilities . " shed,";
            if($row["hasParking"]) $facilities = $facilities . " parking,";
            if($row["isFurnished"]) $facilities = $facilities . " furnished,";
            if($row["hasGarden"]) $facilities = $facilities . " garden,";

            $includes = "";
            if($row["incElectricity"]) $includes = $includes . " electricity,";
            if($row["incWifi"]) $includes = $includes . " Wifi,";
            if($row["hasAppliances"]) $includes = $includes . " appliances,";

            $tagsArray = [];
            if($row["petAllowed"]) array_push($tagsArray, "Pets allowed");
            if($row["canSmoke"]) array_push($tagsArray, "Can smoke");
            if($row["forMen"]) array_push($tagsArray, "For men");
            if($row["forWomen"]) array_push($tagsArray, "For women");

            echo "
<div class='listingContainer'>
<img src='$imagePath' />
<h1>$listingTitle</h1>
<p>Månedsleie: $listingPrice kr pr/mnd</p>
<p>Areal: $listingArea kvadratmeter</p>
<h2>Description:</h2>
<p>$listingDesc</p>
<h2>Info:</h2>
<p>Facilities: $facilities</p>
<p>Includes: $includes</p>
<div class='listingTags'>
";

            for($i = 0; $i < count($tagsArray); $i++) {
                echo "<div class='listingTag'>$tagsArray[$i]</div>";
            }
            echo "</div></div>";

            $hybel = "";
            $bofelleskap = "";

            $petAllowed = "";
            if($row["petAllowed"]) $petAllowed = "checked";

            $hasParking = "";
            if($row["hasParking"]) $hasParking = "checked";

            $hasShed = "";
            if($row["hasShed"]) $hasShed = "checked";

            $isFurnished = "";
            if($row["isFurnished"]) $isFurnished = "checked";

            $hasAppliances = "";
            if($row["hasAppliances"]) $hasAppliances = "checked";

            $hasBalcony = "";
            if($row["hasBalcony"]) $hasBalcony = "checked";

            $hasGarden = "";
            if($row["hasGarden"]) $hasGarden = "checked";

            $wcFriendly = "";
            if($row["wcFriendly"]) $wcFriendly = "checked";

            $incElectricity = "";
            if($row["incElectricity"]) $incElectricity = "checked";

            $incWifi = "";
            if($row["incWifi"]) $incWifi = "checked";

            $canSmoke = "";
            if($row["canSmoke"]) $canSmoke = "checked";

            $forMen = "";
            if($row["forMen"]) $forMen = "checked";

            $forWomen = "";
            if($row["forWomen"]) $forWomen = "checked";

            if($row["listingType"] === "Hybel") {
                $hybel = "selected";
            } else {
                $bofelleskap = "selected";
            }

            echo '<form class="createListingForm" action="listingDetails.php" method="post" enctype="multipart/form-data">

        <input name="listingID" type="text" value='.$listingID.' hidden />
        
        <label for="title">Title: </label>
        <input name="title" type="text" maxlength="264" value='.$row["listingTitle"].' /><br>

        <label for="description">Description: </label>
        <input name="description" type="text" maxlength="1000" value='.$row["listingDesc"].' /><br>

        <label for="address">Address: </label>
        <input name="address" type="text" maxlength="256" minlength="6" value='.$row["listingAddress"].' /><br>

        <label for="rooms">Nr of rooms: </label>
        <input name="rooms" type="number" maxlength="64" minlength="1" value='.$row["listingRooms"].' /><br>

        <label for="price">Monthly cost: </label>
        <input name="price" type="number" maxlength="64" minlength="1" value='.$row["listingPrice"].' /><br>

        <label for="area">Square meters: </label>
        <input name="area" type="number" maxlength="64" minlength="1" value='.$row["listingArea"].' /><br>

        <label for="type">Type: </label>
        <select name="type" id="type">
            <option '.$hybel.' value="Hybel">Hybel</option>
            <option '.$bofelleskap.'  value="Bofelleskap">Bofelleskap</option>
        </select><br>

        <label for="petAllowed">Allow Pets</label>
        <input '.$petAllowed.' type="checkbox" id="petAllowed" name="petAllowed"><br>

        <label for="hasParking">Include parking</label>
        <input '.$hasParking.' type="checkbox" id="hasParking" name="hasParking" value="yes"><br>

        <label for="hasShed">Includes a shed</label>
        <input '.$hasShed.' type="checkbox" id="hasShed" name="hasShed" value="yes"><br>

        <label for="isFurnished">Includes furnishes</label>
        <input '.$isFurnished.' type="checkbox" id="isFurnished" name="isFurnished" value="yes"><br>

        <label for="hasAppliances">Includes appliances</label>
        <input '.$hasAppliances.' type="checkbox" id="hasAppliances" name="hasAppliances" value="yes"><br>

        <label for="hasBalcony">Includes a balcony</label>
        <input '.$hasBalcony.' type="checkbox" id="hasBalcony" name="hasBalcony" value="yes"><br>

        <label for="hasGarden">Includes a garden</label>
        <input '.$hasGarden.' type="checkbox" id="hasGarden" name="hasGarden" value="yes"><br>

        <label for="wcFriendly">Is handicap friendly</label>
        <input '.$wcFriendly.' type="checkbox" id="wcFriendly" name="wcFriendly" value="yes"><br>

        <label for="incElectricity">Includes electricity</label>
        <input '.$incElectricity.' type="checkbox" id="incElectricity" name="incElectricity" value="yes"><br>

        <label for="incWifi">Includes wifi</label>
        <input '.$incWifi.' type="checkbox" id="incWifi" name="incWifi" value="yes"><br>

        <label for="canSmoke">Allow smoking</label>
        <input '.$canSmoke.' type="checkbox" id="canSmoke" name="canSmoke" value="yes"><br>

        <label for="forMen">For men</label>
        <input '.$forMen.' type="checkbox" id="forMen" name="forMen" value="yes"><br>

        <label for="forWomen">For women</label>
        <input '.$forWomen.' type="checkbox" id="forWomen" name="forWomen" value="yes"><br>

        <button type="submit" name="create_listing_btn">Save</button>
    </form>';
        }
    }
    ?>
</main>

</body>
</html>

