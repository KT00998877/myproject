<?php
function getDatabaseConnection(): PDO {
    try {
        $dsn = 'pgsql:host=localhost;dbname=bookstore';
        $username = 'postgres';
        $password = '240604';
        
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        return $pdo;
    } catch (PDOException $e) {
        $error_message = 'Không thể kết nối đến cơ sở dữ liệu: ' . html_escape($e->getMessage());
        include __DIR__ . '/../view/error/404.php';
        exit();
    }
}

// Hàm html_escape (đã có trong dự án của bạn)
function html_escape(string|null $text): string {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8', false);
}