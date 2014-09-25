<?php
$yii=dirname(__FILE__).'/yii_back/framework/yii.php';
switch ($_SERVER['SERVER_ADDR']) 
{
    case "192.168.0.234":
        $config=dirname(__FILE__).'/protected/config/local.php';
        break;
	case "172.18.100.43":
       $config=dirname(__FILE__).'/protected/config/saf.php';
       break;
    default:
        $config=dirname(__FILE__).'/protected/config/main.php';
        break;
}
require_once($yii);

Yii::createWebApplication($config)->run();