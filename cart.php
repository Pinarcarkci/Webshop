<?php
session_start();
$title = "Shopping Cart";
include("functions.php");

HTMLhead($title);
displayNavbar($dbConnection);

// Handle adding products
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    $query = "SELECT * FROM products WHERE productId = $product_id";
    $result = $dbConnection->query($query);
    $product = $result->fetch_assoc();

    if ($product) {
        $_SESSION['cart'][$product_id] = [
            "name" => $product['productName'],
            "price" => $product['productPrice'],
            "image" => trim($product['productImage']),
            "quantity" => isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id]['quantity'] + 1 : 1
        ];
    }
}

// Handle removing products
if (isset($_POST['remove_product_id'])) {
    $product_id = $_POST['remove_product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Handle updating quantities
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = max(1, intval($_POST['quantity']));
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
    }
}

// Handle clearing the cart
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
}
?>



<div class="cart-container">
    <h2>SHOPPING CART</h2>
    
    <?php if (!empty($_SESSION['cart'])) : ?>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $grandTotal = 0;
                    foreach ($_SESSION['cart'] as $id => $item) : 
                        $totalPrice = $item['price'] * $item['quantity'];
                        $grandTotal += $totalPrice;
                    ?>
                        <tr>
                            <td class="product-info">
                                <img src="img/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-img">
                                <span><?php echo $item['name']; ?></span>
                            </td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form method="POST" class="quantity-form">
                                    <input type="hidden" name="product_id" value="<?php echo $id; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                    <button type="submit" name="update_quantity">Update</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format($totalPrice, 2); ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="remove_product_id" value="<?php echo $id; ?>">
                                    <button type="submit" class="remove-btn">✖</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr class="total-row">
                        <td colspan="3"></td> 
                        <td class="total-label"><strong>Total:</strong></td>
                        <td class="total-value">$<?php echo number_format($grandTotal, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="cart-footer">
            <form method="POST">
                <button type="submit" name="clear_cart" class="clear-cart">Clear Cart</button>
            </form>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </div>

    <?php else : ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php HTMLfooter(); ?>
