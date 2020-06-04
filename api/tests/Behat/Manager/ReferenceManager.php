<?php

namespace App\Tests\Behat\Manager;

use ApiPlatform\Core\Api\IriConverterInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class ReferenceManager
{

    // old way
    static public $cachedData = [];

    // new way
    static public $newCache = [];


    public function __construct(IriConverterInterface $iriConverter, KernelInterface $kernel)
    {
    }


    // new way
    public function getNewCache()
    {
        return self::$newCache;
    }

    public function addElementToNewCache($arr_fixtureKey_object, $fixtureId)
    {
        array_push(self::$newCache, $arr_fixtureKey_object);

    }


    // OLD way
    public function setCachedData($data)
    {
        $incKey = "";
        $keyAlreadyExist = false;

        foreach ($data as $key => $val) {
            $incKey = $key;
        }

        if (sizeof(self::$cachedData) === 0) {
            array_push(self::$cachedData, $data);
        } else {
            foreach (self::$cachedData as $k => $v) {
                foreach (self::$cachedData[$k] as $ky => $vy) {
                    //var_dump($ky);
                    if ($ky === $incKey) {
                        $keyAlreadyExist = true;
                    }
                }
            }

            if (!$keyAlreadyExist) {
                array_push(self::$cachedData, $data);
            }
        }

    }


}
