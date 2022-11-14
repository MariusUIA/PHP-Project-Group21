<html lang="">
<head>
    <title>Registrering</title>
</head>
<body>
<pre>
<form method="post" action="">
  Fornavn: <input type="text" name="fnavn" placeholder="Fornavn"><br>
  Etternavn: <input type="text" name="enavn" placeholder="Etternavn"><br>
  E-post: <input type="email" name="epost" placeholder="E-post"><br>
  Passord: <input type="password" name="pass" placeholder="Passord"><br>
  Telefon: <input type="tel" name="tlf" placeholder="Mobilnummer"><br>
  Fødselsdato: <input type="date" name="fdato" value="yyyy-mm-dd"><br>
  Student? <input type="checkbox" name="student"><br>
  <input type="submit" name="registrer" value="Registrer">
</form>
</pre>
<?php
include_once "../Utilities/DatabaseConnection.php";
session_start(); //Ikke include, denne siden må være tilgjengelig

//Kjører koden hvis HTML knappen "registrer" har blitt trykket på.
if (isset($_POST['registrer'])) {
    //Hvis ingen av feltene er tomme, lagrer koden brukerinformasjonen i array og skriver.
    if (!empty($_POST['pass']) && !empty($_POST['fnavn']) && !empty($_POST['enavn']) && !empty($_POST['epost']) && !empty($_POST['tlf']) && !empty($_POST['fdato'])) {


        $pass = strip_tags($_POST['pass']);
        $fnavn = $_POST['fnavn'];
        $enavn = $_POST['enavn'];
        $epost = filter_var($_POST['epost'], FILTER_SANITIZE_EMAIL);
        $tlf = $_POST['tlf'];
        $dato = $_POST['fdato'];
        $student = $_POST['student'];

        $sql = "SELECT email FROM user WHERE email = '$epost'";
        $result = $connection->query($sql);
        if($result->num_rows == 0) {
            echo "Ditt fornavn er " . $fnavn . "</br>";
            echo "Ditt etternavn er " . $enavn . "</br>";
            echo "Din epost er " . $epost . "</br>";
            echo "Ditt telefonnummer er " . $tlf . "</br>";
            echo "Din fødselsdato er " . $student . "</br>";

            $hashed = password_hash($pass, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user 
        (pass, firstName, lastName, email, phone, birthDate, isStudent) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?)";

            $test = $connection->prepare($sql);
            $test->bind_param('ssssisi', $hashed, $fnavn, $enavn, $epost, $tlf, $dato, $student);
            $test->execute();
            header("location: Login.php");
        } else {
            echo("Bruker finnes allerede");
        }
    } else {
        /*Hvis en eller flere felt var tomme, kommer denne feilmeldingen først.
        Deretter, sjekker koden hva som manglet og skriver dette. */
        echo "<p>FEIL! Følgende informasjon mangler, og bruker ble derfor ikke opprettet. </p>";
    }
    if (empty($_POST['pass'])) {
        echo "Passord mangler </br>";
    }

    if (empty($_POST['unavn'])) {
        echo "Brukernavn mangler </br>";
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