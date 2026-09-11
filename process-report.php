<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        verifyCsrfToken();
        // Process form data
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $category = $_POST['category'] ?? '';
        $location = trim($_POST['location'] ?? '');
        $lost_date = $_POST['lost_date'] ?? '';
        $status = $_POST['status'] ?? '';
        $image_path = '';
        $date = DateTime::createFromFormat('!Y-m-d', $lost_date);

        $categories = ['electronics', 'documents', 'jewelry', 'clothing', 'other'];
        if ($title === '' || $description === '' || $location === '' || !in_array($category, $categories, true)
            || !in_array($status, ['lost', 'found'], true)
            || $date === false || $date->format('Y-m-d') !== $lost_date) {
            throw new InvalidArgumentException('Please provide valid item details.');
        }

        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                throw new InvalidArgumentException('The image upload failed. Please try again.');
            }
            if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                throw new InvalidArgumentException('Images must be 5 MB or smaller.');
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($_FILES['image']['tmp_name']);
            $extensions = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
            ];
            if (!isset($extensions[$mime]) || @getimagesize($_FILES['image']['tmp_name']) === false) {
                throw new InvalidArgumentException('Only valid JPEG, PNG, GIF, and WebP images are allowed.');
            }

            $target_dir = "uploads/";
            if (!is_dir($target_dir) || !is_writable($target_dir)) {
                throw new RuntimeException('Image storage is unavailable.');
            }
            $target_file = $target_dir . bin2hex(random_bytes(16)) . '.' . $extensions[$mime];
            
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

    } catch (InvalidArgumentException $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: report.php');
        exit();
    } catch (PDOException $e) {
        error_log('Item creation failed: ' . $e->getMessage());
        $_SESSION['error'] = 'Unable to save the item. Please try again.';
        header('Location: report.php');
        exit();
    } catch (Exception $e) {
        error_log('Item upload failed: ' . $e->getMessage());
        $_SESSION['error'] = 'Unable to process the image. Please try again.';
        header('Location: report.php');
        exit();
    }
} else {
    header("Location: report.php");
    exit();
}
