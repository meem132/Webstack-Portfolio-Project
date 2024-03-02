<?php
include 'includes/session.php';

// Check if the 'activate' button has been submitted
if(isset($_POST['activate'])){
    // Retrieve the user ID from the POST data
    $id = $_POST['id'];

    // Establish database connection
    $conn = $pdo->open();

    try{
        // Prepare and execute SQL query to update user status to active
        $stmt = $conn->prepare("UPDATE users SET status=:status WHERE id=:id");
        $stmt->execute(['status'=>1, 'id'=>$id]);
        $_SESSION['success'] = 'User activated successfully';
    }
    catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }

    // Close database connection
    $pdo->close();
}
else{
    $_SESSION['error'] = 'Select user to activate first';
}

// Redirect back to the users page
header('location: users.php');
?>
