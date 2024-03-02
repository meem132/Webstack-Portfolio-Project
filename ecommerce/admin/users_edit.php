<?php
include 'includes/session.php';

// Check if the 'edit' button has been submitted
if(isset($_POST['edit'])){
    // Retrieve form data
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Establish database connection
    $conn = $pdo->open();

    // Retrieve user details from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
    $stmt->execute(['id'=>$id]);
    $row = $stmt->fetch();

    // Check if the provided password matches the current password
    if($password == $row['password']){
        // If the password remains the same, keep the current password
        $password = $row['password'];
    }
    else{
        // If a new password is provided, hash it
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    try{
        // Execute SQL query to update user information
        $stmt = $conn->prepare("UPDATE users SET email=:email, password=:password, firstname=:firstname, lastname=:lastname, address=:address, contact_info=:contact WHERE id=:id");
        $stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'address'=>$address, 'contact'=>$contact, 'id'=>$id]);

        // Provide success message upon successful update
        $_SESSION['success'] = 'User updated successfully';
    }
    catch(PDOException $e){
        // Provide error message if an exception occurs
        $_SESSION['error'] = $e->getMessage();
    }

    // Close database connection
    $pdo->close();
}
else{
    // Provide error message if the 'edit' button was not clicked
    $_SESSION['error'] = 'Fill up edit user form first';
}

// Redirect back to the users page
header('location: users.php');

?>
