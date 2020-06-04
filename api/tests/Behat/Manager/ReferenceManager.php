<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ReferenceManager
{

    static public $cachedData = [];

    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel){}

    public function setCachedData($data){
        $incKey = "";
        $keyAlreadyExist = false;

        foreach($data as $key=>$val) {
            $incKey = $key;
        }

        if(sizeof(self::$cachedData) === 0) {
            array_push(self::$cachedData, $data);
        } else {
            foreach(self::$cachedData as $k=>$v) {
                foreach(self::$cachedData[$k] as $ky=>$vy) {
                    var_dump($ky);
                    if($ky === $incKey) {
                        $keyAlreadyExist = true;
                    }
                }
            }

            if(!$keyAlreadyExist) {
                array_push(self::$cachedData, $data);
            }
        }

    }


}
