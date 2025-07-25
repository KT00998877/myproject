<?php
define('BASE_VIEW_PATH', realpath(__DIR__ . '/../src/view'));

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/config/database.php';

use Bramus\Router\Router;

$pdo = getDatabaseConnection();
$router = new Router();

use App\Controllers\HomeController;

$pdo = getDatabaseConnection();
$router->get('/', function () use ($pdo) {
    $controller = new HomeController($pdo);
    $controller->index();
});

use App\Controllers\AboutController;

$router->get('/gioithieu', function () use ($pdo) {
    $controller = new AboutController($pdo);
    $controller->index();
});

use App\Controllers\LHController;
$router->get('/lienhe', function () use ($pdo) {
    $controller = new LHController($pdo);
    $controller->index();
    $controller->handle();
});
$router->post('/lienhe', function () use ($pdo) {
    $controller = new LHController($pdo);
    $controller->handle(); 
});

use App\Controllers\CategoryController;

$router->get('/theloai/(\d+)', function ($id) {
    $controller = new CategoryController();
    $controller->show($id);
});

use App\Controllers\TTController;
$router->get('/tintuc', function () {
    $controller = new TTController();
    $controller->index();
});

use App\Controllers\VHController;

$router->get('/vanhoc', function () use ($pdo) {
    $controller = new VHController($pdo);
    $controller->index();
});

use App\Controllers\KTController;

$router->get('/kinhte', function () use ($pdo) {
    $controller = new KTController($pdo);
    $controller->index();
});

use App\Controllers\NNController;

$router->get('/ngoaingu', function () use ($pdo) {
    $controller = new NNController($pdo);
    $controller->index();
});

use App\Controllers\TLController;

$router->get('/tamly', function () use ($pdo) {
    $controller = new TLController($pdo);
    $controller->index();
});

use App\Controllers\KHController;

$router->get('/khoahoc', function () use ($pdo) {
    $controller = new KHController($pdo);
    $controller->index();
});

use App\Controllers\TNController;

$router->get('/thieunhi', function () use ($pdo) {
    $controller = new TNController($pdo);
    $controller->index();
});


use App\Controllers\DKController;

$router->get('/dangky', function () use ($pdo) {
    $controller = new DKController($pdo);
    $controller->index();
});
$router->post('/dangky', function () use ($pdo) {
    $controller = new DKController($pdo);
    $controller->handle();
});


use App\Controllers\DNController;

$router->get('/dangnhap', function () use ($pdo) {
    $controller = new DNController($pdo);
    $controller->index();
});

$router->post('/dangnhap', function () use ($pdo) {
    $controller = new DNController($pdo);
    $controller->handle();
});



$router->post('/add-to-cart', function () use ($pdo) {
    $controller = new \App\Controllers\CartController($pdo);
    $controller->AddToCart();
});


$router->get('/cart', function () use ($pdo) {
    $controller = new \App\Controllers\CartController($pdo);
    $controller->ViewCart();
});

$router->post('/cart/update', function () use ($pdo) {
    $controller = new \App\Controllers\CartController($pdo);
    $controller->UpdateQuantity();
});

use App\Controllers\LogoutController;


$router->get('/dangxuat', function () {
    $controller = new LogoutController();
    $controller->handle();
});

$router->post('/cart/delete', function () use ($pdo) {
    $controller = new \App\Controllers\CartController($pdo);
    $controller->removeItem();
});


$router->post('/dat-hang', function () use ($pdo) {
    require BASE_VIEW_PATH . '/dat_hang.php';
});

$router->post('/dat-hang/xac-nhan', function () use ($pdo) {
    $controller = new \App\Controllers\DH_Controller($pdo);
    $controller->xacNhanDatHang();
});


use App\Controllers\ProductController;

$router->get('/admin/products', function () use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->index();
});
$router->get('/admin/products/create', function () use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->create();
});

$router->post('/admin/products/create', function () use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->create();
});

$router->get('/admin/products/edit/(\d+)', function ($id) use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->edit($id);
});


$router->post('/admin/products/edit/(\d+)', function ($id) use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->edit($id);
});

$router->get('/sachmoi', function () use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->sachMoi();
});

$router->get('/admin/products/delete/(\d+)', function ($id) use ($pdo) {
    $controller = new ProductController($pdo);
    $controller->delete($id);
});

$router->get('/admin/products/delete', function () {
    $_SESSION['notification'] = 'Thiếu ID sản phẩm để xoá!';
    header('Location: /');
    exit();
});

use App\Controllers\SanPhamController;

$router->get('/sanpham/(\d+)', function ($maSach) use ($pdo) {
    $controller = new SanPhamController($pdo);
    $controller->chiTiet($maSach);
});

$router->get('/tim-kiem', function () use ($pdo) {
    $controller = new \App\Controllers\TimKiemController($pdo);
    $controller->tim();
});



$router->run();
?>
<?php
require_once BASE_VIEW_PATH . '/layout/header.php';
require_once BASE_VIEW_PATH . '/layout/footer.php'; ?>
