<?php
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

$result = mysqli_query($connection,"SELECT * FROM listings");

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
            border: 1px solid black;
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
    <h1>GeeksForGeeks</h1>
    <table>
        <tr>
            <th></th>
            <th>Tittel</th>
            <th>noe</th>
            <th>test</th>
            <th>GFwpidw</th>
            <th>Knapp</th>
        </tr>
        <?php
        while($rows=$result->fetch_assoc())
        {
            ?>
            <tr>
                <td><img src="https://thoneiendom.no/globalassets/bolig-til-salgs/aktuelle-boligprosjekter/wessel-park/bilder/artikkelbilder/wesselpark_vestby-sommer1.jpg?width=200&height=180" </td>
                <td><?php echo $rows['listingID'];?></td>
                <td><?php echo $rows['listingTitle'];?></td>
                <td><?php echo $rows['listingType'];?></td>
                <td><?php echo $rows['listingAddress'];?></td>
                <td><form action='ListingDetails.php' method='get'><button type='submit' name='listingID' value='<?php echo $rows['listingID']?>'>Se hus</button></form></td>
            </tr>
            <?php
        }
        ?>
    </table>
</section>
</body>

</html>
