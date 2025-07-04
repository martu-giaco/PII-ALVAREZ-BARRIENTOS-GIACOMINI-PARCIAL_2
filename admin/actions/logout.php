<?php
require_once("../../functions/autoload.php");

Autenticacion::log_out();

header("Location: ../vistas/login.php");
exit;
