<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;

$factory = (new Factory)->withServiceAccount('fcbpay_credential.json')
->withDatabaseUri('https://fcbpay-website-7c029-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
$storage = $factory->createStorage();

?>