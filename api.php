<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$GROQ_API_KEY = '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';

$SYSTEM_PROMPT = "Anda adalah asisten teknis yang sangat membantu. " .
    "Jika menjawab dengan perintah terminal, kode, atau konfigurasi, selalu bungkus dalam blok kode markdown (```bahasa\n...\n```). " .
    "Gunakan bahasa Indonesia. Jangan berkhayal. Fokus pada kejelasan dan keakuratan.";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = trim($input['message'] ?? '');
$model = $input['model'] ?? 'meta-llama/llama-4-maverick-17b-128e-instruct';
$history = $input['history'] ?? [];

$allowed = ['meta-llama/llama-4-maverick-17b-128e-instruct', 'moonshotai/kimi-k2-instruct-0905'];
if (!in_array($model, $allowed) || !$userMessage) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$messages = [['role' => 'system', 'content' => $SYSTEM_PROMPT]];
foreach ($history as $msg) {
    $role = ($msg['role'] === 'user') ? 'user' : 'assistant';
    $messages[] = ['role' => $role, 'content' => $msg['content']];
}
$messages[] = ['role' => 'user', 'content' => $userMessage];

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.groq.com/openai/v1/chat/completions',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'model' => $model,
        'messages' => $messages,
        'temperature' => 0.7,
        'max_tokens' => 1024
    ]),
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $GROQ_API_KEY,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code(500);
    echo json_encode(['error' => 'AI sedang tidak responsif. Coba lagi.']);
    exit;
}

$data = json_decode($response, true);
$reply = $data['choices'][0]['message']['content'] ?? 'Tidak ada respons.';
echo json_encode(['reply' => $reply]);
?>