<?php
?>

<link rel="stylesheet" href="../css/misc.css">
<header style="font-family: Arial,Helvetica,sans-serif">
    <div class="headerStyle">
                <?php
                echo '<span>';
                echo '<li> <a href="../Pages/Homepage.php"> Hjemmeside </a></li>';
                echo '<li> <a href="../Pages/Listings.php"> Annonser </a></li>';
                if ($_SESSION['isStudent'] == 0) {
                    echo '<li> <a href="../Pages/MyListings.php"> Dine Annonser </a></li>';
                }
                echo '<li> <a href="../Pages/Inbox.php"> Meldinger </a></li>';
                echo '<li> <a href="../Pages/Logout.php"> Logg ut </a></li>';
                echo '</span>';
                ?>
    </div>
</header>