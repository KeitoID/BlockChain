<?php

class Block
{
    private const HASH_ALGO = 'sha256';

    public string $hash;
    private readonly string $originalData;

    public function __construct(
        private readonly int $index,
        private readonly int $timeStamp,
        private readonly array $data,
        private readonly string $preaviousHash,
    ) {
        $this->originalData = $this->convertToOriginalData(
            $this->index,
            $this->timeStamp,
            $this->data,
            $this->preaviousHash
        );

        $this->hash = $this->calculateHash();
    }
    
    public function calculateHash(): string 
    {
        return hash(self::HASH_ALGO, $this->originalData);
    }

    private function convertToOriginalData(
        int $index, 
        int $timeStamp, 
        array $data, 
        string $preaviousHash = '',
    ): string {
        $jsonEncodedData = json_encode($data);

        return (string)$index . (string)$timeStamp . $jsonEncodedData . $preaviousHash;
    }

    public function getPreaviousHash(): string
    {
        return $this->preaviousHash;
    }
}