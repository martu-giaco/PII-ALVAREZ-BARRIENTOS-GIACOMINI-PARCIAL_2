<?php
require_once("../../functions/autoload.php");

Autenticacion::log_out();

header("Location: ../../index.php?sec=login");
exit;
