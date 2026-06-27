<?php
include 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shop_id = $_POST['shop_id'];
    $tenant_name = $_POST['tenant_name'];
    $monthly_rent = $_POST['monthly_rent'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $insert_lease = "INSERT INTO leases (shop_id, tenant_name, monthly_rent, start_date, end_date) 
                     VALUES ('$shop_id', '$tenant_name', '$monthly_rent', '$start_date', '$end_date')";

    if ($conn->query($insert_lease) === TRUE) {
        $update_shop = "UPDATE shops SET status = 'Occupied', shop_name = '$tenant_name' WHERE shop_id = '$shop_id'";
        $conn->query($update_shop);
        $message = "<div class='alert-banner success-banner'>Contract Processed Successfully! Shop spatial status updated to occupied.</div>";
    } else {
        $message = "<div class='alert-banner error-banner'>System Execution Refused: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lease Console</title>
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
        .navigation-hub a.active-tab { background: #0f172a; color: #ffffff; box-shadow: 0 4px 6px rgba(15,23,42,0.15); }
        
        /* Modern Structured Input Card Form Styling Layout */
        .form-content-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 35px; max-width: 700px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .section-headline { font-size: 18px; color: #0f172a; font-weight: 700; margin-bottom: 6px; }
        .section-subtitle { font-size: 13px; color: #64748b; margin-bottom: 30px; }
        
        .form-group-row { margin-bottom: 24px; }
        .form-group-row label { display: block; font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 8px; }
        .form-group-row input, .form-group-row select { width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px; color: #0f172a; background: #ffffff; transition: all 0.2s; }
        .form-group-row input:focus, .form-group-row select:focus { outline: none; border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15,23,42,0.08); }
        
        .action-submit-btn { background: #0f172a; color: #ffffff; padding: 14px 28px; border: none; border-radius: 6px; font-weight: 600; font-size: 15px; cursor: pointer; width: 100%; transition: background 0.2s; margin-top: 10px; }
        .action-submit-btn:hover { background: #1e293b; }
        
        .alert-banner { padding: 16px; margin-bottom: 25px; border-radius: 6px; font-size: 14px; font-weight: 600; }
        .success-banner { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
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
            <a href="rent_shop.php" class="active-tab">Lease Agreement Console</a>
            <a href="checkout.php">POS Checkout Terminal</a>
            <a href="sales_history.php">Financial Sales Ledger</a>
            <a href="expiring_leases.php">Contract Expiration Alerts</a>
        </div>

        <div class="form-content-card">
            <div class="section-headline">Authorize New Corporate Tenant Lease Contract</div>
            <div class="section-subtitle">Executes structural business contract records mapping external tenant profiles to unallocated physical shop locations.</div>
            
            <?php echo $message; ?>
            
            <form action="rent_shop.php" method="POST">
                <div class="form-group-row">
                    <label for="shop_id">Select Unallocated Location Unit:</label>
                    <select name="shop_id" id="shop_id" required>
                        <option value="">-- Choose Vacant Shop Identification --</option>
                        <?php
                        $vacant_shops = $conn->query("SELECT shop_id, shop_number FROM shops WHERE status = 'Vacant'");
                        while($shop = $vacant_shops->fetch_assoc()) {
                            echo "<option value='" . $shop['shop_id'] . "'>" . $shop['shop_number'] . " (Vacant Unit)</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group-row">
                    <label for="tenant_name">Tenant Corporate Identity Name:</label>
                    <input type="text" name="tenant_name" id="tenant_name" placeholder="e.g. Adidas International" required>
                </div>
                <div class="form-group-row">
                    <label for="monthly_rent">Agreed Monthly Rental Fee Schedule ($):</label>
                    <input type="number" step="0.01" name="monthly_rent" id="monthly_rent" placeholder="0.00" required>
                </div>
                <div class="form-group-row">
                    <label for="start_date">Contract Execution Activation Date:</label>
                    <input type="date" name="start_date" id="start_date" required>
                </div>
                <div class="form-group-row">
                    <label for="end_date">Contractual Lease Termination Date:</label>
                    <input type="date" name="end_date" id="end_date" required>
                </div>
                <button type="submit" class="action-submit-btn">Bind Lease & Allocate Asset</button>
            </form>
        </div>
    </div>
</body>
</html>