<?php
$title = "Game Details";
include("functions.php");
HTMLhead($title);
displayNavbar($dbConnection);

?>

<body>
<?php

if (isset($_GET['id'])) {
    $productId = intval($_GET['id']);

    $product = getProductById($productId);

    if ($product->num_rows > 0) {
        echo "<h2 class='contentitle'>About Game</h2>";
        echo "<div class='blue-line'></div>";
        echo "<div class='about-item'>";

        while ($row = $product->fetch_assoc()) {
            echo "<img src='img/" . htmlspecialchars($row['productImage']) . "' width='100'>";
            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['productId']) . "'>";
            echo "<div class='bottom-buttons'>";

            echo "<form method='post' action='favorites.php'>";
            echo "<input type='hidden' name='productId' value='" . htmlspecialchars($row['productId']) . "'>";
            echo "<div class='heart' data-id='" . htmlspecialchars($row['productId']) . "'>";
          echo "<i class='fas fa-heart'></i>";
      echo "</div>";
      echo "</form>";
      
            echo "<form method='post' action='cart.php'>";
            echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['productId']) . "'>";
            echo "<button class='btn'>";
                echo "<i class='fa-solid fa-cart-shopping'></i>";
            echo "</button>";
        echo "</form>";
            echo "<p class='price'>€"  . htmlspecialchars($row['productPrice']) . "</p>";
            
            echo "</div>"; 

       
            echo "<h3>" . htmlspecialchars($row['productName']) . "</h3>";
        
            echo "<p>" . htmlspecialchars($row['productDetails']) . "</p>";

    echo "</div>"; 
echo "</div>"; 
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>"; 
        }

        echo "</div>";
    } else {
        echo "<p>No product found.</p>";
    }
} else {
    echo "<p>Invalid product ID.</p>";
}
?>

<script>
    document.querySelectorAll('.heart').forEach(heart => {
        heart.onclick = () => {
            heart.classList.toggle('liked');

            const productId = heart.dataset.id;

            fetch('favorites.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'productId=' + productId
            }).then(res => {
                if (res.status === 401) {
                    alert("You must be logged in to add to favorites.");
                }
            });
        };
    });
</script>



