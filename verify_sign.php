<?php
header("Content-type: text/html; charset=UTF-8");
include('config.php');
include('lib/teegon.php');
$srv = new TeegonService(TEE_API_URL);
$s = $srv->verify_return($_GET);
print_r($s);
exit;

