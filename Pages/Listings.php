<?php
$host    = "localhost";
$user    = "root";
$pass    = "";
$db_name = "ERRORBASEEDIT";

//create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$connection = mysqli_connect($host, $user, $pass, $db_name, 3308);


$result = mysqli_query($connection,"SELECT * FROM Listings");

echo
"<table> 
<tr>
<th>Name</th>
<th>Price</th>
<th>Start Date</th>
<th>End Date</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
    echo "<tr>";
    echo "<td>" . $row['listingName'] . "</td>";
    echo "<td>" . $row['price'] . "</td>";
    echo "<td>" . $row['startDate'] . "</td>";
    echo "<td>" . $row['endDate'] . "</td>";
    echo "</tr>";
}
echo "</table>";

mysqli_close($connection);
?>