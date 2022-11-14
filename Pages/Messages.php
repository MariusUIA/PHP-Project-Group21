<?php
//side som viser fra databasen alle meldinger mellom ID1 og ID2.
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";

$senderID = $_GET['senderID'];
$recieverID = $_SESSION["user"]["userID"];


$sInfo = mysqli_query($connection, "SELECT firstName, lastName FROM user where userID = $senderID");
$sArray = $sInfo->fetch_assoc();
if (!isset($sArray)){
    header("location: Inbox.php");
}
$senderName = implode(" ", $sArray);


$rInfo = mysqli_query($connection, "SELECT firstName, lastName FROM user where userID = $recieverID");
$rArray = $rInfo->fetch_assoc();
if (!isset($rArray)){
    header("location: Inbox.php");
}
$recieverName = implode(" ", $rArray);


$messages = mysqli_query($connection,"SELECT messageText, recieverID, senderID FROM Messages where senderID = $senderID AND recieverID = $recieverID ORDER BY messageID");

?>
<html lang="NO">
<head>
    <title>Meldinger</title>
</head>

<body>
<section>
    <h1>Chat</h1>
    <table>
        <tr>
            <th></th>
        </tr>
        <?php
        while($rows=$messages->fetch_assoc())
        {
            ?>
            <tr>
                <td><?php echo $rows['messageText'];?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</section>
</body>

</html>