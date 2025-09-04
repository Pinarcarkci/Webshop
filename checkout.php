<?php
session_start(); 

$title = "Checkout";
include("functions.php");


HTMLhead($title);
displayNavbar($dbConnection); 


$conn = $dbConnection;

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty.";
    exit;
}

if (!isset($_SESSION['userId'])) {
    echo "You must be logged in to checkout.";
    exit;
}

$userId = $_SESSION['userId'];
$orderDate = date("Y-m-d H:i:s");

//  Save order
$sql = "INSERT INTO `order` (orderDate, userId) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $orderDate, $userId);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();

//  Save products from cart
$sql = "INSERT INTO `orderproducts` (productId, productQuantity, orderId) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($_SESSION['cart'] as $productId => $productDetails) {
    $quantity = $productDetails['quantity'];
    $stmt->bind_param("iii", $productId, $quantity, $orderId);
    $stmt->execute();
}
$stmt->close();

//  Clear cart
unset($_SESSION['cart']);
?>
<body>
<div class="thank-you-wrapper">
  <div class="check-mark-block">
    <div class="check-mark-wrapper">
      <span></span>
      <span></span>
    </div>
  </div>
  <h3 class="order-title">🎉 Thank you for your order!🎉</h3>
  <p class="order-message">Your order has been placed successfully and will be processed soon. <br>Have a great day!</p>
  <a class="order-link" href="products.php">Continue Shopping</a>
</div>

</body>
</html>