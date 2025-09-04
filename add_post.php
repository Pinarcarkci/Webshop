<?php
$title = "Add Your Post!";
include 'functions.php';

HTMLhead($title);
displayNavbar($dbConnection);


$categories = getBlogCategories($dbConnection);


$message = ''; // de variabele een lege tekst


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titleInput = $_POST['title'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $category_id = intval($_POST['bCategoryId']);
    $content = $_POST['content'] ?? '';

    if ($titleInput && $author && $date && $category_id && $content) {
        if (addBlogPost($dbConnection, $titleInput, $author, $date, $category_id, $content)) {
            $message = "Post added successfully.";
        } else {
            $message = "Something went wrong while saving the post.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<?php if (!empty($message)): ?>
  <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<form action="add_post.php" method="POST">
  <fieldset>
    <legend>Add New Blog Post</legend>

    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="author">Author:</label><br>
    <input type="text" id="author" name="author" required><br><br>

    <label for="date">Date:</label><br>
    <input type="date" id="date" name="date" required><br><br>

    <label for="category">Category:</label><br>
    <select id="category" name="bCategoryId" required>
      <option value="">-- Select a category --</option>
      <?php foreach ($categories as $cat): ?>
        <option value="<?= $cat['bCategoryId'] ?>"><?= htmlspecialchars($cat['bCategoryName']) ?></option>
      <?php endforeach; ?>
    </select><br><br>

    <label for="content">Content:</label><br>
    <textarea id="content" name="content" rows="6" cols="40" required></textarea><br><br>

    <button type="submit">Submit</button>
  </fieldset>
</form>

<p><a href="blog.php">← Back to Blog</a></p>
