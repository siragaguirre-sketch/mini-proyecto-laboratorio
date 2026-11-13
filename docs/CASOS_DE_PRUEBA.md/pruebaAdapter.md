# Casos de prueba: Adapter

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que el adaptador traduzca la operación `send()` al método heredado `sendMessage()`.
- **Precondiciones:** `LegacyNotifierAdapter` implementa `Notification` y recibe un `LegacyNotifier`.
- **Datos de entrada:** Mensaje `Pedido #301 creado`.
- **Pasos:**
  1. Crear `LegacyNotifier` y envolverlo con `LegacyNotifierAdapter`.
  2. Invocar `send()` y capturar la salida.
- **Resultado esperado:** La salida es `[LEGACY] Pedido #301 creado<br>`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que el contrato del adaptador rechace mensajes que no sean cadenas.
- **Precondiciones:** El archivo de test declara `strict_types=1`.
- **Datos de entrada:** Valor entero `301` como mensaje.
- **Pasos:**
  1. Crear el adaptador.
  2. Invocar `send(301)`.
- **Resultado esperado:** PHP lanza `TypeError`.
