<?php
include "db.php";      // db.php first
include "header.php";  // header after db.php
?>

<link rel="stylesheet" href="style.css">

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1>GlowSkin</h1>
            <p>Discover the best skincare products from trusted stores</p>
            <a href="products.php" class="btn-primary">Shop Now</a>
        </div>
    </div>
</section>


<!-- STORES SECTION -->
<section class="section stores">
    <h2>Browse Stores</h2>
    <div class="grid">
        <?php
        $result = mysqli_query($conn,"SELECT * FROM vendors");
        while($s = mysqli_fetch_assoc($result)){ ?>
        <div class="card store-card">
            <h3><?php echo htmlspecialchars($s['name']); ?></h3>
            <p><?php echo htmlspecialchars($s['description'] ?? 'No description available'); ?></p>
            <a href="products.php?vendor=<?php echo $s['id']; ?>" class="btn-secondary">View Products</a>
        </div>
        <?php } ?>
    </div>
</section>

<!-- PRODUCTS SECTION -->
<section class="section products">
    <h2>Featured Products</h2>
    <div class="grid">
        <?php
        $q = mysqli_query($conn,
        "SELECT products.*, vendors.name as vendor_name 
        FROM products 
        JOIN vendors ON vendors.id = products.vendor_id
        LIMIT 12");

        while($p = mysqli_fetch_assoc($q)){ ?>
        <div class="card product-card">
            <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-info">
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p class="vendor">Vendor: <?php echo htmlspecialchars($p['vendor_name']); ?></p>
                <p class="price">₦<?php echo number_format($p['price']); ?></p>
                <a href="add_to_cart_ajax.php?id=<?php echo $p['id']; ?>" class="btn-add-cart" data-id="<?php echo $p['id']; ?>">Add to Cart</a>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<!-- Add JS at the bottom to handle AJAX add-to-cart -->
<script>
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll('.btn-add-cart').forEach(button => {
        button.addEventListener('click', function(e){
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            fetch('add_to_cart_ajax.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                // Show simple alert (you can replace with toast)
                alert('Product added to cart!');
                // Update cart count
                const cartSpan = document.querySelector('.cart-icon span');
                cartSpan.textContent = data.cart_count;
            })
            .catch(err => console.error(err));
        });
    });
});
</script>
