<html lang="">
<head>
    <title>Registrering av bruker</title>
</head>
<body>
<pre>
<form method="post" action="">
  Fornavn: <input type="text" name="fnavn" placeholder="Fornavn"><br>
  Etternavn: <input type="text" name="enavn" placeholder="Etternavn"><br>
  E-post: <input type="email" name="epost" placeholder="E-post"><br>
  Telefon: <input type="tel" name="tlf" placeholder="Mobilnummer"><br>
  Fødselsdato: <input type="date" name="fdato" value="yyyy-mm-dd"><br>
  <input type="submit" name="registrer" value="Registrer">
</form>
</pre>
<?php
include_once "../Utilities/DatabaseConnection.php";


//Kjører koden hvis HTML knappen "registrer" har blitt trykket på.
if (isset($_POST['registrer'])) {
    //Hvis ingen av feltene er tomme, lagrer koden brukerinformasjonen i array og skriver.
    if (!empty($_POST['fnavn']) && !empty($_POST['enavn']) && !empty($_POST['epost']) && !empty($_POST['tlf']) && !empty($_POST['fdato'])) {


        echo "Ditt fornavn er " . ($_POST['fnavn'] . "</br>");
        echo "Ditt etternavn er " . ($_POST['enavn'] . "</br>");
        echo "Din epost er " . ($_POST['epost'] . "</br>");
        echo "Ditt telefonnummer er " . ($_POST['tlf'] . "</br>");
        echo "Din fødselsdato er " . ($_POST['fdato'] . "</br>");

        $fnavn = $_POST['fnavn'];
        $enavn = $_POST['enavn'];
        $epost = $_POST['epost'];
        $tlf = $_POST['tlf'];
        $dato = $_POST['fdato'];


        $sql = "INSERT INTO Users 
        (firstName, lastName, email, phoneNumber, birthDate) 
        VALUES 
        (?, ?, ?, ?, ?)";

        $test = $connection->prepare($sql);
        $test->bind_param('sssis', $fnavn, $enavn, $epost, $tlf, $dato);
        $test->execute();

    } else {
        /*Hvis en eller flere felt var tomme, kommer denne feilmeldingen først.
        Deretter, sjekker koden hva som manglet og skriver dette. */
        echo "<p>FEIL! Følgende informasjon mangler, og bruker ble derfor ikke opprettet. </p>";
    }
    if (empty($_POST['fnavn'])) {
        echo "fornavn mangler </br>";
    }

    if (empty($_POST['enavn'])) {
        echo "etternavn mangler </br>";
    }

    if (empty($_POST['epost'])) {
        echo "epost mangler </br>";
    }

    if (empty($_POST['tlf'])) {
        echo "telefonnummer mangler </br>";
    }

    if (empty($_POST['fdato'])) {
        echo "fødselsdato mangler </br>";
    }
}
mysqli_close($connection);

?>
</body>
</html>