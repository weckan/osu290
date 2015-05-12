<?php
ini_set('display_errors',1); 
include "storedInfo.php"; 

# initialize mysqli, with error reporting                                        
$mysqli = new mysqli($dbhost, $dbname, $dbpass, $dbuser);
if ($mysqli->connect_errno) {                                                    
    echo "MySQL Connection error";                                               
}
#else {
#    echo "Connection successful!<br>";  
#}

if (isset($_POST['rent_movie'])) {
    rentMovie($_POST);
}

if (isset($_POST['delete_movie'])) {
    deleteMovie($_POST);
}

if (isset($_POST['add_movie'])) {
    addMovie($_POST);
}

if (isset($_POST['delete_all_movies'])) {
    deleteAll($_POST);
}

function rentMovie($array) {
    global $mysqli;

    $name = $mysqli->real_escape_string($array['movieName']);
    $category = $mysqli->real_escape_string($array['category']);
    $rent = $mysqli->real_escape_string($array['rent_movie']);

    /*prepare statement stage 1*/
    if (!($stmt = $mysqli->prepare("UPDATE movies SET rented = ?
             WHERE name = ? AND category = ?"))) {
        echo "Prepare query movie_add failed! <br>";
    }
    /*prepared statement bind and execute*/
    if (!$stmt->bind_param("iss", $rent, $name, $category)) {
        echo "Binding parameters failed!";
    }
    if (!$stmt->execute()) {
        echo "Execute failed!";
    }
    header("Location: http://web.engr.oregonstate.edu/~weckwera/290/wk6/mixed.php");
    exit();
}

function deleteMovie($array) {
    global $mysqli;

    $name = $mysqli->real_escape_string($array['movieName']);
    $category = $mysqli->real_escape_string($array['category']);

    /*prepare statement stage 1*/
    if (!($stmt = $mysqli->prepare("DELETE FROM movies WHERE name = ? AND
            category = ?"))) {
        echo "Prepare query movie_add failed! <br>";
    }
    /*prepared statement bind and execute*/
    if (!$stmt->bind_param("ss", $name, $category)) {
        echo "Binding parameters failed!";
    }
    if (!$stmt->execute()) {
        echo "Execute failed!";
    }
    header("Location: http://web.engr.oregonstate.edu/~weckwera/290/wk6/mixed.php");
    exit();
}


function addMovie ($array) {
    global $mysqli;

    $name = $mysqli->real_escape_string($array['movieName']);
    $length = $mysqli->real_escape_string($array['length']);
    if ((int)$length < 0) {
        echo "Length must be positive integer!";
        die();
    }
    else if ((int)$length == 0) {
        $length = NULL;
    }
    $category = $mysqli->real_escape_string($array['category']);
    

    /*prepare statement stage 1*/
    if (!($stmt = $mysqli->prepare("INSERT INTO movies(name, length, category)
            values(?, ?, ?)"))) {
        echo "Prepare query movie_add failed! <br>";
    }
    /*prepared statement bind and execute*/
    if (!$stmt->bind_param('sis', $name, $length, $category)) {
        echo "Binding parameters failed!";
    }
    if (!$stmt->execute()) {
        echo "Execute failed!";
    }
    header("Location: http://web.engr.oregonstate.edu/~weckwera/290/wk6/mixed.php");
    exit();
}

// THIS FUNCTION NOT TESTED!!!
//
//
function deleteAll ($array) {
    global $mysqli;
/*prepare statement stage 1*/
    if (!($stmt = $mysqli->prepare("TRUNCATE TABLE movies"))) {
        echo "Prepare query movie_add failed! <br>";
    }
    /*prepared statement bind and execute
    if (!$stmt->bind_param("sis", $name, $length, $category)) {
        echo "Binding parameters failed!";
    } */
    if (!$stmt->execute()) {
        echo "Execute failed!";
    }
    header("Location: http://web.engr.oregonstate.edu/~weckwera/290/wk6/mixed.php");
    exit();
}



?>
