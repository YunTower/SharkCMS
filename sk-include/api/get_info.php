<?php
include 'sk-include/config.php';
echo "{'code':'$api_code','msg':'$api_msg','name':'" . $config['App_Name'] . "','version':'" . $config['App_Version'] . "','type':'" . $config['App_Type'] . "'}";
exit;
