<?php
$title = "Post Details";
include 'functions.php';

HTMLhead($title);
displayNavbar($dbConnection);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<p>Invalid post ID.</p>";
    exit;
}

$post_id = intval($_GET['id']);
$post = getSinglePost($dbConnection, $post_id);

if (!$post) {
    echo "<p>Post not found.</p>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['comment'])) { 
    // Controleert of het formulier met method="post" is verzonden
    $name = trim($_POST['name']); //De trim() functie verwijdert onnodige spaties 
    $comment = trim($_POST['comment']); 
    // daaromk an jij geen spaties gebruiken bij schrijven van het naam

    if (!empty($name) && !empty($comment)) { // ! betekent "not"
        $stmt = $dbConnection->prepare("INSERT INTO comments (post_id, name, comment, date) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $post_id, $name, $comment);
        $stmt->execute();
        $stmt->close();
        header("Location: postdetails.php?id=" . $post_id); 
        exit;
    }
}


$comments = [];
$stmt = $dbConnection->prepare("SELECT name, comment, date FROM comments WHERE post_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}
$stmt->close();
?>

<<div class="content-wrapper">
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <p><strong>Author:</strong> <?= htmlspecialchars($post['author']) ?></p>
    <p><strong>Date:</strong> <?= htmlspecialchars($post['date']) ?></p>
    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
    <p><a class="addpostlink" href="blog.php">← Back to Blog</a></p>
</div>

<h2>Leave a Comment</h2>
    <form method="post" class="comment-form">
        <input type="text" name="name" class="comment-input" placeholder="Name" required>
        <textarea name="comment" class="comment-textarea" placeholder="Comment" rows="4" required></textarea>
        <button type="submit" class="comment-button">Send</button>
    </form>

   
    <h2>Comments</h2>
    <?php if (count($comments) > 0): ?>
        <?php foreach ($comments as $c): ?>
            <div class="comment-box">
                <p><strong><?= htmlspecialchars($c['name']) ?></strong></p>
                <p><?= nl2br(htmlspecialchars($c['comment'])) ?></p>
                <small><?= htmlspecialchars($c['date']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No comment yet.</p>
    <?php endif; ?>
</div>