<?php 
include 'includes/session.php';

// Check if the 'id' parameter has been submitted via POST
if(isset($_POST['id'])){
    // Retrieve the user ID from the POST data
    $id = $_POST['id'];
    
    // Establish a database connection
    $conn = $pdo->open();

    // Prepare and execute a SQL query to retrieve user information based on the provided ID
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$id]);
    
    // Fetch the row containing user information
    $row = $stmt->fetch();
    
    // Close the database connection
    $pdo->close();

    // Encode the retrieved user information as JSON and output it
    echo json_encode($row);
}
?>
