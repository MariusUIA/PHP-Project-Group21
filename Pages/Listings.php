<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";


if (!isset($_POST['submit'])) {
    $queryTest = "SELECT * FROM listings INNER JOIN listingimages ON listings.listingID=listingimages.listingID WHERE listingimages.listingMainImg = 1";
    //$queryUnused = "SELECT * FROM listings";
    $result = mysqli_query($connection, $queryTest);
}

if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $sortSelect = $_POST['sort'];

    $sortBy = match ($sortSelect) {
        'priceSortLow' => 'listingPrice ASC',
        'priceSortHigh' => 'listingPrice DESC',
        'roomSortLow' => 'listingRooms ASC',
        'roomSortHigh' => 'listingRooms DESC',
        'areaSortLow' => 'listingArea ASC',
        'areaSortHigh' => 'listingArea DESC',
        default => 'listingID',
    };


    $filterArray = array(
        'petAllowed' => +isset($_POST['petAllowed']),
        'hasParking' => +isset($_POST['hasParking']),
        'isFurnished' => +isset($_POST['isFurnished']),
        'hasShed' => +isset($_POST['hasShed']),
        'hasAppliances' => +isset($_POST['hasAppliances']),
        'hasBalcony' => +isset($_POST['hasBalcony']),
        'hasGarden' => +isset($_POST['hasGarden,']),
        'wcFriendly' => +isset($_POST['wcFriendly']),
        'canSmoke' => +isset($_POST['canSmoke'])
    );

    $query = "SELECT * FROM listings INNER JOIN listingimages ON listings.listingID=listingimages.listingID WHERE listingTitle LIKE '%$search%' AND listingimages.listingMainImg = 1";

    foreach ($filterArray as $key => $value){
        if ($value != 0) {
            $query .= ' AND ' . $key . ' = ' . $value;
        }
    }


    $result = mysqli_query($connection, $query . " ORDER BY $sortBy");
}

if (isset($_GET['button'])) {
    header("location: ListingDetails.php?listingID=" . $_GET['button']);
}


?>

<html lang="NO">

<head>
    <meta charset="UTF-8">
    <title>Annonser</title>
    <link rel="stylesheet" href="../css/Listings.css">
</head>

<body>
<section>
    <form method="post" action="">
        <div class="dropdown">
        <span>Filter</span>
            <div class="dropdown-content">
                <input type="checkbox" name="petAllowed"> Dyrehold tillat<br>
                <input type="checkbox" name="hasParking"> Parkering<br>
                <input type="checkbox" name="hasShed"> Har bod<br>
                <input type="checkbox" name="isFurnished"> Møbler<br>
                <input type="checkbox" name="hasAppliances"> Hvitevarer<br>
                <input type="checkbox" name="hasBalcony"> Balkong<br>
                <input type="checkbox" name="hasGarden"> Hage<br>
                <input type="checkbox" name="wcFriendly"> Rullestolvennlig<br>
                <input type="checkbox" name="canSmoke"> Røyking tillat<br>
            </div>
        </div>

        <div>
        <label for='sort'>Sorter: </label>
        <select name="sort" id="sort">
            <option value="priceSortLow">Pris (Lav -> Høy)</option>
            <option value="priceSortHigh">Pris (Høy -> Lav)</option>
            <option value="roomSortLow">Antall Rom (Lav -> Høy)</option>
            <option value="roomSortHigh">Antall Rom (Høy -> Lav)</option>
            <option value="areaSortLow">Areal (Lav -> Høy)</option>
            <option value="areaSortHigh">Areal (Høy -> Lav)</option>
        </select><br>
        </div>

        <div>
        Søk: <input type="text" name="search" placeholder="..."><br>
        <input type="submit" name="submit" value="Søk">
        </div>
    </form>
    </br>

    <table>
        <tr>
            <th></th>
            <th>Tittel</th>
            <th>Addresse</th>
            <th>Antall Rom</th>
            <th>Areal</th>
            <th>Pris</th>
            <th></th>
        </tr>
        <?php
        while($rows=$result->fetch_assoc())
        {
            echo"
            <tr class='listingLine'>
                <td> <img src='../images/" . $rows['listingImgID'] . "." . $rows['listingImgType'] . "'width='300' height='200'>  </img></td>
                <td>" . $rows['listingTitle'] . "</td>
                <td>" . $rows['listingAddress'] . "</td>
                <td>" . $rows['listingRooms'] . "</td>
                <td>" . $rows['listingArea'] . "m<sup>2</sup>" . "</td>
                <td>" . $rows['listingPrice'] . "kr" . "</td>
                <td><form action='ListingDetails.php' method='get'><button type='submit' name='listingID' value='" . $rows['listingID'] ."'>Se hus</button></form></td>
                </tr>
                ";
        }
        ?>
    </table>
</section>
</body>

</html>
