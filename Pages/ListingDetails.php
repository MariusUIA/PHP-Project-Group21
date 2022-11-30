<?php

$listingID = "";
if(isset($_GET['listingID'])) {
    $listingID = $_GET['listingID'];
}

include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";
include_once "../functions/updateListing.php";
include_once "../functions/imageFunctions.php";


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

    $petAllowed = +isset($_REQUEST["petAllowed"]);

    $hasParking = +isset($_REQUEST["hasParking"]);

    $hasShed = +isset($_REQUEST["hasShed"]);

    $isFurnished = +isset($_REQUEST["isFurnished"]);

    $hasAppliances = +isset($_REQUEST["hasAppliances"]);

    $hasBalcony = +isset($_REQUEST["hasBalcony"]);

    $hasGarden = +isset($_REQUEST["hasGarden"]);

    $wcFriendly = +isset($_REQUEST["wcFriendly"]);

    $incElectricity = +isset($_REQUEST["incElectricity"]);

    $incWifi = +isset($_REQUEST["incWifi"]);

    $canSmoke = +isset($_REQUEST["canSmoke"]);

    $forMen = +isset($_REQUEST["forMen"]);

    $forWomen = +isset($_REQUEST["forWomen"]);
}

if(!empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['address']) && !empty($_POST['rooms'])) {
    updateListing($connection, $listingID, $title, $description, $address, $rooms, $type, $price, $area, $petAllowed,
        $hasParking, $hasShed, $isFurnished, $hasAppliances, $hasBalcony, $hasGarden, $wcFriendly, $incElectricity, $incWifi, $canSmoke,
        $forMen, $forWomen, $userID);
}

if(isset($_REQUEST["add_image_btn"])) {

    $listingID = filter_var($_REQUEST["listingID"]);
    $imgDesc = filter_var($_REQUEST["imgDesc"]);
    $imageFileArr = explode(".", basename($_FILES["imageUpload"]["name"]), 2);
    $imageType = $imageFileArr[1];

    addImage($connection, $imgDesc, $imageType, $listingID);
    addImageLocally($connection, $imageType);

}

if(isset($_REQUEST["delete_image_btn"])) {
    $listingImageID = filter_var($_REQUEST["listingImageID"]);
    echo "$listingImageID";

    deleteImageLocally($connection, $listingImageID);
    deleteImage($connection, $listingImageID);

}




?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/ListingDetails.css">
</head>
<body>
<main>


    <?php
    $sql = "SELECT * FROM listings WHERE listingID = '$listingID'";
    $result = $connection->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $listingID = $row["listingID"];
            $listingTitle = $row["listingTitle"];
            $listingDesc = $row["listingDesc"];
            $listingPrice = $row["listingPrice"];
            $listingArea = $row["listingArea"];
            $listingUserID = $row["userID"];

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

            $sql3 = "SELECT * FROM listingimages WHERE listingID = '$listingID' AND listingMainImg = 1";
            $result3 = $connection->query($sql3);
            if ($result3->num_rows > 0) {
                $listingMainImage = mysqli_fetch_array($result3);
                $imagePath = "../images/secondaryImages/" . $listingMainImage[0] . "." . $listingMainImage[2];
                echo "<div class='listingContainer'>
                  <img alt='$listingTitle' src='$imagePath' />
                  <div class='secondaryImages'>";
            }


    $sql2 = "SELECT * FROM listingimages WHERE listingID = '$listingID'";
    $result2 = $connection->query($sql2);
    if ($result2->num_rows > 0) {
        while ($row2 = $result2->fetch_assoc()) {
            $listingImageID = $row2["listingImgID"];
            $listingImageType = $row2["listingImgType"];
            $listingImgDesc = $row2["listingImgDesc"];
            $listingMainImg = $row2["listingMainImg"];
            $imagePath = "../images/secondaryImages/" . $listingImageID . "." . $listingImageType;
            if(!$listingMainImg) {
                echo "<form>
                    <input name='listingImageID' hidden type='text' value='$listingImageID' />
                    <img class='secondayImage' src='$imagePath' />
                    <p>$listingImgDesc</p>
                    <button name='delete_image_btn' type='submit'>Delete</button>
                </form>";
            }
        }
    }


            echo "</div>";
            echo "<h1>$listingTitle</h1>
                  <p>Månedsleie: $listingPrice kr pr/mnd</p>
                  <p>Areal: $listingArea kvadratmeter</p>
                  <h2>Description:</h2>
                  <p>$listingDesc</p>
                  <h2>Info:</h2>
                  <p>Facilities: $facilities</p>
                  <p>Includes: $includes</p>
            <div class='listingTags'>";

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
            if($listingUserID === $userID) {
                echo '<h2>Edit listing</h2>';
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


        echo '<h2>Add image</h2>';
        echo "<form action='listingDetails.php' method='post' enctype='multipart/form-data'>
                <input type='text' hidden value='$listingID' name='listingID' />
                <label for='imgDesc'>Image description</label>
                <input type='text' name='imgDesc' id='imgDesc'><br>
                
                <label for='imageUpload'>Upload Image</label>
                <input type='file' name='imageUpload' id='imageUpload'><br>
                <button type='submit' name='add_image_btn'>Submit</button>
          </form>";
            }

    ?>

</main>

</body>
</html>

