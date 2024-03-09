<?php
require_once("db.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); 
    return $data;
}

$username = "";
// TODO 5a: Get the username field from the incoming request.
$username = $_GET['q'];

if (strlen($username) > 0) {

    // Connect to the database and verify the connection
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $options);

        // Query to get the last login detail for the user
        $query = "SELECT Loggers.username, Logins.timestamp FROM Loggers INNER JOIN Logins on (Loggers.uid = Logins.uid) WHERE Loggers.username = '$username' ORDER BY Logins.timestamp DESC LIMIT 3;";
        $result = $db->query($query);

        // Create an empty array
        $jsonArray = array();
        $i = 0;

        // TODO 5b: Loop the '$result' variable to store each row in the '$jsonArray' array.
        foreach($result as $raw){
            $jsonArray[$i] = $raw;
            $i = $i + 1;
        }

        // TODO 5c: Encode the array into a JSON object and send it back to the client as a response.
        echo (json_encode($jsonArray));

        // Close the database connection
        $db = null;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>