# Casos de Prueba - Factory Pattern

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que el Factory crea una instancia de EmailNotification para el tipo `email` y que el mensaje se envía correctamente.
- **Precondiciones:** El archivo de Factory y la interfaz `Notification` están cargados en memoria.
- **Datos de entrada:** `type = 'email'`, `destino = 'paciente@mail.com'`, `mensaje = 'Pedido #101 confirmado'`.
- **Pasos:**
  1. Invocar `NotificationFactory::create('email', 'paciente@mail.com')`.
  2. Capturar la salida con `ob_start()`.
  3. Ejecutar `$notification->send('Pedido #101 confirmado')`.
  4. Recuperar el contenido con `ob_get_clean()`.
- **Resultado esperado:** La instancia devuelta es `EmailNotification` y la salida es `[EMAIL] paciente@mail.com: Pedido #101 confirmado`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que el Factory crea el adaptador para un sistema legado y que redirige la llamada al proveedor heredado.
- **Precondiciones:** La clase `LegacyNotifier` y el adaptador `LegacyNotifierAdapter` están cargados y el tipo de notificación es `legacy`.
- **Datos de entrada:** `type = 'legacy'`, `destino = 'paciente@legacy.com'`, `mensaje = 'Pedido #102 desde legado'`.
- **Pasos:**
  1. Invocar `NotificationFactory::create('legacy', 'paciente@legacy.com')`.
  2. Validar que la instancia devuelta sea `LegacyNotifierAdapter`.
  3. Capturar la salida con `ob_start()`.
  4. Ejecutar `$notification->send('Pedido #102 desde legado')`.
  5. Recuperar el contenido con `ob_get_clean()`.
- **Resultado esperado:** La salida es `[LEGACY] Pedido #102 desde legado<br>`.

### CP-03
- **Identificador:** CP-03
- **Descripción:** Verifica que el Factory rechaza tipos de notificación no soportados lanzando una excepción.
- **Precondiciones:** El sistema no tiene registrado el tipo de notificación solicitado.
- **Datos de entrada:** `type = 'whatsapp'`, `destino = '555123456'`.
- **Pasos:**
  1. Ejecutar `NotificationFactory::create('whatsapp', '555123456')`.
  2. Esperar una excepción del tipo `InvalidArgumentException`.
- **Resultado esperado:** Se lanza `InvalidArgumentException` con el mensaje `Tipo de notificación no soportado: whatsapp`.
