<?php

class Basket
{
    public $products;
    public $total;
    public $promotionalReduction;
    public $promotionalTotal;

    /** 
     * Creating a new empty basket
     */
    public function __construct() 
    {
        $this->products = array();
        $this->total = 0;
        $this->promotionalReduction = 0;
        $this->promotionalTotal = 0;
    }

    /**
     * adding a new product
     * in a real application I would ensure that the class was namespaced
     * 
     * @param string $sku
     * @param int $quantity
     */

    public function addProduct($sku, $quantity) 
    {
        include_once('../Classes/Product.php');
        $product = new Product($sku, $quantity);
        array_push($this->products, $product);
        $this->total += $product->total;

    }

    /**
     * applying any relevant discounts
     */
    public function applyDiscounts() 
    {
        /** if this was not done on a short time frame for a live project, i would read information from a table
         *  and create a class to hold the promotions that can be refered to
         */

        foreach($this->products as $product) {
            switch($product->sku) {
                case "A": {
                    if($product->quantity > 0) {
                        $this->promotionalTotal += $this->multibuyPromotions($product, array(3 => 130));
                    }
                    break;
                }
                case "B": {
                    if($product->quantity > 0) {
                        $this->promotionalTotal += $this->multibuyPromotions($product, array(2 => 45));
                    }
                    break;
                }
                case "C": {
                    if($product->quantity > 0) {
                        $this->promotionalTotal += $this->multibuyPromotions($product, array(2 => 38, 3 => 50));
                    }
                    break; 
                }
                case "D": {
                    // this is not the most elegant solution, but in a solo timed situation, the most elegant is not always found
                    if($product->quantity > 0) {
                        foreach($this->products as $subProduct) {
                            if($subProduct->sku === "A") {
                                $this->promotionalTotal += $this->bundlePromotion($product, $subProduct, 5);
                            }
                        }
                    }
                    break;
                }
                default: {
                    $this->promotionalTotal += $product->total;
                    break;
                }
            }
        }
    }

    /**
     * applying a multibuy promotion (x for £y)
     * the function will loop through any possible discounts and apply them in order
     * @param Product $product
     * @param array $discounts
     */
    private function multibuyPromotions($product, $discounts) 
    {
        $promotionalPrice = 0;
        $leftQuantity = $product->quantity;
        krsort($discounts);

        foreach($discounts as $quantity => $value) {

            $inDeal = floor($leftQuantity/$quantity);
            if($inDeal > 0) {
                $promotionalPrice += ($inDeal * $value);
                $leftQuantity = $leftQuantity % $quantity;
            }
            
        }
        $promotionalPrice += ($leftQuantity * $product->unitPrice);
        $leftQuantity = 0;

        return $promotionalPrice;
    }

    /**
     * applying a bundle promotion (x costs £y with every z purchased)
     * @param Product $productA
     * @param Product $productB
     * @param float $bundlePrice
     */
    private function bundlePromotion($productA, $productB, $bundlePrice) {
        $quantityA = $productA->quantity;
        $quantityB = $productB->quantity;
        $unitPriceA = $productA->unitPrice;
        
        if($quantityB > 0) {
            if($quantityB >= $quantityA) {
                return ($quantityA * $bundlePrice);
            } else {
                return ($quantityB * $bundlePrice) + (($quantityA - $quantityB) * $unitPriceA);
            }
        } else {
            return ($quantityA * $unitPriceA);
        }
    }

    /**
     * works out how much the user has saved
     */
    public function workOutReduction() {
        $this->promotionalReduction = $this->total - $this->promotionalTotal;
    }

}