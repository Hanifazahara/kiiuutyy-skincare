<?php
session_start();
include 'db.php';

// Tambahkan produk ke cart
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        $product = mysqli_fetch_assoc($result);
        $_SESSION['cart'][$id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'qty' => 1,
            'image' => $product['image']
        ];
    }
}

// Hapus item
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <a href="index.php">← Lanjut Belanja</a>
    <div class="cart-container">
        <?php if (!empty($_SESSION['cart'])) { ?>
            <table border="1" cellpadding="10" cellspacing="0" align="center">
                <tr>
                    <th>Gambar</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
                <?php 
                $grandTotal = 0;
                foreach ($_SESSION['cart'] as $id => $item) {
                    $total = $item['price'] * $item['qty'];
                    $grandTotal += $total;
                ?>
                <tr>
                    <td><img src="images/<?php echo $item['image']; ?>" width="80"></td>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['qty']; ?></td>
                    <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                    <td><a href="cart.php?remove=<?php echo $id; ?>">Hapus</a></td>
                </tr>
                <?php } ?>
                <tr>
                    <td colspan="4"><b>Total Bayar</b></td>
                    <td colspan="2"><b>Rp <?php echo number_format($grandTotal, 0, ',', '.'); ?></b></td>
                </tr>
            </table>
        <?php } else { ?>
            <p>Keranjang kosong 😢</p>
        <?php } ?>
    </div>
</body>
</html>
