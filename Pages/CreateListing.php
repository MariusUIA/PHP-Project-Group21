<?php
include_once "../Utilities/DatabaseConnection.php";

session_start();
if(!isset($_SESSION["user"])) {
    header("location: Login.php?msg");
}


if(isset($_REQUEST["create_listing_btn"])) {
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
    $sql = "INSERT INTO listings (listingTitle, listingDesc, listingAddress, listingRooms, listingType, listingPrice, listingArea, petAllowed, hasParking,
                      hasShed, isFurnished, hasAppliances, hasBalcony, hasGarden, wcFriendly, incElectricity, incWifi, canSmoke,
                      forMen, forWomen, userID)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?, ?)";
    $userID = $_SESSION["user"]["userID"];

    $test = $connection->prepare($sql);
    $test->bind_param('sssisiiiiiiiiiiiiiiii', $title, $description, $address, $rooms, $type, $price, $area, $petAllowed,
        $hasParking, $hasShed, $isFurnished, $hasAppliances, $hasBalcony, $hasGarden, $wcFriendly,
        $incElectricity, $incWifi, $canSmoke, $forMen, $forWomen, $userID);
    $test->execute();

    $sql = "SELECT * FROM listings ORDER BY listingID DESC";

    $result = $connection->query($sql);
    if($result->num_rows > 0) {
        $test = mysqli_fetch_array($result);

        $target_dir = "../images/";
        $arr = explode(".", basename($_FILES["imageUpload"]["name"]), 2);
        $target_file = $target_dir . $test[0] . "." . $arr[1];

        move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
    }
}

?>

<html>
<head>
</head>
<body>
<form action='CreateListing.php' method='post' enctype="multipart/form-data">

    <label for='title'>Title: </label>
    <input name='title' type='text' maxlength="264" />
    <?php if(isset($title)) {echo "<span>Title Required</span>";} ?><br>

    <label for='description'>Description: </label>
    <input name='description' type='text' maxlength="1000" />
    <?php if(isset($description)) {echo "<span>Description Required</span>";} ?><br>

    <label for='address'>Address: </label>
    <input name='address' type='text' maxlength="256" minlength="6" />
    <?php if(isset($address)) {echo "<span>Address Required</span>";} ?><br>

    <label for='rooms'>Nr of rooms: </label>
    <input name='rooms' type='number' maxlength="64" minlength="1" />
    <?php if(isset($rooms)) {echo "<span>Nr of roms Required</span>";} ?><br>

    <label for='price'>Monthly cost: </label>
    <input name='price' type='number' maxlength="64" minlength="1" />
    <?php if(isset($price)) {echo "<span>Monthly cost required</span>";} ?><br>

    <label for='area'>Square meters: </label>
    <input name='area' type='number' maxlength="64" minlength="1" />
    <?php if(isset($area)) {echo "<span>Square meters required</span>";} ?><br>

    <label for='type'>Type: </label>
    <select name="type" id="type">
        <option value="Hybel">Hybel</option>
        <option value="Bofelleskap">Bofelleskap</option>
    </select><br>

    <label for="petAllowed">Allow Pets</label>
    <input type="checkbox" id="petAllowed" name="petAllowed"><br>

    <label for="hasParking">Include parking</label>
    <input type="checkbox" id="hasParking" name="hasParking" value="yes"><br>

    <label for="hasShed">Includes a shed</label>
    <input type="checkbox" id="hasShed" name="hasShed" value="yes"><br>

    <label for="isFurnished">Includes furnishes</label>
    <input type="checkbox" id="isFurnished" name="isFurnished" value="yes"><br>

    <label for="hasAppliances">Includes appliances</label>
    <input type="checkbox" id="hasAppliances" name="hasAppliances" value="yes"><br>

    <label for="hasBalcony">Includes a balcony</label>
    <input type="checkbox" id="hasBalcony" name="hasBalcony" value="yes"><br>

    <label for="hasGarden">Includes a garden</label>
    <input type="checkbox" id="hasGarden" name="hasGarden" value="yes"><br>

    <label for="wcFriendly">Is handicap friendly</label>
    <input type="checkbox" id="wcFriendly" name="wcFriendly" value="yes"><br>

    <label for="incElectricity">Includes electricity</label>
    <input type="checkbox" id="incElectricity" name="incElectricity" value="yes"><br>

    <label for="incWifi">Includes wifi</label>
    <input type="checkbox" id="incWifi" name="incWifi" value="yes"><br>

    <label for="canSmoke">Allow smoking</label>
    <input type="checkbox" id="canSmoke" name="canSmoke" value="yes"><br>

    <label for="forMen">For men</label>
    <input type="checkbox" id="forMen" name="forMen" value="yes"><br>

    <label for="forWomen">For women</label>
    <input type="checkbox" id="forWomen" name="forWomen" value="yes"><br>

    <label for="imageUpload">Upload Image</label>
    <input type="file" name="imageUpload" id="imageUpload"><br>

    <button type='submit' name="create_listing_btn">Register</button>
</form>
</body>
</html>


