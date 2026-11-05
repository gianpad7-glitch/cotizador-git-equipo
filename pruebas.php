<?php
declare(strict_types=1);
require_once __DIR__ . '/contratos.php';

function comprobar(bool $condicion, string $caso): void
{
    if (!$condicion) {
        throw new RuntimeException('Fallo: ' . $caso);
    }
}

$casos = [[1, 1000], [1000, 1000], [1001, 1200], [1500, 1200], [10000, 2800]];
foreach ($casos as [$peso, $esperado]) {
    $cotizador = new Cotizador(new EnvioNacional());
    comprobar($cotizador->cotizar($peso) === $esperado, 'Peso ' . $peso);
}
foreach ([new EnvioLocal(), new EnvioNacional()] as $tarifa) {
    comprobar($tarifa instanceof TarifaEnvio, 'Tipo del contrato');
    $cotizador = new Cotizador($tarifa);
    foreach ([0, -1, 10001] as $peso) {
        $rechazo = false;
        try {
            $cotizador->cotizar($peso);
        } catch (InvalidArgumentException $e) {
            $rechazo = true;
        }
        comprobar($rechazo, 'Rechazo de ' . $peso);
    }
}
class TarifaFijaPrueba implements TarifaEnvio
{
    public function calcular(int $pesoGramos): int
    {
        return 777;
    }
}
$prueba = new Cotizador(new TarifaFijaPrueba());
comprobar($prueba->cotizar(1000) === 777, 'Delegación al colaborador');
echo 'OK: limites, rechazos y delegacion', PHP_EOL;
