<?php
include $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Remove any ? or /
$requested_url = str_replace('?', '', $_SERVER['REQUEST_URI']);
$requested_url = str_replace('/', '', $requested_url);

// Check if there is a match in the database
$sql = "SELECT * FROM `url_redirects` WHERE `unique_id` = '$requested_url'";
$result = $conn->query($sql);

// If there is a match, redirect to the new url
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        header("Location: " . $row['long_url']);
        die();
    }
} else {
    header("Location: /");
    die();
}