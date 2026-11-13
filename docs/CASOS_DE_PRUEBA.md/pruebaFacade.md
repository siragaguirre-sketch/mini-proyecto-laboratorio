# Casos de prueba: Facade

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que la fachada procese un pedido válido coordinando el cálculo, guardado, notificación, eventos y reporte.
- **Precondiciones:** Las dependencias concretas del servicio están disponibles y la estrategia de obra social está configurada.
- **Datos de entrada:** ID `701`, paciente `Ana`, importe `1000.0`, tipo `obra_social`, notificación `email`, destino `ana@example.test`.
- **Pasos:**
  1. Crear `OrderService` con validador, calculador, repositorio, emisor de notificaciones, eventos y servicio de reportes.
  2. Invocar `procesarPedidoCompleto()` con los datos indicados.
  3. Comparar el reporte devuelto.
- **Resultado esperado:** Devuelve el reporte del pedido `701` con total `700`, firma digital, PDF y marca de agua.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que la fachada rechace datos inválidos antes de continuar con el procesamiento.
- **Precondiciones:** `OrderService` usa `OrderValidator`.
- **Datos de entrada:** ID `702`, paciente en blanco, importe `1000.0`, tipo `obra_social`.
- **Pasos:**
  1. Crear `OrderService` con sus dependencias.
  2. Invocar `procesarPedidoCompleto()` con el paciente en blanco.
- **Resultado esperado:** Se lanza `InvalidArgumentException` con el mensaje `Falta el paciente`.
