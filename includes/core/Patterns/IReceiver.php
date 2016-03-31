<?php

interface IReceiver
{
    // IReceiver's functions should only be used by the PostOffice
    public function receivePackage(Package $messagePackage);
}
