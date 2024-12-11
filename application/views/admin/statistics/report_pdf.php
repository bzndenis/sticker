<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Statistik</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #333;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .summary-box {
            float: left;
            width: 23%;
            margin: 1%;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #ddd;
            text-align: center;
        }
        .summary-box h3 {
            margin: 0;
            font-size: 20px;
        }
        .summary-box p {
            margin: 5px 0;
            color: #666;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Statistik Aplikasi Sticker Trading</h1>
        <p>Periode: <?= date('d M Y', strtotime($period['start'])) ?> - <?= date('d M Y', strtotime($period['end'])) ?></p>
    </div>

    <!-- Ringkasan -->
    <div class="section clearfix">
        <div class="summary-box">
            <h3><?= $trade_stats['total_trades'] ?></h3>
            <p>Total Pertukaran</p>
        </div>
        <div class="summary-box">
            <h3><?= $trade_stats['success_trades'] ?></h3>
            <p>Pertukaran Berhasil</p>
        </div>
        <div class="summary-box">
            <h3><?= $user_stats['new_users'] ?></h3>
            <p>Pengguna Baru</p>
        </div>
        <div class="summary-box">
            <h3><?= $sticker_stats['new_stickers'] ?></h3>
            <p>Sticker Baru</p>
        </div>
    </div>

    <!-- Statistik Pertukaran -->
    <div class="section">
        <h2>Statistik Pertukaran</h2>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Jumlah</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($trade_stats['by_status'] as $status): ?>
                <tr>
                    <td><?= ucfirst($status['status']) ?></td>
                    <td><?= $status['count'] ?></td>
                    <td><?= number_format($status['percentage'], 1) ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Statistik Kategori -->
    <div class="section">
        <h2>Statistik Kategori</h2>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Total Sticker</th>
                    <th>Total Dimiliki</th>
                    <th>Total Pertukaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sticker_stats['by_category'] as $category): ?>
                <tr>
                    <td><?= $category['name'] ?></td>
                    <td><?= $category['total_stickers'] ?></td>
                    <td><?= $category['total_owned'] ?></td>
                    <td><?= $category['total_trades'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Top Pengguna -->
    <div class="section">
        <h2>Top 5 Pengguna Aktif</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Total Sticker</th>
                    <th>Total Pertukaran</th>
                    <th>Pertukaran Berhasil</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($user_stats['top_users'] as $user): ?>
                <tr>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['total_stickers'] ?></td>
                    <td><?= $user['total_trades'] ?></td>
                    <td><?= $user['success_trades'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Sticker Terpopuler -->
    <div class="section">
        <h2>Top 5 Sticker Terpopuler</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama Sticker</th>
                    <th>Kategori</th>
                    <th>Total Dimiliki</th>
                    <th>Total Pertukaran</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($sticker_stats['popular_stickers'] as $sticker): ?>
                <tr>
                    <td><?= $sticker['name'] ?></td>
                    <td><?= $sticker['category_name'] ?></td>
                    <td><?= $sticker['total_owned'] ?></td>
                    <td><?= $sticker['total_trades'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat otomatis pada <?= date('d M Y H:i:s') ?></p>
    </div>
</body>
</html> 