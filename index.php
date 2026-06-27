<?php
include 'db.php';

$floor_count = $conn->query("SELECT COUNT(*) AS total FROM floors")->fetch_assoc()['total'];
$shop_count = $conn->query("SELECT COUNT(*) AS total FROM shops")->fetch_assoc()['total'];
$total_rent = $conn->query("SELECT SUM(monthly_rent) AS total FROM leases")->fetch_assoc()['total'];
$total_rent = $total_rent ? $total_rent : 0.00; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mall Management System</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
        body { background-color: #f1f5f9; color: #1e293b; padding: 0; font-size: 15px; }
        
        /* Top Professional Corporate Branding Header */
        .app-brand-bar { background: #0f172a; color: #ffffff; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid #10b981; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .logo-area { display: flex; align-items: center; gap: 12px; }
        .logo-icon { background: #10b981; color: #0f172a; font-weight: 800; padding: 6px 12px; border-radius: 6px; font-size: 18px; letter-spacing: 1px; }
        .logo-text h1 { font-size: 20px; font-weight: 700; letter-spacing: 0.5px; }
        .logo-text p { font-size: 11px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }
        
        .main-container { max-width: 1300px; margin: 40px auto; padding: 0 40px; }
        
        /* Navigation Hub Layout */
        .navigation-hub { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 35px; background: #ffffff; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .navigation-hub a { text-decoration: none; padding: 10px 20px; color: #475569; border-radius: 6px; font-size: 14px; font-weight: 600; transition: all 0.2s ease; }
        .navigation-hub a:hover { background: #f8fafc; color: #0f172a; }
        .navigation-hub a.active-tab { background: #0f172a; color: #ffffff; box-shadow: 0 4px 6px rgba(15,23,42,0.15); }

        /* Modern Dashboard Metric Grid Cards */
        .metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px; }
        .metric-card { background: #ffffff; padding: 26px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01); display: flex; flex-direction: column; justify-content: space-between; position: relative; overflow: hidden; }
        .metric-card::before { content: ''; position: absolute; top: 0; left: 0; width: 5px; height: 100%; background: #64748b; }
        .metric-card.accent-revenue::before { background: #10b981; }
        .metric-card h3 { font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; margin-bottom: 10px; font-weight: 700; }
        .metric-card p { font-size: 32px; font-weight: 700; color: #0f172a; }
        
        /* Directory Data Grid Card Section */
        .content-block-card { background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .section-headline { font-size: 18px; color: #0f172a; font-weight: 700; margin-bottom: 6px; }
        .section-subtitle { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 14px 18px; background: #f8fafc; color: #64748b; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; }
        td { padding: 16px 18px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f8fafc; }
        
        /* Modernized Decorative Status Badges */
        .status-pill { display: inline-flex; align-items: center; padding: 4px 12px; font-size: 12px; font-weight: 700; border-radius: 50px; letter-spacing: 0.3px; }
        .status-pill-occupied { background: #dcfce7; color: #16a34a; }
        .status-pill-vacant { background: #f1f5f9; color: #64748b; }
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
            <a href="index.php" class="active-tab">System Dashboard</a>
            <a href="rent_shop.php">Lease Agreement Console</a>
            <a href="checkout.php">POS Checkout Terminal</a>
            <a href="sales_history.php">Financial Sales Ledger</a>
            <a href="expiring_leases.php">Contract Expiration Alerts</a>
        </div>

        <div class="metrics-grid">
            <div class="metric-card">
                <h3>Total Configured Floors</h3>
                <p><?php echo $floor_count; ?></p>
            </div>
            <div class="metric-card">
                <h3>Total Retail Shop Spaces</h3>
                <p><?php echo $shop_count; ?></p>
            </div>
            <div class="metric-card accent-revenue">
                <h3>Total Monthly Rental Income</h3>
                <p>$<?php echo number_format($total_rent, 2); ?></p>
            </div>
        </div>

        <div class="content-block-card">
            <div class="section-headline">Real Estate Shop Allocation Directory</div>
            <div class="section-subtitle">Real-time infrastructure system overview tracking current tenants, spatial categorization, and lease status metrics.</div>
            
            <table>
                <thead>
                    <tr>
                        <th>Shop Number</th>
                        <th>Occupying Tenant Identity</th>
                        <th>Business Category</th>
                        <th>Operational Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shops_list = $conn->query("SELECT shop_number, shop_name, category, status FROM shops");
                    if ($shops_list->num_rows > 0) {
                        while($shop = $shops_list->fetch_assoc()) {
                            $pill_class = ($shop['status'] == 'Occupied') ? 'status-pill-occupied' : 'status-pill-vacant';
                            echo "<tr>";
                            echo "<td><strong style='color:#0f172a; font-weight:700;'>" . $shop['shop_number'] . "</strong></td>";
                            echo "<td>" . ($shop['status'] == 'Occupied' ? $shop['shop_name'] : '<span style="color:#94a3b8; font-style:italic;">No Active Tenant</span>') . "</td>";
                            echo "<td>" . $shop['category'] . "</td>";
                            echo "<td><span class='status-pill $pill_class'>" . $shop['status'] . "</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No retail fields mapped within system storage.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>