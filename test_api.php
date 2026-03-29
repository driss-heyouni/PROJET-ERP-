<?php
$product = [
    'name' => 'Chaise de Bureau Expert',
    'list_price' => 120,
    'description' => 'Chaise ergonomique ajustable'
];

$ch = curl_init('http://localhost:8000/api/product');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($product));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$resp = curl_exec($ch);
echo "Resultat ajout produit: " . $resp . "\n";
curl_close($ch);

$quote = [
    'partner_id' => 1,
    'order_lines' => [
        ['product_id' => 1, 'product_uom_qty' => 3]
    ]
];

$ch = curl_init('http://localhost:8000/api/quote');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($quote));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$resp = curl_exec($ch);
echo "Resultat création devis: " . $resp . "\n";
curl_close($ch);
?>
