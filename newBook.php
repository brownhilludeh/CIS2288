<?php
/**
 * Description: Add new book page for Book Management System
 * 
 * File: newBook.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

session_start();
require_once('checkLoggedIn.php');
require_once("config.php");

$errors = [];
$formData = [];

// Process form submission
if (isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $isbn = trim($mysqli->real_escape_string($_POST['isbn']));
    $author = trim($mysqli->real_escape_string($_POST['author']));
    $title = trim($mysqli->real_escape_string($_POST['title']));
    $price = trim($_POST['price']);

    // Validation
    if (empty($isbn)) {
        $errors[] = "ISBN is required";
    } elseif (strlen($isbn) > 13) {
        $errors[] = "ISBN must be 13 characters or less";
    }

    if (empty($author)) {
        $errors[] = "Author is required";
    } elseif (strlen($author) > 50) {
        $errors[] = "Author name must be 50 characters or less";
    }

    if (empty($title)) {
        $errors[] = "Title is required";
    } elseif (strlen($title) > 100) {
        $errors[] = "Title must be 100 characters or less";
    }

    if (empty($price)) {
        $errors[] = "Price is required";
    } elseif (!is_numeric($price) || $price < 0) {
        $errors[] = "Price must be a valid positive number";
    } elseif ($price > 99.99) {
        $errors[] = "Price cannot exceed $99.99";
    }

    // Check if ISBN already exists
    if (empty($errors)) {
        $checkQuery = "SELECT id FROM books WHERE isbn = '" . $isbn . "'";
        $checkResult = $mysqli->query($checkQuery);
        if ($checkResult->num_rows > 0) {
            $errors[] = "A book with this ISBN already exists";
        }
    }

    // If no errors, insert the book
    if (empty($errors)) {
        $insertQuery = "INSERT INTO books (isbn, author, title, price) VALUES ('" . $isbn . "', '" . $author . "', '" . $title . "', " . $price . ")";

        if ($mysqli->query($insertQuery)) {
            header("Location: index.php?message=added");
            exit;
        } else {
            $errors[] = "Database error: " . $mysqli->error;
        }
    } else {
        // Store form data to repopulate form
        $formData = $_POST;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book-O-Rama - Add New Book</title>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="site-header">
            <h1>Bookorama</h1>
            <nav class="main-nav">
                <a href="index.php">Book Inventory</a>
                <span class="user-info">Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="logout-link">Logout</a>
            </nav>
        </header>

        <div class="form-container">
            <h2>Add New Book</h2>

            <!-- Display Errors -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <strong>Please correct the following errors:</strong>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Add Book Form -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="book-form">
                <div class="form-group">
                    <label for="isbn">ISBN <span class="required">*</span></label>
                    <input type="text" id="isbn" name="isbn" class="form-control" maxlength="13" value="<?php echo isset($formData['isbn']) ? htmlspecialchars($formData['isbn']) : ''; ?>" required>
                    <small>Maximum 13 characters</small>
                </div>

                <div class="form-group">
                    <label for="author">Author <span class="required">*</span></label>
                    <input type="text" id="author" name="author" class="form-control" maxlength="50" value="<?php echo isset($formData['author']) ? htmlspecialchars($formData['author']) : ''; ?>" required>
                    <small>Maximum 50 characters</small>
                </div>

                <div class="form-group">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" maxlength="100" value="<?php echo isset($formData['title']) ? htmlspecialchars($formData['title']) : ''; ?>" required>
                    <small>Maximum 100 characters</small>
                </div>

                <div class="form-group">
                    <label for="price">Price <span class="required">*</span></label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" max="99.99" value="<?php echo isset($formData['price']) ? htmlspecialchars($formData['price']) : ''; ?>" required>
                    <small>Maximum $99.99</small>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-primary">Add Book</button>
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php
$mysqli->close();
?>