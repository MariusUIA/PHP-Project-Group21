<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";


if (!isset($_POST['submit'])) {
    $result = mysqli_query($connection,"SELECT * FROM listings");
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

    $query = "SELECT * FROM listings WHERE listingTitle LIKE '%$search%'";

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
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
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
<section>
    <h1>Annonser</h1>
    <form method="post" action="">
        <input type="checkbox" name="petAllowed"> Dyrehold tillat<br>
        <input type="checkbox" name="hasParking"> Parkering tilgjengelig<br>
        <input type="checkbox" name="hasShed"> Har bod<br>
        <input type="checkbox" name="isFurnished"> Møbler<br>
        <input type="checkbox" name="hasAppliances"> Hvitevarer<br>
        <input type="checkbox" name="hasBalcony"> Balkong<br>
        <input type="checkbox" name="hasGarden"> Hage<br>
        <input type="checkbox" name="wcFriendly"> Rullestolvennlig<br>
        <input type="checkbox" name="canSmoke"> Røyking tillat<br>


        <label for='sort'>Sorter: </label>
        <select name="sort" id="sort">
            <option value="priceSortLow">Pris (Lav -> Høy)</option>
            <option value="priceSortHigh">Pris (Høy -> Lav)</option>
            <option value="roomSortLow">Antall Rom (Lav -> Høy)</option>
            <option value="roomSortHigh">Antall Rom (Høy -> Lav)</option>
            <option value="areaSortLow">Areal (Lav -> Høy)</option>
            <option value="areaSortHigh">Areal (Høy -> Lav)</option>
        </select><br>

        Søk: <input type="text" name="search" placeholder="..."><br>
        <input type="submit" name="submit" value="Søk">
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
            ?>
            <tr>
                <td><?php echo '<img src="../images/' . $rows['listingID'] . '.' . $rows['listingImgType'] . '" height="150px"; width="200px;"';?></td>
                <!---<td><?php /*echo $rows['listingID'];*/?></td> --->
                <td><?php echo $rows['listingTitle'];?></td>
                <td><?php echo $rows['listingAddress'];?></td>
                <td><?php echo $rows['listingRooms'];?></td>
                <td><?php echo $rows['listingArea'] . "m<sup>2</sup>";?></td>
                <td><?php echo $rows['listingPrice'] . "kr";?></td>
                <td><form action='ListingDetails.php' method='get'><button type='submit' name='listingID' value='<?php echo $rows['listingID']?>'>Se hus</button></form></td>
            </tr>
            <?php
        }
        ?>
    </table>
</section>
</body>

</html>
