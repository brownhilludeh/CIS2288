<?php
/**
 * Description: Delete book page for Book Management System
 * 
 * File: deleteBook.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

session_start();
require_once('checkLoggedIn.php');
require_once("config.php");

// Get book ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?message=error");
    exit;
}

$bookId = (int) $_GET['id'];

// Check if book exists
$checkQuery = "SELECT * FROM books WHERE id = " . $bookId;
$checkResult = $mysqli->query($checkQuery);

if ($checkResult->num_rows == 0) {
    header("Location: index.php?message=error");
    exit;
}

$bookData = $checkResult->fetch_assoc();

// Process deletion
if (isset($_POST['confirm_delete'])) {
    $deleteQuery = "DELETE FROM books WHERE id = " . $bookId;

    if ($mysqli->query($deleteQuery)) {
        header("Location: index.php?message=deleted");
        exit;
    } else {
        $error = "Database error: " . $mysqli->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book-O-Rama - Delete Book</title>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <header class="site-header">
            <h1>Book-O-Rama</h1>
            <nav class="main-nav">
                <a href="index.php">Book Inventory</a>
                <span class="user-info">Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="logout-link">Logout</a>
            </nav>
        </header>

        <div class="form-container">
            <h2>Delete Book</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="delete-warning">
                <p class="warning-text">⚠️ Are you sure you want to delete this book? This action cannot be undone.</p>
            </div>

            <!-- Display Book Details -->
            <div class="book-details">
                <h3>Book Details</h3>
                <table class="details-table">
                    <tr>
                        <th>ID:</th>
                        <td><?php echo htmlspecialchars($bookData['id']); ?></td>
                    </tr>
                    <tr>
                        <th>ISBN:</th>
                        <td><?php echo htmlspecialchars($bookData['isbn']); ?></td>
                    </tr>
                    <tr>
                        <th>Author:</th>
                        <td><?php echo htmlspecialchars($bookData['author']); ?></td>
                    </tr>
                    <tr>
                        <th>Title:</th>
                        <td><?php echo htmlspecialchars($bookData['title']); ?></td>
                    </tr>
                    <tr>
                        <th>Price:</th>
                        <td>$<?php echo number_format($bookData['price'], 2); ?></td>
                    </tr>
                </table>
            </div>

            <!-- Delete Confirmation Form -->
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $bookId; ?>" method="post" class="book-form">
                <div class="form-actions">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete This Book</button>
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