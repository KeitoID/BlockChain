<?php

require 'Block.php';

class BlockChain {
    /** @var Block[] $chain */
    private array $chain;

    public function __construct() {
        $this->chain = [$this->createGenesisBlock()];
    }

    // ブロックチェーンの最初のブロックであるジェネシスブロックを生成
    private function createGenesisBlock(): Block
    {
        return new Block(
            0,
            time(),
            ["data" => "Genesis Block"],
            "0"
        );
    }

    public function getChain(): array
    {
        return $this->chain;
    }

    // チェーンの末尾のブロックを返す
    public function getLatestBlock(): Block
    {
        return $this->chain[count($this->chain) - 1];
    }

    // チェーン末尾ににブロックを追加する
    public function addBlock(array $data): void
    {
        $previousBlock = $this->getLatestBlock();
        $this->chain[] = new Block(
            count($this->chain) + 1,
            time(),
            $data,
            $previousBlock->hash
        );
    }

    // ブロック同士の妥当性をチェック
    public function isChainValid(): bool
    {
        // ジェネシスブロック以降をチェック
        for ($i = 1; $i < count($this->chain); $i++) {
            $currentBlock = $this->chain[$i];
            $previousBlock = $this->chain[$i - 1];
            
            // 現在保持しているハッシュ値と再計算した値が等しいかどうか
            if ($currentBlock->hash != $currentBlock->calculateHash()) {
                return false;
            }
            
            // ブロック同士のチェーンが正しいかのチェック
            if ($currentBlock->getPreaviousHash() != $previousBlock->hash) {
                return false;
            }
        }
        return true;
    }
}
