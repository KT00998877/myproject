<?php
try {
  $pdo = new PDO('pgsql:host=localhost;dbname=bookstore', 'postgres', '240604');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $pdo;
} catch (PDOException $e) {
  $error_message = 'Không thể kết nối đến CSDL';
  $reason = $e->getMessage();
  include(__DIR__ . '/../view/error/404.php');
  include_once(__DIR__ . '/../view/layout/footer.php');

  exit();
}
