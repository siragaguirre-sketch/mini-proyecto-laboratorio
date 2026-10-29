<?php
/**
 * ============================================================================
 *  CONTROLADOR DE PEDIDOS
 *  Patron esperado: MVC bien aplicado (arquitectonico) + SRP
 * ============================================================================
 *
 *  ❌ DEUDA SEMBRADA — el "God Controller"
 *     1. Arma SQL directamente.
 *     2. Contiene reglas de negocio (descuentos).
 *     3. Imprime HTML con echo.
 *     4. Crea con new todas sus dependencias concretas.
 *     5. Repite por TERCERA vez el if de notificaciones.
 *
 *  Tener las carpetas /Controllers /Models /views NO significa aplicar MVC.
 *  MVC es separacion de responsabilidades, no estructura de directorios.
 *
 *  ✅ FORMA CORRECTA
 *     El controlador solo: recibe la entrada, la valida como entrada,
 *     llama a UN servicio o fachada, y elige que vista renderizar.
 * ============================================================================
 */

class OrderController
{
    public function __construct(private OrderService $orderService)
    {
    }

    /**
     * ❌ METODO MAL APLICADO: create()
     *    Mezcla las tres capas de MVC dentro de un solo metodo.
     */
    public function create(): void
    {
        ['pedido' => $pedido, 'error' => $error] = $this->prepareCreateView($_GET);
        require __DIR__ . '/../../views/order-created.php';
    }

    private function prepareCreateView(array $input): array
    {
        $error = null;
        try {
            $pedido = $this->orderService->createOrder(
                (int) ($input['id'] ?? 1),
                (string) ($input['paciente'] ?? 'Juan Perez'),
                (float) ($input['monto'] ?? 15000),
                (string) ($input['tipo'] ?? 'obra_social')
            );
        } catch (InvalidArgumentException $exception) {
            $pedido = null;
            $error = $exception->getMessage();
        }

        return ['pedido' => $pedido, 'error' => $error];
    }

    /*
     * ✅ FORMA CORRECTA:
     *
     */

    /**
     * ❌ METODO MAL APLICADO: index()
     *    Delega en la vista la consulta a la base de datos (ver views/orders.php).
     */
    public function index(): void
    {
        require __DIR__ . '/../../views/orders.php';
    }

    /**
     * ❌ METODO MAL APLICADO: report()
     *    Usa banderas booleanas ilegibles (ver ReportGenerator).
     */
    public function report(): void
    {
        $generador = new ReportGenerator();
        echo $generador->generate('Pedidos del dia', true, true, true);
    }
}

/*
 * ----------------------------------------------------------------------------
 * EJERCICIO 7 (TP): dejar create() con un maximo de 5 lineas ejecutables,
 * sin SQL, sin reglas de negocio y sin echo.
 *
 * PREGUNTA PARA EL PR: cuales de los 5 problemas de este archivo son deuda
 * de DISEÑO (Unidad 2) y cuales son deuda de PROCESO (Unidad 1)?
 * ----------------------------------------------------------------------------
 */
