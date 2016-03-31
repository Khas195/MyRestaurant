<?php

/**
 * Created by PhpStorm.
 * User: Khas
 * Date: 12/11/2015
 * Time: 8:20 AM
 */
class SignUp extends Controller
{



    public function index()
    {

        if (!isset($_POST['email']) || !isset($_POST['password'])){
            $this->signUpFail();
            return;
        }

        $message = PackagePool::Instance()->requestPackage();
        $message->setValue(ControllerDef::COMMAND, ControllerCommand::STATE_CHANGE);
        $message->setValue(DatabaseDef::NAME_STATE, DatabaseDef::STATE_SIGNUP);

        PostOffice::Instance()->sendPackage($message);

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::GET_DATA);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_USERNAME, $_POST['username']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_EMAIL, $_POST['email']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_PASSWORD, $_POST['password']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_FNAME, $_POST['first_name']);
        if (isset($_POST['middle_name']))
        {
            $message->setValue(DatabaseDef::ATTRIBUTE_USER_MNAME, $_POST['middle_name']);
        }

        $message->setValue(DatabaseDef::ATTRIBUTE_USER_LNAME, $_POST['last_name']);
        $message->setValue(DatabaseDef::ATTRIBUTE_RECRUITMENT_DATE_CREATED, $_POST['day'] . '/' . $_POST['month'] . '/' .  $_POST['year']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_GENDER, $_POST['gender']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_PHONE, $_POST['phone']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_ADDRESS, $_POST['address']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_PROVINCE, $_POST['province']);
        $message->setValue(DatabaseDef::ATTRIBUTE_USER_DISTRICT, $_POST['district']);

        PostOffice::Instance()->sendPackage($message);
        if ($message->getValue(DatabaseDef::RESULT)){
            $this->signUpSuccess($message->getValue(DatabaseDef::RESULT));
        } else $this->signUpFail();
    }
    private function  signUpFail(){
        $message = PackagePool::Instance()->requestPackage();

        $views = [ViewDef::SIGN_UP_BOX];

        $message->setValue(ControllerDef::COMMAND, ControllerCommand::VIEW_PAGE);
        $message->setValue(ControllerDef::VIEWS, $views);


        PostOffice::Instance()->sendPackage($message);
        PackagePool::Instance()->returnPackage($message);
    }
    private function signUpSuccess($userID){
        $_SESSION[DatabaseDef::ATTRIBUTE_USER_USERID] = $userID;
        header('Location: http://localhost/MyRestaurant/public_html/MainPage/index');
        exit;
    }
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }
}