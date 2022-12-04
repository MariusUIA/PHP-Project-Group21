<?php
//side som viser hvem som man har fått melding fra, som da sender til "Messages.php" med riktig bruker.
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";


$recieverID = $_SESSION["user"]["userID"];
$result = mysqli_query($connection, "SELECT senderID FROM Messages WHERE recieverID = '$recieverID' GROUP BY senderID");



function getUserInfo($senderID, $recieverID, $connection): void{
    $userQ = mysqli_query($connection,"SELECT userID, firstName, lastName FROM User where userID = '$senderID'");
    $userRows=$userQ->fetch_assoc();

    $messQ = mysqli_query($connection,"SELECT messageText, recieverID, senderID FROM Messages where senderID = '$senderID' AND recieverID = '$recieverID' ORDER BY messageID DESC LIMIT 1");
    $messRows=$messQ->fetch_assoc();

    echo '<tr><td></td>';
    echo '<td>' . $userRows['firstName'] . ' ' . $userRows['lastName'] . '</td>';
    echo '<td></td>';
    echo '<td>' . mb_substr($messRows['messageText'], 0, 30, 'UTF-8') . '...';
    echo '<td><form action="Messages.php" method="get"><button type="submit" name="ID" value="' . $userRows['userID'] . '">Gå til chat</button></form></td>';
    echo '</tr>';
}

?>

<html lang="NO">
<head>
    <title>Inboks</title>
</head>
<body>
<section>
    <h1>Meldinger</h1>
    <table>
        <tr>
            <th></th>
            <th>Melding fra</th>
        </tr>
        <?php
        while($rows=$result->fetch_assoc())
        {
            getUserInfo($rows['senderID'], $recieverID, $connection);
        }
        ?>
    </table>
</section>
</body>

</html>