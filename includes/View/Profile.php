<?php

class Profile extends View
{

    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        require_once HTML_PUBLIC . 'Profile.html';
    }
}