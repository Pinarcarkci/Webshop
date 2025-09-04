<?php
session_start();
$title = "Your Favorites";
require 'functions.php';

HTMLhead($title);
displayNavbar($dbConnection);

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo "You must be logged in.";
    exit();
}


if (isset($_POST['productId'])) {
    $product_id = intval($_POST['productId']);
    $_SESSION['favorites'] = $_SESSION['favorites'] ?? [];

    if (!in_array($product_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'][] = $product_id;
    }
}


if (isset($_POST['remove_favorite_id'])) {
    $product_id = intval($_POST['remove_favorite_id']);
    if (isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$product_id]);
    }
}

?>
<body>
<?php
$favorites = $_SESSION['favorites'] ?? [];

if (count($favorites) > 0) {
    $ids = implode(',', array_map('intval', $favorites));
    $query = "SELECT * FROM products WHERE productId IN ($ids)";
    $result = $dbConnection->query($query);

    echo "<h2 class='contentitle'>Your Favorites</h2>";
    echo "<div class='blue-line'></div>";
    echo "<div class='product-list'>";

    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-item'>";
            echo "<p>€" . htmlspecialchars($row['productPrice']) . "</p>";
            echo "<img src='img/" . htmlspecialchars($row['productImage']) . "' width='100'>";
            echo "<h3>" . htmlspecialchars($row['productName']) . "</h3>";

            echo "<div class='bottom-buttons'>";

                
                echo "<a href='aboutgame.php?id=" . htmlspecialchars($row['productId']) . "'>
                        <i class='fa-solid fa-circle-info'></i>
                      </a>";

              //romeve favorite
                echo "<form method='post' action='favorites.php'>";
                    echo "<input type='hidden' name='remove_favorite_id' value='" . htmlspecialchars($row['productId']) . "'>";
                    echo "<button class='remove-heart' title='Remove from favorites'>";
                        echo "<i class='fas fa-heart-broken'></i>";
                    echo "</button>";
                echo "</form>";

                
                echo "<form method='post' action='cart.php'>";
                    echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['productId']) . "'>";
                    echo "<button class='btn'>";
                        echo "<i class='fa-solid fa-cart-shopping'></i>";
                    echo "</button>";
                echo "</form>";

            echo "</div>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "<p class='nofavorites'>No favorite products found.</p>";
}

HTMLfooter();
?>