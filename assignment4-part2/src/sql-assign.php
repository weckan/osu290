<?php
ini_set('display_errors',1);
include "storedInfo.php";


# initialize mysqli, with error reporting
$mysqli = new mysqli($dbhost, $dbname, $dbpass, $dbuser);
if ($mysqli->connect_errno) {
    #echo "MySQL Connection error: (".$mysqli->connect_errno.") "$mysqli->connect_error;
    echo "MySQL Connection error";
} 
else {
    echo "Connection successful!<br>";
}

function addMovie($array)

#/* Prepared statement, stage 1: prepare */
#if (!($stmt = $mysqli->prepare("INSERT INTO movies(name, category, length) VALUES (?)"))) {
#        echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
#}
#
#/* Prepared statement, stage 2: bind and execute */
#$id = 1;
#if (!$stmt->bind_param("i", $id)) {
#        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
#}
#
#if (!$stmt->execute()) {
#    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
#}
?>

<form action='sql-assign.php' method='post'>
    <label>Name:</label>
    <input type="text" name='movieName' required/>
    <label>Category:</label>
    <input type="text" name='category' />
    <label>Length:</label>
    <input type="text" name='length' />
    <input type="submit" value="Add Movie">
    
