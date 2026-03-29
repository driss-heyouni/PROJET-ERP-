<?php
$url = "http://localhost:8069/xmlrpc/2/db";
$client = new \GuzzleHttp\Client();
try {
    $response = $client->post("http://localhost:8069/jsonrpc", [
        'json' => [
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'service' => 'db',
                'method' => 'list',
                'args' => [],
            ]
        ]
    ]);
    echo "Databases: " . $response->getBody();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
