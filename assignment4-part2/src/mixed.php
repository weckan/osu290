<?php
ini_set('display_errors',1);
include "pure.php";
?>
<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <title>mixed PHP page</title>
    <link rel="stylesheet" href="stylesheet.css">
</header>
<body>
<form action='pure.php' method='post'>
    <label>Name:</label>
    <input type="text" name='movieName' required/>
    <label>Category:</label>
    <input type="text" name='category' />
    <label>Length:</label>
    <input type="number" name='length'/>
    <input type="submit" value="Add Movie" name="add_movie"/>
</form>
<br>
<form action='pure.php' method='post'>
    <input type="submit" value="Delete All Movies" name="delete_all_movies"/>
</form>
<br>
<?php

$categories = $mysqli->query("SELECT category FROM movies GROUP BY category");
echo "<form action='mixed.php' method='GET'><select name='FilterCategory'>";
echo "<option value='All Movies'>All Movies</option>";
while ($selectRow = $categories->fetch_object()) {
    if ($selectRow->category != NULL) {
        $cat = $selectRow->category;
        echo "<option value='$cat'>$cat</option>";
    }
}
echo "</select><input type='submit' value='Filter By Category'/>";
echo "</form>";

?>
<br>
<table>
<thead>
    <tr>
    <td>Name</td>
    <td>Category</td>
    <td>Length</td>
    <td>Rented?</td>
    <td>Rent/Return</td>
    <td>Delete Movie</td>
    </tr>
</thead>
<tbody>
<?php

$result = $mysqli->query("SELECT name, category, length, rented FROM movies");
while($obj = $result->fetch_object()) {
    $title = $obj->name;
    $cat = $obj->category;
    $leng = $obj->length;
    if($obj->rented == '1') {
        $rented = 'checked out';
    }
    else {
        $rented = 'available';
    }
    if ($rented == "available") {
        $rent = "<form action='pure.php' method='post'>
            <input type='hidden' name='movieName' value='$title'/>
            <input type='hidden' name='category' value='$cat'/>
            <input type='hidden' name='rent_movie' value='1'/>
            <input type='submit' method='post' value='Rent Movie'/></form>";
    }
    else {
        $rent = "<form action='pure.php' method='post'>
            <input type='hidden' name='movieName' value='$title'/>
            <input type='hidden' name='category' value='$cat'/>
            <input type='hidden' name='rent_movie' value='0'/>
            <input type='submit' method='post' value='Return Movie'/></form>";
    }
    $delete = "<form action='pure.php' method='post'>
        <input type='hidden' name='movieName' value='$title'/>
        <input type='hidden' name='category' value='$cat'/>
        <input type='hidden' name='delete_movie' value='true''/>
        <input type='submit' method='post' value='Delete Movie'/></form>";
    if(isset($_GET['FilterCategory'])) {
        if ($cat == $_GET['FilterCategory'] || 
            $_GET['FilterCategory'] == "All Movies") {
                echo "<tr><td>$title</td><td>$cat</td><td>$leng</td>
                <td>$rented</td><td>$rent</td><td>$delete</td></tr>";
        }
    }
    else {
            echo "<tr><td>$title</td><td>$cat</td><td>$leng</td>
                <td>$rented</td><td>$rent</td><td>$delete</td></tr>";
    }
}
?>

