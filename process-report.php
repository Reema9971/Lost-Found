<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Process form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $location = $_POST['location'];
        $lost_date = $_POST['lost_date'];
        $status = $_POST['status'];
        $image_path = '';

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "uploads/";
            $target_file = $target_dir . uniqid() . '_' . basename($_FILES['image']['name']);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            }
        }

        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO items 
            (user_id, title, description, category, location, lost_date, status, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $_SESSION['user_id'],
            $title,
            $description,
            $category,
            $location,
            $lost_date,
            $status,
            $image_path
        ]);

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();

    } catch(PDOException $e) {
        die("Database error: " . $e->getMessage());
    } catch(Exception $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    header("Location: report.php");
    exit();
}