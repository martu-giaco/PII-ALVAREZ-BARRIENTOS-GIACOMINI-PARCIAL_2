<?php
require_once __DIR__ . '/../../functions/autoload.php';

Autenticacion::log_out();

header("Location: ../../index.php?sec=login");
exit;
