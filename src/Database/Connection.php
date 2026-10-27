<?php

class Connection
{
    /** Almacen en memoria para poder correr la demo sin MySQL levantado. */
    private static array $tablaEnMemoria = [];

    /** Instancia única de la clase (Singleton) */
    private static ?Connection $instance = null;

    /**
     * Constructor privado para evitar que se instancie con 'new Connection()' desde afuera
     */
    private function __construct() {}

    /**
     * Evitar que la instancia se pueda clonar
     */
    private function __clone() {}

    /**
     * ✅ Método Singleton para obtener la única instancia activa
     */
    public static function getInstance(array $config = []): Connection
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function ejecutar(string $sql): void
    {
        try {
            self::$tablaEnMemoria[] = $sql;
        } catch (Throwable $e) {
            // ✅ Fallar rápido y fuerte: loguear y relanzar la excepción
            throw new RuntimeException("Error al ejecutar la consulta SQL en la base de datos.", 0, $e);
        }
    }

    public function consultas(): array
    {
        return self::$tablaEnMemoria;
    }
}
