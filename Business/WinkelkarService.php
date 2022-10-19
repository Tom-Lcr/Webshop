<?php
declare(strict_types = 1);

namespace Business;

use Entities\Winkelkar;



class WinkelkarService {

    public function voegItemToe(int $productId, int $aantal) : Winkelkar {
        $winkelkar = new Winkelkar((int) $productId, (int) $aantal);
        return $winkelkar;
    }	
	
}

