<?php
/**
    $mysqli = include "../db_conn.php";
    //bind to $name
    if ($stmt = $mysqli->prepare("SELECT category.name FROM category")) {
        $stmt->bind_result($name);
        $OK = $stmt->execute();
    }
    //put all of the resulting names into a PHP array
    $result_array = Array();
    while($stmt->fetch()) {
        $result_array[] = $name;
    }
    //convert the PHP array into JSON format, so it works with javascript
    echo $result_array;
    $json_array = json_encode($result_array);
**/

include "db_conn.php";
/**
$sql = "SELECT song FROM users";
$result = mysql_query($sql) or die ('Query Error: ' . mysql_error()); 
while ($results = mysql_fetch_array($result))
{
    $gender[] = $results;
}

**/
$result = mysqli_query($conn,"SELECT * FROM users");
$markers = array();
while ($row = mysqli_fetch_array($result)) {
    $markers[] = array(
        'name' => $row['name']
    );
}
print_r($markers);

$markersJson = json_encode($markers);



/**
$result = mysqli_query($conn,"SELECT name FROM users");
$rows = [];
while($row = mysqli_fetch_array($result))
{
    $rows = $row;
}

print_r($rows);

**/
?>


