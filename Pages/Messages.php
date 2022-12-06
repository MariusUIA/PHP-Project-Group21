<?php
//side som viser fra databasen alle meldinger mellom ID1 og ID2.
include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

$senderID = $_GET['ID'];
$recieverID = $_SESSION["user"]["userID"];

//Henter navn til senderen av meldingene.
$sInfo = mysqli_query($connection, "SELECT firstName, lastName FROM user where userID = '$senderID'");
$sArray = $sInfo->fetch_assoc();
//Hvis sender ikke finnes, gå til Inbox
if (!isset($sArray)){
    header("location: Inbox.php");
}
$senderName = implode(" ", $sArray);

//Henter navn til mottakeren av meldingene (deg selv).
$rInfo = mysqli_query($connection, "SELECT firstName, lastName FROM user where userID = '$recieverID'");
$rArray = $rInfo->fetch_assoc();
//Hvis mottaker ikke finnes, gå til Inbox
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
        //Går gjennom hver melding, basert på hvem som sendte meldingen.
        while($rows=$messages->fetch_assoc()){
            if ($rows['senderID'] == $recieverID){
                echo '<a>' . $recieverName . '&nbsp &nbsp &nbsp &nbsp' . $rows['messageTime'] . '</a></br>';
            } elseif ($rows['senderID'] == $senderID){
                echo '<a>' . $senderName . '&nbsp &nbsp &nbsp &nbsp' . $rows['messageTime'] . '</a></br>';
            }
            echo '<a> ' .$rows['messageText'].'</a></br>';
            echo '</br>';
        }
        ?>
    </table>
    <form method='post'>
        <label for='message'></label>
        <input name='message' type='text' /><br>
        <button type='submit' name="message_button">Send</button>
    </form>
    <?php
    if (isset($_POST["message_button"])) {
        $now = date("Y-m-d H:i:s.");

        $sql = "INSERT INTO messages
        (messageText, messageTime, recieverID, senderID) 
        VALUES 
        (?, ?, ?, ?)";

        $test = $connection->prepare($sql);
        $test->bind_param('ssii', $_POST['message'], $now, $senderID, $recieverID);
        $test->execute();
        header("location: Messages.php?ID=" . $senderID);
    }

    ?>
</section>
</body>

</html>