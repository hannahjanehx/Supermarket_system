<?php

class Product 
{
    public $sku;
    public $unitPrice;
    public $name;
    public $quantity;
    public $total;

    /**
     * @param string $sku
     * @param int $quantity
     */
    public function __construct($sku, $quantity) 
    {
        // in a live project this would be connected to a database rather than a switch, done like this due to short time frame

        switch($sku) {
            case "iASku": {
                $this->sku = "A";
                $this->unitPrice = 50;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = $this->getTotal();
                break;
            }
            case "iBSku": {
                $this->sku = "B";
                $this->unitPrice = 30;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = $this->getTotal();
                break;
            }
            case "iCSku": {
                $this->sku = "C";
                $this->unitPrice = 20;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = $this->getTotal();
                break;
            }
            case "iDSku": {
                $this->sku = "D";
                $this->unitPrice = 15;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = $this->getTotal();
                break;
            }
            case "iESku": {
                $this->sku = "E";
                $this->unitPrice = 5;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = $this->getTotal();
                break;
            }
            default: {
                $this->sku = "";
                $this->unitPrice = 0;
                $this->quantity = $quantity;
                $this->name = $sku;
                $this->total = 0;
            }
        }

        
    }

    /**
     * this is the total before any promotions are applied
     * used to work out the savings
     */
    private function getTotal() {
        return $this->quantity * $this->unitPrice;
    }
}