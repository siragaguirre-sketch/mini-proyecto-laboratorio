# Casos de prueba: MVC

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que el controlador procese una entrada válida mediante el servicio y renderice la vista de pedido creado.
- **Precondiciones:** El controlador recibe `OrderService` y la vista de creación está disponible.
- **Datos de entrada:** ID `801`, paciente `Ana`, importe `1000`, tipo `obra_social`, notificación `email`, destino `ana@example.test`.
- **Pasos:**
  1. Preparar `$_GET` con los datos indicados.
  2. Ejecutar `OrderController::create()` capturando la salida.
  3. Restaurar el valor original de `$_GET`.
- **Resultado esperado:** La vista muestra `Pedido creado` y el total calculado de `700`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que el controlador muestre un mensaje de error cuando el servicio rechaza un pedido inválido.
- **Precondiciones:** El controlador tiene un servicio con validación de importe.
- **Datos de entrada:** ID `802`, paciente `Ana`, importe `0`, tipo `obra_social`, notificación `email`, destino `ana@example.test`.
- **Pasos:**
  1. Preparar `$_GET` con los datos inválidos.
  2. Ejecutar `OrderController::create()` capturando la salida.
  3. Restaurar el valor original de `$_GET`.
- **Resultado esperado:** La vista muestra `No se pudo crear el pedido` y el mensaje `Monto invalido`.
