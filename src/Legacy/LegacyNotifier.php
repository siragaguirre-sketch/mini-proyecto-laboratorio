<?php
/**
 * ============================================================================
 *  SISTEMA HEREDADO DEL LABORATORIO
 *  Patron esperado: ADAPTER (estructural)
 * ============================================================================
 *
 *  CONTEXTO: el laboratorio ya tenia un sistema de avisos hecho por otro
 *  proveedor. No lo podemos modificar: lo usan tambien Recepcion y Facturacion.
 *
 *  ❌ DEUDA SEMBRADA
 *     1. Alguien "resolvio" la incompatibilidad copiando el cuerpo de
 *        sendMessage() dentro de nuestro codigo (ver copiaDeLegacyEnNuestroSistema).
 *     2. Otro alguien agrego el metodo send() DENTRO de la clase heredada,
 *        modificando codigo de un tercero.
 *
 *  ✅ FORMA CORRECTA
 *     Un Adapter que implemente NUESTRO contrato y traduzca la llamada.
 *     La incompatibilidad queda encerrada en un unico archivo.
 * ============================================================================
 */

class LegacyNotifier
{
    /** Metodo original del proveedor. No lo podemos cambiar. */
    public function sendMessage(string $text): void
    {
        echo "[LEGACY] {$text}<br>";
    }
}
