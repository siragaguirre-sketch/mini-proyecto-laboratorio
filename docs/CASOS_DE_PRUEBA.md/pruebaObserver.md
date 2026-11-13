# Casos de prueba: Observer

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que el evento notifique al observador suscrito cuando se crea un pedido.
- **Precondiciones:** El observador implementa `OrderObserver` y está suscrito a `OrderEvents`.
- **Datos de entrada:** Pedido con ID `201`, paciente `Ana`, importe `700.0` y tipo `obra_social`.
- **Pasos:**
  1. Crear el pedido y un mock de `OrderObserver`.
  2. Suscribir el observador.
  3. Ejecutar `pedidoCreado()` con el pedido.
- **Resultado esperado:** `update()` se invoca exactamente una vez con el mismo pedido.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que un observador dado de baja deje de recibir eventos.
- **Precondiciones:** El observador está suscrito antes de cancelar la suscripción.
- **Datos de entrada:** Pedido con ID `202`, paciente `Luis`, importe `500.0` y tipo `jubilado`.
- **Pasos:**
  1. Crear `OrderEvents` con el observador suscrito.
  2. Ejecutar `unsubscribe()` para ese observador.
  3. Ejecutar `pedidoCreado()` con el pedido.
- **Resultado esperado:** `update()` no se invoca.
