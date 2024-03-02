<?php
include 'includes/session.php';

// Check if the 'upload' button has been submitted
if(isset($_POST['upload'])){
    // Retrieve form data
    $id = $_POST['id'];
    $filename = $_FILES['photo']['name'];

    // Check if a file has been uploaded
    if(!empty($filename)){
        // Move the uploaded file to the desired location
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);    
    }
    
    // Establish database connection
    $conn = $pdo->open();

    try{
        // Execute SQL query to update user photo
        $stmt = $conn->prepare("UPDATE users SET photo=:photo WHERE id=:id");
        $stmt->execute(['photo'=>$filename, 'id'=>$id]);
        
        // Provide success message upon successful photo update
        $_SESSION['success'] = 'User photo updated successfully';
    }
    catch(PDOException $e){
        // Provide error message if an exception occurs
        $_SESSION['error'] = $e->getMessage();
    }

    // Close database connection
    $pdo->close();
}
else{
    // Provide error message if the 'upload' button was not clicked
    $_SESSION['error'] = 'Select user to update photo first';
}

// Redirect back to the users page
header('location: users.php');
?>
