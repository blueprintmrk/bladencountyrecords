#!/usr/bin/php
<?php

//setup global $_SERVER variables to keep WP from trying to redirect
$_SERVER = array(
  "HTTP_HOST" => "http://opportunity.pcc.edu",
  "SERVER_NAME" => "http://opportunity.pcc.edu",
  "REQUEST_URI" => "/",
  "REQUEST_METHOD" => "GET"
);

//require the WP bootstrap
require_once('../../../wp-load.php');

//add your own code here
require '../lib/facebook-php-sdk/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => 'YOUR_APP_ID',
  'secret' => 'YOUR_APP_SECRET',
));


echo "Something happened";