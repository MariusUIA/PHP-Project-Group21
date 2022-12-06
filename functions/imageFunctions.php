<?php
//Legger til bildet til databasen.
function addImage($connection, $imgDesc, $imageType, $listingID) {
    $sql = "INSERT INTO listingimages (listingImgDesc, listingImgType, listingID) VALUES (?,?, ?)";
    $test = $connection->prepare($sql);
    $test->bind_param('ssi', $imgDesc, $imageType, $listingID);
    $test->execute();
}

//Legger til bildet til lokal lagring.
function addImageLocally($connection, $imageType) {
    $sql = "SELECT * FROM listingimages ORDER BY listingImgID DESC";
    $result = $connection->query($sql);
    if($result->num_rows > 0) {
        $listingImages = mysqli_fetch_array($result);
        $target_dir = "../images/";
        $target_file = $target_dir . $listingImages[0] . "." . $imageType;
        move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file);
    }
}

//Sletter bildet fra databasen.
function deleteImage($connection, $listingImageID) {
    $sql = "DELETE FROM listingimages WHERE listingImgID = '$listingImageID'";
    $test = $connection->prepare($sql);
    $test->execute();
}

//Sletter bildet lokalt.
function deleteImageLocally($connection, $listingImageID) {
    $sql = "SELECT * FROM listingimages WHERE listingImgID = $listingImageID";
    $result = $connection->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $imageType = $row["listingImgType"];
            $imageFile = "../images/" . $listingImageID . "." . $imageType;
            unlink($imageFile);
        }
    }
}

