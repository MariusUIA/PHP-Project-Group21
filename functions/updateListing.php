<?php
function updateListing($connection, $listingID, $title, $description, $address, $rooms, $type, $price, $area, $petAllowed,
$hasParking, $hasShed, $isFurnished, $hasAppliances, $hasBalcony, $hasGarden, $wcFriendly, $incElectricity, $incWifi, $canSmoke,
$forMen, $forWomen, $userID) {

    $sql = "UPDATE listings SET listingTitle = ?, listingDesc = ?, listingAddress = ?, listingRooms = ?, listingType = ?, 
                    listingPrice = ?, listingArea = ?, petAllowed = ?, hasParking = ?, hasShed = ?, isFurnished = ?, 
                    hasAppliances = ?, hasBalcony = ?, hasGarden = ?, wcFriendly = ?, incElectricity = ?, incWifi = ?, canSmoke = ?,
                      forMen = ?, forWomen = ?, userID = ? WHERE listingID = '$listingID'";
    $test = $connection->prepare($sql);
    $test->bind_param('sssisiiiiiiiiiiiiiiii', $title, $description, $address, $rooms, $type, $price, $area, $petAllowed,
        $hasParking, $hasShed, $isFurnished, $hasAppliances, $hasBalcony, $hasGarden, $wcFriendly,
        $incElectricity, $incWifi, $canSmoke, $forMen, $forWomen, $userID);
    $test->execute();

};
