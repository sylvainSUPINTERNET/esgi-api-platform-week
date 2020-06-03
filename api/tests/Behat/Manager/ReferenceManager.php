<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ReferenceManager
{

    static public $cachedData = [];

    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel){}

    public function setCachedData($data){
        self::$cachedData = $data;
    }


}
