<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Getting Details of Voter's ID</title>
</head>
<body>
<h1 style="text-align: center">Details of Voter's ID</h1>
<br>
</body>
<br>
<?php
$lastName = $_POST['lastName'];
$firstName = $_POST['firstName'];
$town = $_POST['town'];
$age = $_POST['age'];

if ($age < 18) {
    echo("Underage. Not allowed to register.");
} else {
    // Connect to mySQL server
    $connectToSQL = mysqli_connect('localhost', 'root', '');
    if (!$connectToSQL) {
        die("Failed to connect to the localhost database.");
    }

    // Use a database in the server
    $useDatabase = mysqli_select_db($connectToSQL,'data1');
    if (!$useDatabase) {
        die("Failed to use the database data1");
    }

    // Lines for the query of adding a voter's details from the HTML form to voterdetails of data1 database
    $addRecord = "insert into voterdetails(LastName, FirstName, Town, Age)
            values('$lastName', '$firstName', '$town', '$age')";

    mysqli_query($connectToSQL, $addRecord);

    // Lines for getting the contents of voterdetails table from data1
    $details_cmd = "SELECT VoterID, LastName, FirstName, Town, Age from voterdetails order by LastName, FirstName";
    // If voterdetails has a content
    if ($result = mysqli_query($connectToSQL, $details_cmd)) {
        echo "Successfully registered. Thank you!";
        echo "<br>";
        echo "<br>";

        // Each voter's details are shown in a row of a table
        echo "<table>";
        echo "<tr>";
            echo "<th>Voter ID</th>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Town</th>";
            echo "<th>Age</th>";
        echo "</tr>";

        // Details are fetch as an associative array
        //Keys: VoterID; LastName; FirstName; Town; Age
        while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                    echo "<td>".$row['VoterID']."</td>";
                    echo "<td>".$row['LastName']."</td>";
                    echo "<td>".$row['FirstName']."</td>";
                    echo "<td>".$row['Town']."</td>";
                    echo "<td>".$row['Age']."</td>";
                echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
    }
    mysqli_close($connectToSQL);
}
?>
<br>
<br>
<form action='VoterDetails.html'>
    <input type='submit' value='Back to Registration Form'>
</form>
</html>