<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * ============================================================================
 *  MODELO Order (Refactorizado)
 * ============================================================================
 * 
 *  ✅ REFACTORIZACIÓN APLICADA:
 *     1. Propiedades readonly y validación en el constructor (Encapsulamiento).
 *     2. La persistencia se extrae a OrderRepository (Principio SRP).
 *     3. El cálculo de precio se delega a PricingStrategy (Principio OCP / Strategy).
 * ============================================================================
 */
class Order
{
    /**
     * Constructor con propiedades de solo lectura y validación de estado.
     *
     * @param int $id
     * @param string $patient
     * @param float $amount
     * @param string $patientType
     * @throws InvalidArgumentException
     */
    public function __construct(
        public readonly int $id,
        public readonly string $patient,
        public readonly float $amount,
        public readonly string $patientType
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException('El importe no puede ser negativo');
        }

        if (trim($patient) === '') {
            throw new InvalidArgumentException('El paciente es obligatorio');
        }
    }
}