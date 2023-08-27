<?php

if (!headers_sent()) {
    header('Content-Type: application/json');
}

// 匯率資料
$rates = [
    "TWD" => [
        "TWD" => 1,
        "JPY" => 3.669,
        "USD" => 0.03281
    ],
    "JPY" => [
        "TWD" => 0.26956,
        "JPY" => 1,
        "USD" => 0.00885
    ],
    "USD" => [
        "TWD" => 30.444,
        "JPY" => 111.801,
        "USD" => 1
    ]
];

// 確認有沒有帶到參數
if (!isset($_GET['source'], $_GET['target'], $_GET['amount'])) {
    echo json_encode(['msg' => 'missing parameters']);
    return;
}

$source = $_GET['source'];
$target = $_GET['target'];
$amount = substr($_GET['amount'], 1); // 去除$符號
$amount = str_replace(',', '', $amount); // 去除千分位

// 確認參數是否合法
if (!isset($rates[$source]) || !isset($rates[$source][$target]) || !is_numeric($amount)) {
    echo json_encode(['msg' => 'invalid parameters']);
    return;
}

// 轉換＆格式化
$convertedAmount = $amount * $rates[$source][$target];
$convertedAmount = round($convertedAmount, 2);// 四捨五入到小數點後兩位
$formattedAmount = '$' . number_format($convertedAmount, 2);

$response = [
    'msg' => 'success',
    'amount' => $formattedAmount
];

echo json_encode($response);

?>
