<?php

class LoginBox extends View
{
    public function receivePackage(Package $messagePackage)
    {
        // TODO: Implement receivePackage() method.
    }

    public function render()
    {
        if (!is_null($this->data)) {
            $this->data = $this->data->getValue('errors');
        }
        ?>

        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'Layout.css'; ?>">
        <link rel="stylesheet" href="<?php echo FILE_PATH('css') . 'Login.css'; ?>">
        <meta charset="UTF-8">
        <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

        <?php

        require_once HTML_PUBLIC . 'Login.html';
    }
}

