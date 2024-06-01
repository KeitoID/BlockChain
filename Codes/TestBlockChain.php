<?php

require 'BlockChain.php';

// ブロックチェーンの作成
$blockchain = new Blockchain();

// 新しいブロックを追加
$blockchain->addBlock(["amount" => 100]);
$blockchain->addBlock(["amount" => 50]);

// チェーンの検証
echo "Is blockchain valid? " . ($blockchain->isChainValid() ? "Yes" : "No") . PHP_EOL;

// ブロックチェーンの内容を表示
echo json_encode($blockchain->getChain(), JSON_PRETTY_PRINT) . PHP_EOL;

// 末尾のブロックのハッシュ値を置き換えてみる
$data = 'test data だよーーーん';
$blockchain->getLatestBlock()->hash = hash('sha256', $data);

// 再度検証
echo "Is blockchain valid? " . ($blockchain->isChainValid() ? "Yes" : "No") . PHP_EOL;