<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Alerts</title>
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
        
        .deadline-badge { display: inline-flex; align-items: center; padding: 6px 12px; font-size: 12px; font-weight: 700; border-radius: 4px; background: #ffe4e6; color: #e11d48; border: 1px solid #fecdd3; }
        .empty-state-banner { padding: 20px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 8px; text-align: center; color: #64748b; font-weight: 600; }
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
            <a href="sales_history.php">Financial Sales Ledger</a>
            <a href="expiring_leases.php" class="active-tab">Contract Expiration Alerts</a>
        </div>

        <div class="content-block-card">
            <div class="section-headline">Administrative Timeline Deadline Exceptions</div>
            <div class="section-subtitle">Isolation output query targeting the SQL Database View 'v_expiring_leases' to intercept contract expirations occurring within the next 30 days.</div>
            
            <?php
            $view_query = "SELECT lease_id, shop_number, shop_name, tenant_name, end_date, days_remaining FROM v_expiring_leases ORDER BY days_remaining ASC";
            $view_list = $conn->query($view_query);
            
            if ($view_list && $view_list->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr><th>Lease Code ID</th><th>Physical Unit Allocation</th><th>Contracted Tenant</th><th>Expiration Target</th><th>System Criticality State</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                while($lease = $view_list->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td><strong>#CON-" . $lease['lease_id'] . "</strong></td>";
                    echo "<td>" . $lease['shop_number'] . " (" . $lease['shop_name'] . ")</td>";
                    echo "<td>" . $lease['tenant_name'] . "</td>";
                    echo "<td style='font-weight:600; color:#475569;'>" . $lease['end_date'] . "</td>";
                    echo "<td><span class='deadline-badge'>" . $lease['days_remaining'] . " Days Until Expiration</span></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<div class='empty-state-banner'>Operational Standing Optimal: Zero commercial lease agreements intersecting the critical 30-day expiration window.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>