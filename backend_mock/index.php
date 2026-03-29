<?php
// High-Performance Mock API Server for OfficeDesign Pro - v4 (FULL ODOO SYNC)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
header('Content-Type: application/json');

// --- ⚡ INSTANT LOGIN PATH ---
if ($uri === '/api/login') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
    if ($email === 'heyounidriss@gmail.com' && $password === 'driss') {
        echo json_encode(['token' => 'jwt-admin-'.time(), 'user' => ['id' => 999, 'name' => 'Idriss Heyou', 'email' => 'heyounidriss@gmail.com', 'role' => 'admin']]);
        exit;
    }
    $dbFile = __DIR__ . '/database.sqlite';
    if (file_exists($dbFile)) {
        $pdo = new PDO('sqlite:' . $dbFile);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            echo json_encode(['token' => 'jwt-token-'.time(), 'user' => $user]);
            exit;
        }
    }
    http_response_code(401); echo json_encode(['error' => 'Identifiants incorrects']); exit;
}

// --- 👥 CLIENTS SYNC (5 COMPANIES) ---
if ($uri === '/api/clients') {
    $odoo_url = "http://localhost:8069/jsonrpc";
    $db = "oryacht"; $username = "heyounidriss@gmail.com"; $password = "DRISS123";
    $auth_data = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'common', 'method' => 'login', 'args' => [$db, $username, $password]]]);
    $ch = curl_init($odoo_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data); curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = json_decode(@curl_exec($ch), true); $uid = $res['result'] ?? null;
    if ($uid) {
        $search_data = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'object', 'method' => 'execute_kw', 'args' => [$db, $uid, $password, 'res.partner', 'search_read', [[['is_company', '=', true]]], ['fields' => ['id', 'name', 'city', 'email'], 'limit' => 5]]]]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $search_data);
        echo json_encode(json_decode(curl_exec($ch), true)['result'] ?? []);
    } else {
        echo json_encode([['id' => 1, 'name' => 'Entreprise Démo 1', 'city' => 'Paris']]);
    }
    curl_close($ch);
    exit;
}

// --- 📦 PRODUCTS SYNC (RESTORED TO ODOO) ---
if ($uri === '/api/products') {
    $odoo_url = "http://localhost:8069/jsonrpc";
    $db = "oryacht"; $username = "heyounidriss@gmail.com"; $password = "DRISS123";
    $auth_data = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'common', 'method' => 'login', 'args' => [$db, $username, $password]]]);
    $ch = curl_init($odoo_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data); curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $res = json_decode(@curl_exec($ch), true); $uid = $res['result'] ?? null;
    
    if ($uid) {
        $search_data = json_encode([
            'jsonrpc' => '2.0',
            'method' => 'call',
            'params' => [
                'service' => 'object', 
                'method' => 'execute_kw', 
                'args' => [$db, $uid, $password, 'product.product', 'search_read', [
                    [
                        ['sale_ok','=',true],
                        ['name', 'not ilike', 'bateau'],
                        ['name', 'not ilike', 'yacht']
                    ]
                ], [
                    'fields' => ['id', 'name', 'list_price', 'qty_available', 'description_sale'],
                    'limit' => 30
                ]]
            ]
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $search_data);
        $products = json_decode(curl_exec($ch), true)['result'] ?? [];
        foreach($products as &$p) {
            $p['image'] = 'https://placehold.co/400x300/f8fafc/3b82f6?text=' . urlencode($p['name']);
            $p['description'] = $p['description_sale'] ?? 'Produit Odoo Direct';
        }
        echo json_encode($products);
    } else {
        echo json_encode([['id' => 101, 'name' => 'Produit Démo', 'list_price' => 100, 'qty_available' => 10]]);
    }
    curl_close($ch);
    exit;
}

// --- 💼 DEVIS SYNC ---
if ($uri === '/api/quote') {
    // Quote logic from before (Real XML-RPC) ...
    $input = json_decode(file_get_contents('php://input'), true);
    if (!empty($input['partner_id']) && !empty($input['items'])) {
        $odoo_url = "http://localhost:8069/jsonrpc"; $db = "oryacht"; $username = "heyounidriss@gmail.com"; $password = "DRISS123";
        $auth_data = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'common', 'method' => 'login', 'args' => [$db, $username, $password]]]);
        $ch = curl_init($odoo_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POSTFIELDS, $auth_data); curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $res = json_decode(@curl_exec($ch), true); $uid = $res['result'] ?? null;
        if ($uid) {
            $order_payload = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'object', 'method' => 'execute_kw', 'args' => [$db, $uid, $password, 'sale.order', 'create', [['partner_id' => (int)$input['partner_id']]]]]]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $order_payload);
            $res = json_decode(curl_exec($ch), true); $order_id = $res['result'] ?? null;
            if ($order_id) {
                foreach($input['items'] as $item) {
                    $line_payload = json_encode(['jsonrpc' => '2.0', 'method' => 'call', 'params' => ['service' => 'object', 'method' => 'execute_kw', 'args' => [$db, $uid, $password, 'sale.order.line', 'create', [[
                        'order_id' => $order_id, 'product_id' => (int)$item['id'], 'product_uom_qty' => (float)$item['quantity'], 'price_unit' => (float)$item['list_price']
                    ]]]]]);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $line_payload); curl_exec($ch);
                }
                echo json_encode(['message' => 'Devis généré dans Odoo avec succès !', 'order_id' => $order_id, 'status' => 'success']);
                curl_close($ch); exit;
            }
        }
        echo json_encode(['message' => 'Devis créé (Mode Simulation)', 'order_id' => rand(100, 999)]);
    }
    exit;
}
?>
