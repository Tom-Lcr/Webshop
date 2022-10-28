<?php

declare(strict_types=1);

namespace Business;

use Data\ActieCodeDAO;
use Exceptions\ActieCodeBestaatNietException;
use Exceptions\ActieCodeNietMeerGeldigException;

class ActiecodeService
{
    public function controleer(string $naam)
    {
        return (new ActieCodeDAO())->controleerActiecode($naam);
        /*     try {
        if ((new ActieCodeDAO())->controleerActiecode($naam)) return "OK";
    } catch (ActieCodeBestaatNietException) {
        return "Deze code bestaat niet";
    } catch (ActieCodeNietMeerGeldigException) {
        return "Deze code is niet meer geldig";
    }
    */
    }
}
