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
     * Procesa el pedido mediante la fachada y muestra el reporte generado.
     */
    public function create(): void
    {
        $reporte = $this->orderService->procesarPedidoCompleto(
            (int) ($_GET['id'] ?? 1),
            (string) ($_GET['paciente'] ?? 'Juan Perez'),
            (float) ($_GET['monto'] ?? 15000),
            (string) ($_GET['tipo'] ?? 'obra_social'),
            (string) ($_GET['notificacion'] ?? 'email'),
            (string) ($_GET['destino'] ?? 'paciente@mail.com')
        );

        echo $reporte;
    }

    /*
     * ✅ FORMA CORRECTA:
     *
     * public function create(): void
     * {
     *     $order = new Order(
     *         (int) $_POST['id'],
     *         (string) $_POST['paciente'],
     *         (float) $_POST['monto'],
     *         (string) $_POST['tipo']
     *     );
     *
     *     $this->facade->createOrder($order);          // toda la logica, una linea
     *
     *     require __DIR__ . '/../../views/orders.php'; // la vista solo presenta
     * }
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
     * Genera un reporte aplicando los decoradores en el orden establecido.
     */
    public function report(): void
    {
        $reporte = new ReportGenerator('Pedidos del dia');
        $reporte = new DigitalSignatureDecorator($reporte);
        $reporte = new PdfReportDecorator($reporte);
        $reporte = new WatermarkDecorator($reporte);

        echo $reporte->generate();
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
