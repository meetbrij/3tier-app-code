<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Aws\SecretsManager\SecretsManagerClient;

function getDatabaseConnection() {

    $secretArn = getenv('DB_SECRET_ARN');

    if (!$secretArn) {
        throw new RuntimeException('DB_SECRET_ARN environment variable is not set');
    }

    $region = getenv('AWS_REGION') ?: 'us-east-1';

    $client = new SecretsManagerClient([
        'version' => 'latest',
        'region'  => $region
    ]);

    $result = $client->getSecretValue([
        'SecretId' => $secretArn
    ]);

    $secret = json_decode($result['SecretString'], true);

    if (!is_array($secret)) {
        throw new RuntimeException('Invalid database secret');
    }

    $host     = $secret['host'];
    $port     = $secret['port'] ?? 3306;
    $db_name  = $secret['dbname'];
    $username = $secret['username'];
    $password = $secret['password'];

    $dsn = "mysql:host=$host;port=$port;dbname=$db_name;charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    return new PDO($dsn, $username, $password, $options);
}
?>