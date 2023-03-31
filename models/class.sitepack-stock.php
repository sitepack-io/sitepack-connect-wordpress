<?php

class SitePackStock implements \JsonSerializable
{
    private bool $hasStock = false;
    private int $stockQuantity = 0;
    private int $stockQuantitySupplier = 0;
    private int $stockQuantityReserved = 0;
    private bool $allowBackorder = false;
    private array $stockLocations = [];
    private ?\DateTimeImmutable $deliveryDate;
    private ?string $errorReason = null;

    /**
     * @param bool $hasStock
     * @param int $stockQuantity
     * @param int $stockQuantitySupplier
     * @param int $stockQuantityReserved
     * @param bool $allowBackorder
     * @param array $stockLocations
     * @param DateTimeImmutable|null $deliveryDate
     * @param string|null $errorReason
     */
    private function __construct(
        bool $hasStock,
        int $stockQuantity,
        int $stockQuantitySupplier,
        int $stockQuantityReserved,
        bool $allowBackorder,
        array $stockLocations,
        ?DateTimeImmutable $deliveryDate,
        ?string $errorReason
    ) {
        $this->hasStock = $hasStock;
        $this->stockQuantity = $stockQuantity;
        $this->stockQuantitySupplier = $stockQuantitySupplier;
        $this->stockQuantityReserved = $stockQuantityReserved;
        $this->allowBackorder = $allowBackorder;
        $this->stockLocations = $stockLocations;
        $this->deliveryDate = $deliveryDate;
        $this->errorReason = $errorReason;
    }

    /**
     * Create a new Stock object from the SitePack Connect API endpoint
     *
     * @param array $apiData
     * @return SitePackStock
     * @throws Exception
     */
    public static function fromSitePackConnectData(array $apiData): SitePackStock
    {
        $locations = [];

        return new SitePackStock(
            (bool)$apiData['inStock'],
            (int)$apiData['quantityAvailable'],
            (int)$apiData['quantitySupplier'],
            0, // TODO: implement in SitePack Connect API
            (bool)$apiData['allowBackorder'],
            $locations,
            (!empty($apiData['deliveryDate'])) ? new DateTimeImmutable($apiData['deliveryDate']) : null,
            $apiData['errorReason']
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'hasStock' => $this->hasStock,
            'stockQuantity' => $this->stockQuantity,
            'stockQuantitySupplier' => $this->stockQuantitySupplier,
            'stockQuantityReserved' => $this->stockQuantityReserved,
            'allowBackOrder' => $this->allowBackorder,
            'stockLocations' => $this->stockLocations,
            'deliveryDate' => $this->deliveryDate,
            'errorReason' => $this->errorReason,
        ];
    }
}