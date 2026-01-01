<?php
include "header.php";
include "db.php";

// Vendor filter
$vendor_id = isset($_GET['vendor']) ? intval($_GET['vendor']) : 0;

// Search feature
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Build SQL
$sql = "SELECT products.*, vendors.name AS vendor_name 
        FROM products 
        JOIN vendors ON vendors.id = products.vendor_id";

$conditions = [];

// If vendor filter applied
if($vendor_id){
    $conditions[] = "products.vendor_id = $vendor_id";
}

// If search applied
if($search !== ""){
    $safe = mysqli_real_escape_string($conn, $search);
    $conditions[] = "(products.name LIKE '%$safe%' OR products.description LIKE '%$safe%')";
}

// Attach WHERE if needed
if(!empty($conditions)){
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="style.css">

<div class="section">
<h2>Products</h2>

<div class="grid">

<?php
if(mysqli_num_rows($result) > 0){
    while($p = mysqli_fetch_assoc($result)){ ?>
    
    <div class="card">
        <img src="<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
        <p><b>Vendor:</b> <?php echo htmlspecialchars($p['vendor_name']); ?></p>
        <p><b>₦<?php echo number_format($p['price']); ?></b></p>

        <a href="#" class="btn-add-cart" data-id="<?php echo $p['id']; ?>">
            Add to Cart
        </a>
    </div>

<?php } 
} else {
    echo "<p style='text-align:center; font-size:18px; width:100%; padding:40px;'>
            ❌ No products found
          </p>";
}
?>
</div>
</div>

<!-- Toast -->
<div id="toast" 
style="display:none; position:fixed; bottom:20px; right:20px; 
background:#0B4D3A; color:white; padding:12px 20px; 
border-radius:5px; box-shadow:0 2px 6px rgba(0,0,0,0.3); z-index:1000;">
    Product added to cart
</div>

<script>
document.querySelectorAll('.btn-add-cart').forEach(button => {
    button.addEventListener('click', function(e){
        e.preventDefault();
        const productId = this.getAttribute('data-id');

        fetch('add_to_cart_ajax.php?id=' + productId)
        .then(response => response.json())
        .then(data => {
            const toast = document.getElementById('toast');
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 2000);

            const cartSpan = document.querySelector('.cart-icon span');
            cartSpan.textContent = data.cart_count;
        })
        .catch(err => console.error(err));
    });
});
</script>
