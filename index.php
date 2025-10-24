<?php
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kiiuutyy Skincare</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Kiiuutyy Skincare</h1>
        <div class="cart-icon">
            <a href="cart.php">🛒 Keranjang <span id="cart-count"></span></a>
        </div>
    </header>

    <!-- Produk -->
    <div class="product-container">
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <div class="product-card">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['brand']; ?> | <?php echo $row['category']; ?></p>
                <p>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></p>

                <!-- Qty -->
                <div class="qty-container">
                    <button class="qty-btn" onclick="updateCart(<?php echo $row['id']; ?>, 'decrease')">-</button>
                    <input type="text" id="qty_<?php echo $row['id']; ?>" value="0" size="1" readonly>
                    <button class="qty-btn" onclick="updateCart(<?php echo $row['id']; ?>, 'increase')">+</button>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Script -->
    <script>
    function updateCart(id, action) {
        let qtyInput = document.getElementById("qty_" + id);
        let qty = parseInt(qtyInput.value);

        if (action === "increase") {
            qty += 1;
        } else if (action === "decrease" && qty > 0) {
            qty -= 1;
        }

        qtyInput.value = qty;

        fetch("cart.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "id=" + id + "&qty=" + qty
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById("cart-count").innerText = data.totalItems;
        });
    }
    </script>
</body>
</html>
