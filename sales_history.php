<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Audit History</title>
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
        
        .content-block-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .section-headline { font-size: 18px; color: #0f172a; font-weight: 700; margin-bottom: 6px; }
        .section-subtitle { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 14px 18px; background: #f8fafc; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; }
        td { padding: 16px 18px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f8fafc; }
        .money-cell { font-weight: 700; color: #0f172a; }
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
            <a href="checkout.php">POS Checkout Terminal</a>
            <a href="sales_history.php" class="active-tab">Financial Sales Ledger</a>
            <a href="expiring_leases.php">Contract Expiration Alerts</a>
        </div>

        <div class="content-block-card">
            <div class="section-headline">Financial Sales Transaction Audit History Log</div>
            <div class="section-subtitle">Historical master system logs tracking all commercial point-of-sale receipt bills across the entire tenant structure.</div>
            
            <table>
                <thead>
                    <tr>
                        <th>Invoice Receipt ID</th>
                        <th>Timestamp Logged</th>
                        <th>Buyer Account Profile</th>
                        <th>Gross Settlement Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sales_query = "SELECT s.sale_id, s.sale_date, s.total_amount, CONCAT(c.first_name, ' ', c.last_name) AS customer_name 
                                    FROM sales s 
                                    LEFT JOIN customers c ON s.customer_id = c.customer_id 
                                    ORDER BY s.sale_id DESC";
                    $sales_list = $conn->query($sales_query);
                    if ($sales_list->num_rows > 0) {
                        while($sale = $sales_list->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong style='color:#0f172a;'>#INV-" . str_pad($sale['sale_id'], 4, '0', STR_PAD_LEFT) . "</strong></td>";
                            echo "<td style='color:#64748b; font-size:13px;'>" . $sale['sale_date'] . "</td>";
                            echo "<td>" . ($sale['customer_name'] ? $sale['customer_name'] : '<span style="color:#94a3b8; font-style:italic;">Guest Customer</span>') . "</td>";
                            echo "<td class='money-cell'>$" . number_format($sale['total_amount'], 2) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No computational sales detected inside the infrastructure schema yet.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>