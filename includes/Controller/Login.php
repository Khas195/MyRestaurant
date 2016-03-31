<?php

class Login extends  Controller
{
    public function receivePackage(Package $messagePackage)
    {
    }
    private function loginFail($code){
        $message = PackagePool::Instance()->requestPackage();

        if ($code == 1)
            $errors = 'Your Email or Password is incorrect';
        else $errors = '';

        $data = PackagePool::Instance()->requestPackage();
        $data->setValue('errors', $errors);
        $views = [ViewDef::LOGIN_BOX];

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::VIEWS, $views);
        $message->setValue(ControllerDef::DATA, $data);


        PostOffice::Instance()->sendPackage($message);

        PackagePool::Instance()->returnPackage($data);
        PackagePool::Instance()->returnPackage($message);
    }
    private function loginSuccess()
    {// call model to load the user
        $message = PackagePool::Instance()->requestPackage();
        $_SESSION[DatabaseDef::ATTRIBUTE_USER_EMAIL] = $_POST['email'];

        $data = PackagePool::Instance()->requestPackage();
        $data->setValue(DatabaseDef::ATTRIBUTE_USER_EMAIL, $_POST['email'] );

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::DATA, $data);
        $message->setValue(ControllerDef::VIEWS, [ViewDef::PROFILE]);

        PostOffice::Instance()->sendPackage($message);
        PackagePool::Instance()->returnPackage($message);
    }

    public function index()
    {

        $message = PackagePool::Instance()->requestPackage();

        if (!isset($_POST['email']) || !isset($_POST['password'])){
            $this->loginFail(0);
            PackagePool::Instance()->returnPackage($message);
            return;
        }

        // send package to Model telling it to switch to check the id and password
        $message->setValue(ControllerDef::COMMAND, ControllerCommand::STATE_CHANGE);
        $message->setValue(DatabaseDef::NAME_STATE, DatabaseDef::STATE_LOGIN);

        PostOffice::Instance()->sendPackage($message);

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA );
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_EMAIL, $_POST['email']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_PASSWORD, $_POST['password']);

        // after checking id and pass word if the correct tell model to switch to profile state and load info for profile page
        // else gives the view errors for the login page

        PostOffice::Instance()->sendPackage($message);

        if ( $message->getValue(DatabaseDef::RESULT) == false)
        {
            $this->loginFail(1);
        } else{
            $this->loginSuccess($message);
        }

        PackagePool::Instance()->returnPackage($message);


    }

}

