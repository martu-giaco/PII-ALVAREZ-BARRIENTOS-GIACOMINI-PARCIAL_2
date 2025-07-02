<?php
require_once("../../functions/autoload.php");

Autenticacion::log_out();

header("location: ../index.php?sec=login");

?>