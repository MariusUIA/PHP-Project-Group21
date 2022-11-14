<?php
//side som viser fra databasen alle meldinger mellom ID1 og ID2.
include_once "../Utilities/DatabaseConnection.php";
session_start();

$senderID = $_GET['senderID'];
$recieverID = $_SESSION["user"]["userID"];
echo 'ÆØÅ';

echo 'Messages from ' . $senderID . ' to ' . $recieverID . ' are sent here.';

$result = mysqli_query($connection,"SELECT messageText, recieverID, senderID FROM Messages where senderID = $senderID AND recieverID = $recieverID ORDER BY messageID");

?>
<html>
<head>
</head>

<body>
<section>
    <h1>Chat</h1>
    <table>
        <tr>
            <th></th>
            <th>Tittel</th>
        </tr>
        <?php
        while($rows=$result->fetch_assoc())
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
