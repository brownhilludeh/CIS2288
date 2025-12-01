<?php
/**
 * Description: Index page for Book Management System
 * Main page displaying book inventory with sorting functionality
 * 
 * File: index.php
 * @author Brownhill Udeh
 * @since 2025-11-28
 */

//Start session
session_start();
require_once("config.php");

// Check if user is logged in (but don't redirect if not)
$isLoggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];

// Determine sort order
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'title';
$validSorts = ['title', 'author', 'price', 'isbn'];

// Validate sort parameter
if (!in_array($sortBy, $validSorts)) {
    $sortBy = 'title';
}

// Build query with sorting
$query = "SELECT * FROM books ORDER BY " . $sortBy;
if ($sortBy == 'price') {
    $query .= " ASC";
}

$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book-O-Rama - Book Inventory</title>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>
    <div class="container">
         <!-- Header -->
        <header class="site-header">
            <h1>Book-O-Rama</h1>
            <nav class="main-nav">
                <a href="index.php" class="active">Book Inventory</a>
                <?php if ($isLoggedIn): ?>
                    <span class="user-info">Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                    <a href="logout.php" class="logout-link">Logout</a>
                <?php else: ?>
                    <a href="login.php">Admin Login</a>
                <?php endif; ?>
            </nav>
        </header>

        <!-- Success/Error Messages -->
        <?php if (isset($_GET['message'])): ?>
            <?php if($_GET['message'] == 'loggedOut'): ?>
                <div class="alert alert-info">You have been logged out.</div>
            <?php elseif($_GET['message'] == 'loggedIn'): ?>
                <div class="alert alert-success">Hello <?php echo htmlspecialchars($_SESSION['username']); ?>, you are now logged in.</div>
            <?php endif; ?>
            <?php if ($_GET['message'] == 'added'): ?>
                <div class="alert alert-success">Book added successfully!</div>
            <?php elseif ($_GET['message'] == 'updated'): ?>
                <div class="alert alert-success">Book updated successfully!</div>
            <?php elseif ($_GET['message'] == 'deleted'): ?>
                <div class="alert alert-success">Book deleted successfully!</div>
            <?php elseif ($_GET['message'] == 'error'): ?>
                <div class="alert alert-error">An error occurred. Please try again.</div>
            <?php endif; ?>
        <?php endif; ?>

        

        <!-- Welcome Message for Logged In Users -->
        <?php if ($isLoggedIn): ?>
            <div class="welcome-message">
                <h2>CIS Book Inventory - Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            </div>
        <?php else: ?>
            <h2>CIS Book Inventory</h2>
        <?php endif; ?>

        <!-- Book Table -->
        <div class="table-container">
            <table class="book-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th><a href="?sort=isbn">ISBN</a></th>
                        <th><a href="?sort=author">Author</a></th>
                        <th><a href="?sort=title">Title</a></th>
                        <th><a href="?sort=price">Price</a></th>
                        <?php if ($isLoggedIn): ?>
                            <th colspan="2">Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                                <td><?php echo htmlspecialchars($row['author']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo number_format($row['price'], 2); ?></td>
                                <?php if ($isLoggedIn): ?>
                                    <td class="action-cell">
                                        <a href="editBook.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                                    </td>
                                    <td class="action-cell">
                                        <a href="deleteBook.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this book?')">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $isLoggedIn ? '7' : '5'; ?>" class="no-data">No books found in inventory</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Book Count -->
        <div class="book-count">
            Number of books found: <?php echo $result->num_rows; ?>
        </div>

        <!-- Add New Book Button (Only for logged in users) -->
        <?php if ($isLoggedIn): ?>
            <div class="add-book-section">
                <a href="newBook.php" class="btn btn-primary">Add a New Book</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
<?php
$mysqli->close();
?>