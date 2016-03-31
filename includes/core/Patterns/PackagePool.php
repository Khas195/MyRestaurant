<?php
require_once FILE_PATH('patterns') . 'Package.php';

/**
 *
 */
class PackagePool
{
    /* Singleton */
    private static $instance;
    private $usedList;
    private $availableList;


    public static function Instance()
    {
        if (PackagePool::$instance == null) {
            PackagePool::$instance = new PackagePool();
        }
        return PackagePool::$instance;
    }


    function __construct()
    {
        $this->usedList = array();
        $this->availableList = array();
    }


    public function requestPackage()
    {
        if (empty($this->availableList)) {
            // create new package
            $newPackage = new  Package();
            array_push($this->usedList, $newPackage);
            return $newPackage;
        } else {
            // get package from avail list
            $availablePack = array_pop($this->availableList);
            array_push($this->usedList, $availablePack);
            return $availablePack;
        }
    }

    public function returnPackage($mPackage)
    {
        $mPackage->resetPackage();
        $temp = array_search($mPackage, $this->usedList);
        unset($this->usedList[$temp]);
        array_push($this->availableList, $mPackage);
    }

}

?>