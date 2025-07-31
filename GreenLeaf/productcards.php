<?php
include 'includes/db_config.php';

ntents("templates/product_template.html");


$sql = "SELECT * FROM ProductCards ORDER BY id DESC";
$result = $conn->query($sql);

$product_cards = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row['id'];
  $option_query = "SELECT * FROM ProductOptions WHERE product_id = $product_id";
  $option_result = $conn->query($option_query);

  $option_html = "";
  if ($option_result->num_rows > 0) {
    $option_html .= '<div class="product-options">';
    while ($opt = $option_result->fetch_assoc()) {
      $values = explode(',', $opt['option_values']);
      $option_html .= '<label>' . htmlspecialchars($opt['option_name']) . ': ';
      $option_html .= '<select>';
      foreach ($values as $value) {
        $option_html .= '<option>' . htmlspecialchars(trim($value)) . '</option>';
      }
      $option_html .= '</select></label>';
    }
    $option_html .= '</div>';
  }
  $product_cards .= '
  <div class="product-card">
      <div class="product-image">
          <img src="' . htmlspecialchars($row['image_path']) . '" alt="' . htmlspecialchars($row['title']) . '">
          <div class="badge">' . intval($row['days_left']) . ' days left</div>
      </div>
      <div class="product-content">
          <h2 class="product-title">' . htmlspecialchars($row['title']) . '</h2>
          <p class="product-desc">' . htmlspecialchars($row['description']) . '</p>
          ' . $option_html . '
          <div class="rating">
              <div class="stars">★ ★ ★ ★ ★</div>
              <div class="review-count">' . intval($row['rating']) . '</div>
          </div>
          <div class="price-delete">
              <div class="price">$' . number_format($row['price'], 2) . '</div>
              <div class="card-actions">
                  <button class="wishlist-btn" title="Add to Wishlist"><i class="fa fa-heart"></i></button>
                  <button class="cart-btn" title="Add to Cart"><i class="fa fa-cart-plus"></i></button>
              </div>
          </div>
      </div>
  </div>';
  
    }
} else {
    $product_cards = "<p style='text-align:center;'>No products found.</p>";
}

$conn->close();


$output = str_replace("{{PRODUCT_CARDS}}", $product_cards, $template);


echo $output;
?>
