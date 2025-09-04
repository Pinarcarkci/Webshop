<?php
$title = "Blog";
include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);

$categories = getBlogCategories($dbConnection);

$posts = isset($_GET['bCategoryId'])
    ? getBlogPosts($dbConnection, intval($_GET['bCategoryId']))
    : getBlogPosts($dbConnection);
?>

<body>
  <div class="blogcontainer">
    <div class="blogcontent">

      <main class="blog-posts">
        <h1 class="blogtitle">Blog</h1>
        <div class='blue-line'></div>
       

        <?php foreach ($posts as $post): ?>
          <div class="blog-post-wrapper">
            <article class="blog-post">
              <h2><?= htmlspecialchars($post['title']) ?></h2>
              <p><strong>Author:</strong> <?= htmlspecialchars($post['author']) ?> |
                 <strong>Date:</strong> <?= htmlspecialchars($post['date']) ?></p>
              <p><?= substr(htmlspecialchars($post['content']), 0, 200) ?>...</p>
              <a class="readmore" href="postdetails.php?id=<?= $post['id']?>">Read More</a>
            </article>
          </div>
        <?php endforeach; ?>
      </main>

      <aside class="blogsidebar">
        <h3>Categories</h3>
        <div class='blue-line'></div>
        <ul>
          <?php foreach ($categories as $category): ?>
            <li class="category-item">
              <a href="blog.php?bCategoryId=<?= $category['bCategoryId'] ?>">
                <?= htmlspecialchars($category['bCategoryName']) ?>
              </a>
            </li>
           
          <?php endforeach; ?>
          <a href="add_post.php" class="addpostlink">+ Add Post</a> 
        </ul>
      </aside>
 

    </div>
  </div>
</body>
