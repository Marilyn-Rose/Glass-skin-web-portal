<?php
session_start();
include "db.php";
include "header.php";
?>

<link rel="stylesheet" href="style.css">

<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
        echo "<p class='empty-cart'>Your cart is empty.</p>";
        echo '<a href="products.php" class="btn-checkout" style="
            display:inline-block;
            background:#111;
            color:#fff;
            padding:10px 16px;
            border-radius:6px;
            text-decoration:none;
            font-weight:600;">
            Browse Products
        </a>';
        return;
    }

    $grand_total = 0;
    ?>

    <table class="cart-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        <?php
        foreach($_SESSION['cart'] as $id => $qty){

            $id = intval($id);
            $qty = intval($qty);

            $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
            $p = mysqli_fetch_assoc($query);

            if(!$p){
                unset($_SESSION['cart'][$id]);
                continue;
            }

            $total = $p['price'] * $qty;
            $grand_total += $total;
        ?>
            <tr>
                <td>
                    <img class="cart-img"
                         src="<?php echo htmlspecialchars($p['image']); ?>"
                         alt="<?php echo htmlspecialchars($p['name']); ?>">
                </td>

                <td><?php echo htmlspecialchars($p['name']); ?></td>

                <td>₦<?php echo number_format($p['price']); ?></td>

                <td><?php echo $qty; ?></td>

                <td>₦<?php echo number_format($total); ?></td>

                <td>
                    <a class="btn-remove"
                       href="remove_from_cart.php?id=<?php echo $id; ?>">
                       Remove
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div class="checkout-section">
        <h3>Grand Total: ₦<?php echo number_format($grand_total); ?></h3>

        <a href="checkout.php" class="btn-checkout" style="
            display:inline-block;
            background:#111;
            color:#fff;
            padding:12px 20px;
            border-radius:6px;
            text-decoration:none;
            font-weight:600;
        ">
            Proceed to Checkout
        </a>
    </div>

</div>
