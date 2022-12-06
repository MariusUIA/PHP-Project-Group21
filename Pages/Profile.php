<?php

include_once "../Utilities/DatabaseConnection.php";
include_once "../Utilities/SessionHandler.php";
include_once "../Utilities/Header.php";

$userID = $_SESSION["user"]["userID"];

if(isset($_REQUEST["edit_profile_btn"])) {
    $pass =  $_POST['pass'];
    $firstName = $_POST['fnavn'];
    $lastName = $_POST['enavn'];
    $email = filter_var($_POST['epost'], FILTER_SANITIZE_EMAIL);
    $phone = $_POST['tlf'];
    $study = $_POST["studie"];
    $birthDate = $_POST['fdato'];
    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET firstName = ?, lastName = ?, pass = ?, email = ?, phone = ?, study = ?, birthDate = ? WHERE userID = '$userID'";
    $test = $connection->prepare($sql);
    $test->bind_param('ssssiss', $firstName, $lastName, $hashed, $email, $phone, $study, $birthDate);
    $test->execute();
}


?>

<html lang="NO">

<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="../css/Profile.css">
</head>
<body>

<main>
<form action="Profile.php" method="post">

<?php
$sql = "SELECT * FROM user WHERE userID = '$userID'";
$result = $connection->query($sql);
if($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $firstName = $row["firstName"];
        $lastName = $row["lastName"];
        $email = $row["email"];
        $password = $row["pass"];
        $phone = $row["phone"];
        $study = $row["study"];
        $birthDate = $row["birthDate"];

        echo '
<label for="fnavn">Fornavn</label>
<input type="text" name="fnavn" placeholder="Fornavn" value='.$firstName.'><br>

<label for="enavn">Etternavn</label>
<input type="text" name="enavn" placeholder="Etternavn" value='.$lastName.'><br>

<label for="epost">Epost</label>
<input type="email" name="epost" placeholder="E-post" value='.$email.'><br>

<label for="pass">Passord</label>
<input type="password" name="pass" placeholder="Passord" required><br>

<label for="tlf">Telefon</label>
<input type="tel" name="tlf" placeholder="Mobilnummer" value='.$phone.'><br>

<label for="studie">Studie</label>
<input type="text" name="studie" placeholder="Studie" value='.$study.'><br>
 
<label for="fdato">Fødselsdato</label>  
<input type="date" name="fdato" value='.$birthDate.'><br>';
    }
}
?>
<button type="submit" name="edit_profile_btn">Save Changes</button>
</form>
</main>

</body>

</html>
