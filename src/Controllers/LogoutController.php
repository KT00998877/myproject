<?php

namespace App\Controllers;

class LogoutController
{
    public function handle()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /dangnhap");
        exit();
    }
}
