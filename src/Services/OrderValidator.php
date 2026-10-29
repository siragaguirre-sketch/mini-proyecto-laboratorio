<?php

final class OrderValidator
{
    public function validate(string $patient, float $amount): void
    {
        if (trim($patient) === '') {
            throw new InvalidArgumentException('Falta el paciente');
        }

        if ($amount <= 0) {
            throw new InvalidArgumentException('Monto invalido');
        }
    }
}