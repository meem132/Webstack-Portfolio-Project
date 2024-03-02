<?php
include 'includes/session.php';

if(isset($_POST['add'])){
    $name = $_POST['name'];

    try {
        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM category WHERE name=:name");
        $stmt->execute(['name'=>$name]);
        $row = $stmt->fetch();

        if($row['numrows'] > 0){
            $_SESSION['error'] = 'Category already exists';
        } else {
            $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
            $stmt->execute(['name'=>$name]);
            $_SESSION['success'] = 'Category added successfully';
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = $e->getMessage();
    } finally {
        if (isset($conn)) {
            $pdo->close();
        }
    }
} else {
    $_SESSION['error'] = 'Fill up category form first';
}

header('location: category.php');
?>
