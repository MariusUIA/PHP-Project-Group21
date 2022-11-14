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


$messages = mysqli_query($connection,"SELECT messageText, messageTime, recieverID, senderID FROM Messages WHERE
           (recieverID = $recieverID AND senderID = $senderID) OR (senderID = $recieverID AND recieverID = $senderID) ORDER BY messageTime");

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
        while($rows=$messages->fetch_assoc()){
            if ($rows['senderID'] == $recieverID){
                echo '<a>' . $recieverName. '</a></br>';// trenger CSS for å plassere til venstre
            } elseif ($rows['senderID'] == $senderID){
                echo '<a>' . $senderName. '</a></br>'; // trenger CSS for å plassere til høyre
            }
            echo '<a> ' .$rows['messageText'].'</a></br>';
            echo '</br>';
        }

        ?>
    </table>
</section>
</body>

</html>