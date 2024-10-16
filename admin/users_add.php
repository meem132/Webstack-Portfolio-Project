<?php
include 'includes/session.php';

// Check if the 'add' button has been submitted
if(isset($_POST['add'])){
    // Retrieve form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Establish database connection
    $conn = $pdo->open();

    // Check if email already exists in the database
    $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email=:email");
    $stmt->execute(['email'=>$email]);
    $row = $stmt->fetch();

    if($row['numrows'] > 0){
        $_SESSION['error'] = 'Email already taken';
    }
    else{
        // Hash the password for security
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        // Retrieve filename and move uploaded photo to destination folder
        $filename = $_FILES['photo']['name'];
        $now = date('Y-m-d');
        if(!empty($filename)){
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);    
        }

        try{
            // Insert user data into the database
            $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname, address, contact_info, photo, status, created_on) VALUES (:email, :password, :firstname, :lastname, :address, :contact, :photo, :status, :created_on)");
            $stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'address'=>$address, 'contact'=>$contact, 'photo'=>$filename, 'status'=>1, 'created_on'=>$now]);
            $_SESSION['success'] = 'User added successfully';

        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }
    }

    // Close database connection
    $pdo->close();
}
else{
    $_SESSION['error'] = 'Fill up user form first';
}

// Redirect back to the users page
header('location: users.php');
?>
