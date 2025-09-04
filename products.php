<?php
$title = "Homepage";
include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);
?>

<body>
<?php
if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']); // intval zet deze waarde naar een integer getal
    $products = getProductsByCategory($categoryId);
} else {
    $products = getAllProducts();
}

if ($products->num_rows > 0) {
    echo "<h2 class='contentitle'>Products</h2>";
    echo "<div class='blue-line'></div>";
    echo "<div class='product-list'>";

    while ($row = $products->fetch_assoc()) {
        echo "<div class='product-item'>";
            echo "<p>€" . htmlspecialchars($row['productPrice']) . " </p>";
            echo "<img src='img/" . htmlspecialchars($row['productImage']) . "' width='100'>";
            echo "<h3>" . htmlspecialchars($row['productName']) . "</h3>";
        
            echo "<div class='bottom-buttons'>";
                echo "<a alt='Learn More' href='aboutgame.php?id=" . htmlspecialchars($row['productId']) . "'> 
                        <i class='fa-solid fa-circle-info'></i>
                      </a>";
        
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
            echo "</div>"; 
        echo "</div>"; 
    }

    echo "</div>"; 
} else {
    echo "<p>No products found.</p>";
}


HTMLfooter();
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




</body>
