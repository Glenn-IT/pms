<?php
require_once('config.php');
require_once('classes/Master.php');

$master = new Master();
echo $master->get_dashboard_stats();
?>
