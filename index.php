<?php
// Funksiya hisoblash uchun
function calculateMonthlyResults($productPrice) {
    // Interest rates in percentage per month
    $interestRates = [
        12 => 31.2, // 12 oyda 31.2% foiz
        9 => 23.4,  // 9 oyda 23.4% foiz
        6 => 15.6,  // 6 oyda 15.6% foiz
        3 => 0      // 3 oyda 0% foiz
    ];

    // Hisoblash
    $results = [];
    foreach ($interestRates as $months => $rate) {
        $totalAmount = $productPrice * (1 + $rate / 100); // Umumiy summa
        $monthlyPayment = $totalAmount / $months; // Oylik to'lov
        $results[$months] = [
            'totalAmount' => round($totalAmount, 2), // Umumiy summa, 2 belgiga yaxinlashadi
            'monthlyPayment' => round($monthlyPayment, 2) // Oylik to'lov, 2 belgiga yaxinlashadi
        ];
    }

    return $results;
}

// Formani tekshirish va hisoblash
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Yangi narxni olish
    $newProductPrice = isset($_POST['productPrice']) ? floatval($_POST['productPrice']) : 1000000; // 1,000,000 so'm

    // Eski narxni o'chirish
    unset($productPrice);

    // Yangi narxni hisoblash
    $results = calculateMonthlyResults($newProductPrice);
} else {
    // Agar post so'rovi emas bo'lsa, standart narxni olish
    $productPrice = 1000000; // 1,000,000 so'm
    $results = calculateMonthlyResults($productPrice);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Results</title>
    <link rel="stylesheet" href="styles.css">





</head>
<body>
    <h1> <?= isset($newProductPrice) ? number_format($newProductPrice, ) : number_format($productPrice, 2) ?> so'mlik tavar uchun oylik natijalar</h1>
    
    <!-- Tavar narxi kiritish va hisoblash formasi -->
    <form method="post" action="">
        <label for="productPrice">Tavar narxi (so'm):</label>
        <input type="number" id="productPrice" name="productPrice" value="<?= isset($newProductPrice) ? $newProductPrice : $productPrice ?>" required>
        <button type="submit">Hisoblash</button>
    </form>

    <!-- Natijalarni jadval shaklida ko'rsatish -->
    <table>
        <tr>
            <th>Oylar</th>
            <th>Umumiy hisob</th>
            <th>Oylik to'lov</th>
        </tr>
        <?php foreach ($results as $months => $result): ?>
        <tr>
            <td><?= $months ?></td>
            <td><?= number_format($result['totalAmount'], 0) ?> so'm</td>
            <td><?= number_format($result['monthlyPayment'], 0) ?> so'm</td>
        </tr>
        <?php endforeach; ?>
    </table>
    <!-- Footer -->
    <footer>
        <p>&copy; <?= date('Y') ?> AKSO Business. All rights reserved.</p>
    </footer>
    
    <!-- Back to Top tugmasi -->
    <!-- <a href="#top">AKSO</a> -->
</body>
</html>
