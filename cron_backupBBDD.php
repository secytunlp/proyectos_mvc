<?php
session_start();
include_once 'conf/cron_config.php';
$controller = new CdtActionController();
$controller->execute('backup_bbdd');
?>