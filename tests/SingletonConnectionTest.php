<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Database/Connection.php';

class SingletonConnectionTest extends TestCase
{
    /**
     * Caso Positivo 1 (CP-01): Verifica que getInstance() devuelva siempre la misma instancia única
     * y que ambas referencias compartan el mismo estado en memoria.
     */
    public function testDevuelveMismaInstanciaUnicaYComparteEstado(): void
    {
        $instancia1 = Connection::getInstance();
        $instancia2 = Connection::getInstance();

        // Comprueba identidad estricta (mismo objeto en memoria)
        $this->assertSame($instancia1, $instancia2);

        // Comprueba que ejecutar SQL en una instancia se refleja en la otra
        $sqlPrueba = "INSERT INTO pedidos (total) VALUES (1500)";
        $instancia1->ejecutar($sqlPrueba);

        $this->assertContains($sqlPrueba, $instancia2->consultas());
    }

    /**
     * Caso Negativo 1 (CP-02): Verifica que no se pueda instanciar directamente con 'new Connection()'
     * ni clonar la instancia desde el exterior (encapsulamiento Singleton).
     */
    public function testImpideInstanciacionDirectaYClonacion(): void
    {
        $reflection = new ReflectionClass(Connection::class);

        $constructor = $reflection->getConstructor();
        $this->assertNotNull($constructor);
        $this->assertTrue($constructor->isPrivate(), 'El constructor debe ser privado');

        $cloneMethod = $reflection->getMethod('__clone');
        $this->assertTrue($cloneMethod->isPrivate(), 'El método __clone debe ser privado');
    }
}
