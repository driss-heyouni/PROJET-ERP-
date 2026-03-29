<?php
$url = "http://localhost:8069/jsonrpc";
$data = json_encode([
    'jsonrpc' => '2.0',
    'method' => 'call',
    'params' => [
        'service' => 'db',
        'method' => 'list',
        'args' => [],
    ]
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

echo "Response from Odoo: " . $response;
