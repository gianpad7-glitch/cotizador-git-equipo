<?php
declare(strict_types=1);

interface TarifaEnvio
{
    public function calcular(int $pesoGramos): int;
}

class EnvioLocal implements TarifaEnvio
{
    public function calcular(int $pesoGramos): int
    {
        if ($pesoGramos < 1 || $pesoGramos > 10000) {
            throw new InvalidArgumentException('Peso fuera de rango');
        }
        return 500;
    }
}

class EnvioNacional implements TarifaEnvio
{
    public function calcular(int $pesoGramos): int
    {
        if ($pesoGramos < 1 || $pesoGramos > 10000) {
            throw new InvalidArgumentException('Peso fuera de rango');
        }
        $kilos = intdiv($pesoGramos + 999, 1000);
        return 800 + 200 * $kilos;
    }
}

class Cotizador
{
    private TarifaEnvio $tarifa;

    public function __construct(TarifaEnvio $tarifa)
    {
        $this->tarifa = $tarifa;
    }

    public function cotizar(int $pesoGramos): int
    {
        return $this->tarifa->calcular($pesoGramos);
    }
}
