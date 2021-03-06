<?php
// getting the data from angular.
    $postdata = file_get_contents("php://input");
    $parameters = json_decode($postdata,true);
    $pseudo = $parameters["pseudo"];
    $name = $parameters["name"];
    

// connexion data
    $servername = "db624774209.db.1and1.com";
    $database   = "db624774209";
    $username = "dbo624774209";
    $passwordDB = "Not my password D:";
try {
    
    // connexion
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $passwordDB);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // request
    $request = $conn->prepare('SELECT COUNT(u.pseudo) AS counting FROM users u, events e, engage eng 
        WHERE e.event_id = eng.event_id 
        AND eng.id = u.id 
        AND e.name = :name 
        AND u.id = (SELECT id FROM users WHERE pseudo = :pseudo)')
    or exit(print_r($conn->errorInfo())); 
    $request->execute(array(
        'pseudo' => $pseudo,
        'name' => $name
        ));

    // check
    $test = $request->fetchAll();
    $testNumber = $test[0][0];
    if ($testNumber == '0') {
       echo("false");
    } else {
        echo("true");
    }


}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
