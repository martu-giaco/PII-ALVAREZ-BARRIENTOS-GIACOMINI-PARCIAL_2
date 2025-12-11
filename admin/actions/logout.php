<?php
require_once __DIR__ . '/../../functions/autoload.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['loggedIn'])) {
        unset($_SESSION['loggedIn']);
    }
    header("Location: ../../index.php?sec=login");
    exit;
}

header("Location: ../../index.php");
exit;
