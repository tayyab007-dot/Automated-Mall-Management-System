<?php
include 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity_sold'];

    $price_query = $conn->query("SELECT price FROM products WHERE product_id = '$product_id'");
    if ($price_query->num_rows > 0) {
        $unit_price = $price_query->fetch_assoc()['price'];
        $total_amount = $unit_price * $quantity_sold;

        $insert_sale = "INSERT INTO sales (customer_id, total_amount) VALUES ('$customer_id', '$total_amount')";
        if ($conn->query($insert_sale) === TRUE) {
            $sale_id = $conn->insert_id;
            $insert_item = "INSERT INTO sale_items (sale_id, product_id, quantity_sold, unit_price) 
                            VALUES ('$sale_id', '$product_id', '$quantity_sold', '$unit_price')";
            
            if ($conn->query($insert_item) === TRUE) {
                $message = "<div class='alert-banner success-banner'>Transaction Certified! Total Amount Handled: \$$total_amount. Automated shelf stock reduction executed via database trigger layer.</div>";
            }
        } else {
            $message = "<div class='alert-banner error-banner'>Database Logging Fault: " . $conn->error . "</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Terminal</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
        body { background-color: #f1f5f9; color: #1e293b; padding: 0; font-size: 15px; }
        .app-brand-bar { background: #0f172a; color: #ffffff; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #10b981; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .logo-area { display: flex; align-items: center; gap: 12px; }
        .logo-icon { background: #10b981; color: #0f172a; font-weight: 800; padding: 6px 12px; border-radius: 6px; font-size: 18px; }
        .logo-text h1 { font-size: 20px; font-weight: 700; }
        .logo-text p { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; }
        .main-container { max-width: 1300px; margin: 40px auto; padding: 0 40px; }
        .navigation-hub { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 35px; background: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .navigation-hub a { text-decoration: none; padding: 10px 20px; color: #475569; border-radius: 6px; font-size: 14px; font-weight: 600; transition: all 0.2s ease; }
        .navigation-hub a:hover { background: #f8fafc; color: #0f172a; }
        .navigation-hub a.active-tab { background: #10b981; color: #0f172a; box-shadow: 0 4px 6px rgba(16,185,129,0.2); }
        
        .form-content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 35px; max-width: 700px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .section-headline { font-size: 18px; color: #0f172a; font-weight: 700; margin-bottom: 6px; }
        .section-subtitle { font-size: 13px; color: #64748b; margin-bottom: 30px; }
        
        .form-group-row { margin-bottom: 24px; }
        .form-group-row label { display: block; font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
        .form-group-row input, .form-group-row select { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; color: #0f172a; background: #ffffff; transition: all 0.2s; }
        .form-group-row input:focus, .form-group-row select:focus { outline: none; border-color: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
        
        .action-checkout-btn { background: #10b981; color: #0f172a; padding: 14px 28px; border: none; border-radius: 6px; font-weight: 700; font-size: 15px; cursor: pointer; width: 100%; transition: background 0.2s; margin-top: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .action-checkout-btn:hover { background: #059669; color: #ffffff; }
        
        .alert-banner { padding: 16px; margin-bottom: 25px; border-radius: 6px; font-size: 14px; font-weight: 600; }
        .success-banner { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .error-banner { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <div class="app-brand-bar">
        <div class="logo-area">
            <div class="logo-icon">M</div>
            <div class="logo-text">
                <h1>MALL MANAGEMENT SYSTEM</h1>
                <p>Real-Estate Operations & Infrastructure Control</p>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="navigation-hub">
            <a href="index.php">System Dashboard</a>
            <a href="rent_shop.php">Lease Agreement Console</a>
            <a href="checkout.php" class="active-tab">POS Checkout Terminal</a>
            <a href="sales_history.php">Financial Sales Ledger</a>
            <a href="expiring_leases.php">Contract Expiration Alerts</a>
        </div>

        <div class="form-content-card">
            <div class="section-headline">Process Retail Point-of-Sale Checkout Invoice</div>
            <div class="section-subtitle">Records dynamic merchant customer transactions, calculating structural invoice valuations and logging operational entries.</div>
            
            <?php echo $message; ?>
            
            <form action="checkout.php" method="POST">
                <div class="form-group-row">
                    <label for="customer_id">Identify Loyalty Customer Profile Account:</label>
                    <select name="customer_id" id="customer_id" required>
                        <?php
                        $customers = $conn->query("SELECT customer_id, first_name, last_name FROM customers");
                        while($cust = $customers->fetch_assoc()) {
                            echo "<option value='" . $cust['customer_id'] . "'>" . $cust['first_name'] . " " . $cust['last_name'] . " (Loyalty Token Identifier)</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group-row">
                    <label for="product_id">Scan Shelved Merchandise Inventory Item:</label>
                    <select name="product_id" id="product_id" required>
                        <option value="">-- Scan Target Commercial SKU Product --</option>
                        <?php
                        $products = $conn->query("SELECT p.product_id, p.product_name, p.price, s.shop_name FROM products p JOIN shops s ON p.shop_id = s.shop_id");
                        while($prod = $products->fetch_assoc()) {
                            echo "<option value='" . $prod['product_id'] . "'>" . $prod['shop_name'] . " &raquo; " . $prod['product_name'] . " (\$" . $prod['price'] . ")</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group-row">
                    <label for="quantity_sold">Transaction Units Volume/Quantity:</label>
                    <input type="number" min="1" name="quantity_sold" id="quantity_sold" value="1" required>
                </div>
                <button type="submit" class="action-checkout-btn">Authorize Sales Log & Transmit Bill</button>
            </form>
        </div>
    </div>
</body>
</html>