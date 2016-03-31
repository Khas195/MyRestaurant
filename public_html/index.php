<!DOCTYPE html>

<html>
<head>
    <?php require_once '../includes/init.php'; ?>
    <title> MyRestaurant</title>
    <link rel="stylesheet" href="<?php  echo FILE_PATH('bootstrap') . 'css/bootstrap.css' ?>">
    <script type="text/javascript" src="<?php echo FILE_PATH('bootstrap').'js/bootstrap.js';?>"></script>
</head>
<body>
<?php

PostOffice::Instance()->addReceiver(ModelManager::Instance());
PostOffice::Instance()->addReceiver(ViewManager::Instance());
$controller = new ControllerManager();




?>

</body>
</html>
