<?php
require_once('backend/database/Database.php');

try{
	//create a new instance of the database class
	$db = new Database();

	//Get the connection
	$conn = $db->getConnection();

	//If the connection is seccessful, ...print a success message
	echo "connected to database successfully!";
} catch (Exception $e) {
	//if the connection fails, print the error message
	echo $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Phone Book Application</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>

</body>
</html>