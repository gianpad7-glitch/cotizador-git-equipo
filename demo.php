<?php
declare(strict_types=1);
require_once __DIR__ . '/contratos.php';

$local = new Cotizador(new EnvioLocal());
$nacional = new Cotizador(new EnvioNacional());
echo 'Local: ', $local->cotizar(1500), PHP_EOL;
echo 'Nacional: ', $nacional->cotizar(1500), PHP_EOL;
