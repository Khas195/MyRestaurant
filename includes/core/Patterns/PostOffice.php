<?php
// Cao Thanh Tung
// 12/1/2015 - write post office

/**
 *
 */
require_once FILE_PATH('patterns') . 'PackagePool.php';
require_once FILE_PATH('patterns')  . 'IReceiver.php';
/**
 *
 */
class PostOffice
{
    private $mReceiverList; // Package

    private static $instance;
    public static function Instance()
    {
        if (is_null(PostOffice::$instance)) {
            PostOffice::$instance = new PostOffice();
        }
        return PostOffice::$instance;
    }

    function __construct()
    {

        $this->mReceiverList = PackagePool::Instance()->requestPackage();
    }

    public function sendPackage(Package $mPackage)
    {

        $mReceivers = $this->mReceiverList->returnAllValues();

        foreach ($mReceivers as $receiver) {
            $receiver->receivePackage($mPackage);
        }
    }

    public function addReceiver(IReceiver $newReceiver)
    { // newReceiver: IReceiver
        $this->mReceiverList->setValue(NULL, $newReceiver);
    }

    public function removeReceiver(IReceiver $receiver)
    { // $receiver: IReceiver
        $this->mReceiverList->removeValue($receiver);
    }

}

?>