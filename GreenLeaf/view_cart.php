<?php
include 'includes/db_config.php';

$sql = "SELECT Cart.id AS cart_id, ProductCards.title, ProductCards.image_path, ProductCards.price, Cart.option_values, Cart.quantity
        FROM Cart
        JOIN ProductCards ON Cart.product_id = ProductCards.id
        ORDER BY Cart.added_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Your Cart | GreenLeaf</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f6f6f6;
      padding: 2rem;
    }

    h2 {
      text-align: center;
      color: #2a3d34;
    }

    table {
      width: 90%;
      margin: 2rem auto;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #e6f0eb;
    }

    img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
    }

    .remove-btn {
      background-color: #ef4444;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      cursor: pointer;
    }

    .total {
      font-weight: bold;
      text-align: right;
      padding: 1rem 2rem;
    }

    a {
      display: block;
      text-align: center;
      margin-top: 1.5rem;
      color: #1a3d2f;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<h2>🛒 Your Cart</h2>

<?php
$total = 0;

if ($result->num_rows > 0): ?>
<table>
  <tr>
    <th>Product</th>
    <th>Options</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Total</th>
    <th>Remove</th>
  </tr>

  <?php while ($row = $result->fetch_assoc()): 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
  ?>
  <tr>
    <td>
      <img src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['title']) ?>">
      <br><?= htmlspecialchars($row['title']) ?>
    </td>
    <td><?= nl2br(htmlspecialchars($row['option_values'])) ?></td>
    <td>$<?= number_format($row['price'], 2) ?></td>
    <td><?= intval($row['quantity']) ?></td>
    <td>$<?= number_format($subtotal, 2) ?></td>
    <td>
      <form method="POST" action="remove_from_cart.php">
        <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
        <button type="submit" class="remove-btn">Remove</button>
      </form>
    </td>
  </tr>
  <?php endwhile; ?>
</table>

<div class="total">Grand Total: $<?= number_format($total, 2) ?></div>
<?php else: ?>
  <p style="text-align:center;">Your cart is empty.</p>
<?php endif; ?>

<a href="productcards.php">← Back to Products</a>

</body>
</html>

<?php $conn->close(); ?>
