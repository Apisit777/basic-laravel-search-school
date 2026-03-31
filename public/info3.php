<?php
header('Content-Type: text/html; charset=utf-8');

$apiUrl = 'https://orientalprincess.com/api/getProductImage.php';

function callApi($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);

    curl_close($ch);

    return [
        'response'  => $response,
        'http_code' => $httpCode,
        'error'     => $error
    ];
}

$result = callApi($apiUrl);

$products = [];
$errorMessage = '';

if (!empty($result['error'])) {
    $errorMessage = 'cURL Error: ' . $result['error'];
} elseif ((int)$result['http_code'] !== 200) {
    $errorMessage = 'HTTP Error: ' . $result['http_code'];
} else {
    $decoded = json_decode($result['response'], true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        $errorMessage = 'JSON Decode Error: ' . json_last_error_msg();
    } elseif (!is_array($decoded)) {
        $errorMessage = 'ข้อมูลที่ได้กลับมาไม่ใช่ array';
    } else {
        $products = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Product Image API Demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        h1 {
            margin-top: 0;
            font-size: 28px;
        }

        .api-box {
            background: #fff;
            border: 1px solid #ddd;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            word-break: break-all;
        }

        .error-box {
            background: #ffe7e7;
            border: 1px solid #ffb3b3;
            color: #b10000;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
            background: #fafafa;
        }

        .card-body {
            padding: 12px;
        }

        .name {
            font-size: 15px;
            font-weight: bold;
            line-height: 1.4;
            margin-bottom: 10px;
            min-height: 44px;
        }

        .meta {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
        }

        .json-box {
            margin-top: 30px;
            background: #111;
            color: #0f0;
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-size: 13px;
        }

        @media (max-width: 1024px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .card img {
                height: 200px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .card img {
                height: 220px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <h1>Product Image API Demo</h1>

    <div class="api-box">
        <strong>API URL:</strong><br>
        <?php echo htmlspecialchars($apiUrl, ENT_QUOTES, 'UTF-8'); ?>
    </div>

    <?php if ($errorMessage !== ''): ?>
        <div class="error-box">
            <strong>เกิดข้อผิดพลาด:</strong><br>
            <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php else: ?>

        <div class="grid">
            <?php foreach ($products as $item): ?>
                <div class="card">
                    <img
                        src="<?php echo htmlspecialchars(isset($item['image']) ? $item['image'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                        alt="<?php echo htmlspecialchars(isset($item['name']) ? $item['name'] : '', ENT_QUOTES, 'UTF-8'); ?>"
                    >
                    <div class="card-body">
                        <div class="name">
                            <?php echo htmlspecialchars(isset($item['name']) ? $item['name'] : '-', ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                        <div class="meta">
                            <div><strong>ID:</strong> <?php echo htmlspecialchars(isset($item['id']) ? $item['id'] : '-', ENT_QUOTES, 'UTF-8'); ?></div>
                            <div><strong>SKU:</strong> <?php echo htmlspecialchars(isset($item['sku']) ? $item['sku'] : '-', ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="json-box">
<pre><?php echo htmlspecialchars(json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8'); ?></pre>
        </div>

    <?php endif; ?>

</body>
</html>