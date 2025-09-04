<?php
session_start();
$title = "Homepage";
include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);


if (isset($_SESSION["login_success"])) {
    echo "<div class='success-message'>" . $_SESSION["login_success"] . "</div>";
    unset($_SESSION["login_success"]);
}


if (isset($_SESSION['user'])) {
    echo "<div class='welcome-msg'>Welcome, <strong>" . htmlspecialchars($_SESSION['user']) . "</strong>!</div>";
} else {
    echo "<div class='welcome-msg'>Welcome, Guest</div>";
}


$productIds = [10, 9, 24, 22, 29, 26];
$ids = implode(",", $productIds);


$sql = "SELECT * FROM products WHERE productId IN ($ids)";
$result = $dbConnection->query($sql);
?>

<body>


<header class="banner">
    <div class="banner-content">
        <br><br>
        <div class="bannerbg">
        <br><br><br>
        <h1>GAMEWORLD</h1>
        <p class="subtext">Welcome to Gameworld!</p>
        <div class="blue-line"></div>
        </div>
    </div>
   
</header>


<h2>Categories</h2>
<div class="blue-line"></div>

<div class="CategoryDisplay">
    <?php
    $categories = getCategories();
    if ($categories->num_rows > 0) {
        while ($row = $categories->fetch_assoc()) {
            echo "<div class='category'>";
            echo "<a href='products.php?id=" . $row['categoryId'] . "'>";
            echo "<img src='img/" . htmlspecialchars($row['categoryImage']) . "' alt='Category Image'>";
            echo "</a>";
            echo "</div>";
        }
    } else {
        echo "<p>No categories found.</p>";
    }
    ?>
</div>

<h2>Most Popular</h2>
<div class="blue-line"></div>

<div class="product-list">
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item'>";
            echo "<p>€" . htmlspecialchars($row['productPrice']) . "</p>";
            echo "<img src='img/" . htmlspecialchars($row['productImage']) . "' alt='" . htmlspecialchars($row['productName']) . "'>";
            echo "<h3>" . htmlspecialchars($row['productName']) . "</h3>";

            echo "<div class='bottom-buttons'>";

                // Learn More
                echo "<a href='aboutgame.php?id=" . htmlspecialchars($row['productId']) . "'> 
                        <i class='fa-solid fa-circle-info'></i>
                      </a>";

                // Add to Wishlist
                echo "<form method='post' action='favorites.php'>";
                echo "<input type='hidden' name='productId' value='" . htmlspecialchars($row['productId']) . "'>";
                echo "<div class='heart' data-id='" . htmlspecialchars($row['productId']) . "'>";
                echo "<i class='fas fa-heart'></i>";
                echo "</div>";
                echo "</form>";

                // Add to Cart
                echo "<form method='post' action='cart.php'>";
                echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['productId']) . "'>";
                echo "<button class='btn'>";
                echo "<i class='fa-solid fa-cart-shopping'></i>";
                echo "</button>";
                echo "</form>";

            echo "</div>"; 
        echo "</div>"; 
    }
    ?>
</div>

<?php HTMLfooter(); ?>
</body>
</html>
