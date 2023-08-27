<?php

// 引入 exchangeAPI.php
function getAPIResponse($source, $target, $amount) {
    $_GET['source'] = empty($source) ? NULL : $source;
    $_GET['target'] = empty($target) ? NULL : $target;
    $_GET['amount'] = empty($amount) ? NULL : $amount;

    ob_start();// 開始輸出緩衝
    include 'exchangeAPI.php';
    return json_decode(ob_get_clean(), true);
}

// 測試從 TWD 轉換到 JPY 的功能
function testTWDToJPY() {
    $response = getAPIResponse('TWD', 'JPY', '$6,666');
    $expectedAmount = '$24,457.55'; 
    assert($response['msg'] == 'success', 'Message does not match!');
    assert($response['amount'] == $expectedAmount, 'Converted amount does not match!');
    echo "Test for TWD to JPY passed!\n";
}

// 測試從 JPY 轉換到 USD 的功能
function testJPYToUSD() {
    $response = getAPIResponse('JPY', 'USD', '$7,777');
    $expectedAmount = '$68.83'; 
    assert($response['msg'] == 'success', 'Message does not match!');
    assert($response['amount'] == $expectedAmount, 'Converted amount does not match!');
    echo "Test for JPY to USD passed!\n";
}

// 測試缺少 'amount' 參數的情況
function testMissingAmount() {
    $response = getAPIResponse('USD', 'JPY', '');
    assert($response['msg'] == 'missing parameters', 'Message does not match!');
    echo "Test for missing amount parameter passed!\n";
}

// 測試缺少 'source' 參數的情況
function testMissingSource() {
    $response = getAPIResponse('', 'JPY', '$8,787');
    assert($response['msg'] == 'missing parameters', 'Message does not match!');
    echo "Test for missing source parameter passed!\n";
}

// 測試缺少 'target' 參數的情況
function testMissingTarget() {
    $response = getAPIResponse('USD', '', '$8,787');
    assert($response['msg'] == 'missing parameters', 'Message does not match!');
    echo "Test for missing target parameter passed!\n";
}

// 測試使用不合法的 'source' 參數值
function testInvalidSource() {
    $response = getAPIResponse('INVALID', 'JPY', '$8,787');
    assert($response['msg'] == 'invalid parameters', 'Message does not match!');
    echo "Test for invalid source parameter value passed!\n";
}

// 測試使用不合法的 'target' 參數值
function testInvalidTarget() {
    $response = getAPIResponse('USD', 'INVALID', '$8,787');
    assert($response['msg'] == 'invalid parameters', 'Message does not match!');
    echo "Test for invalid target parameter value passed!\n";
}


// 執行測試
testTWDToJPY();
testJPYToUSD();
testMissingAmount();
testMissingSource();
testMissingTarget();
testInvalidSource();
testInvalidTarget();

?>
