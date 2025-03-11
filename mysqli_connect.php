<?php
DEFINE ('DB_HOST', 'localhost'); //Database server -- Typically "localhost"
DEFINE ('DB_USERNAME', 'infost490sp2501_endurify_user'); // Database user name -- Replace with your ePanther ID
DEFINE ('DB_PASSWORD', 'endurify_user!'); //Database User Password -- Your own password
DEFINE ('DB_NAME', 'infost490sp2501_endurify'); //Database Name -- Replace with your own database name


//This connects us to the database mluo_mysqlandphp
$dbc = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL:'. mysqli_connect_error());

?>