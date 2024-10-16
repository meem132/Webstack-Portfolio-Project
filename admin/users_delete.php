<?php
include 'includes/session.php';

// Check if the 'delete' button has been submitted
if(isset($_POST['delete'])){
    // Retrieve the ID of the user to be deleted
    $id = $_POST['id'];
    
    // Establish database connection
    $conn = $pdo->open();

    try{
        // Execute SQL query to delete the user
        $stmt = $conn->prepare("DELETE FROM users WHERE id=:id");
        $stmt->execute(['id'=>$id]);

        // Provide success message upon successful deletion
        $_SESSION['success'] = 'User deleted successfully';
    }
    catch(PDOException $e){
        // Provide error message if an exception occurs
        $_SESSION['error'] = $e->getMessage();
    }

    // Close database connection
    $pdo->close();
}
else{
    // Provide error message if the 'delete' button was not clicked
    $_SESSION['error'] = 'Select user to delete first';
}

// Redirect back to the users page
header('location: users.php');

?>
