<?php
$secretKey = "56f638e5368f3281868b83700e211e1ec2078cf0";

$params = array( 
  "apiKey" => "2FFBECB9-9AB1-4BBC-8671-61B4F6LDEAC9",
  "email" => "dmanzanod@gmail.com",
  "name" => "Pedro Raul Perez",
  "pay_mode" => "auto",
  "externalId" => "dmanzanod@gmail.com",
  "status" => "1"
); 

$keys = array_keys($params);
sort($keys);

$toSign = "";
foreach($keys as $key) {
  $toSign .= $key . $params[$key];
};
echo $toSign."<br/>"."<br/>"."<br/>";

$signature = hash_hmac('sha256', $toSign , $secretKey);


echo $signature;

?>