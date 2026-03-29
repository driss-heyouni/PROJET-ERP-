<?php
$url = "http://localhost:8069/jsonrpc";
$db = "oryacht";
$username = "admin";
$password = "admin";

$data = json_encode([
    'jsonrpc' => '2.0',
    'method' => 'call',
    'params' => [
        'service' => 'common',
        'method' => 'login',
        'args' => [$db, $username, $password],
    ]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

echo "Login status: " . $response;
