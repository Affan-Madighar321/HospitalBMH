<?php
require_once('../inc/connection.php');

$currentDate = date('Y-m-d');
$sqlDelete = "DELETE FROM availability WHERE available_date < '$currentDate'";
$resultDelete = mysqli_query($conn, $sqlDelete);

if ($resultDelete) {
    echo "Past availability records deleted successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
