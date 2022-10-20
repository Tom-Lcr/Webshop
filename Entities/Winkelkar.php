<?php

declare(strict_types=1);



namespace Entities;



class Winkelkar
{
    private int $productId;
    private int $aantal;

    public function __construct(int $productId, int $aantal)
    {
     $this->productId = $productId;
     $this->aantal = $aantal;
    }
 
    public function getProductId() : int{
     return $this->productId;
    }

    public function getAantal() : int{
        return $this->aantal;
    }

    public function setAantal(int $aantal){
        $this->aantal = $aantal;
    }

    public function setProductId(int $productId){
        $this->productId = $productId;
    }
}
