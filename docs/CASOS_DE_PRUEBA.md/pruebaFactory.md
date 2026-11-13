# Casos de prueba: Factory

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que el Factory cree una notificación por email y que esta envíe el mensaje al destinatario indicado.
- **Precondiciones:** Están cargados `NotificationFactory` y el contrato `Notification`.
- **Datos de entrada:** Tipo `email`, destino `paciente@mail.com`, mensaje `Pedido #101 confirmado`.
- **Pasos:**
  1. Crear la notificación con `NotificationFactory::create('email', 'paciente@mail.com')`.
  2. Enviar el mensaje y capturar la salida.
- **Resultado esperado:** La instancia es `EmailNotification` y la salida es `[EMAIL] paciente@mail.com: Pedido #101 confirmado`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que el Factory reconozca el tipo SMS sin distinguir mayúsculas y cree el producto correspondiente.
- **Precondiciones:** Está cargado el Factory y su implementación de SMS.
- **Datos de entrada:** Tipo `SMS`, destino `555123456`, mensaje `Pedido #103 confirmado`.
- **Pasos:**
  1. Crear la notificación con `NotificationFactory::create('SMS', '555123456')`.
  2. Enviar el mensaje y capturar la salida.
- **Resultado esperado:** La instancia es `SmsNotification` y la salida es `[SMS] 555123456: Pedido #103 confirmado`.

### CP-03
- **Identificador:** CP-03
- **Descripción:** Verifica que el Factory cree el adaptador para el sistema legado y que este delegue el envío.
- **Precondiciones:** Están cargados `LegacyNotifier` y `LegacyNotifierAdapter`.
- **Datos de entrada:** Tipo `legacy`, destino `paciente@legacy.com`, mensaje `Pedido #102 desde legado`.
- **Pasos:**
  1. Crear la notificación con `NotificationFactory::create('legacy', 'paciente@legacy.com')`.
  2. Enviar el mensaje y capturar la salida.
- **Resultado esperado:** La instancia es `LegacyNotifierAdapter` y la salida es `[LEGACY] Pedido #102 desde legado<br>`.

### CP-04
- **Identificador:** CP-04
- **Descripción:** Verifica que el Factory rechace un tipo de notificación no soportado.
- **Precondiciones:** `whatsapp` no está registrado como tipo válido.
- **Datos de entrada:** Tipo `whatsapp`, destino `555123456`.
- **Pasos:**
  1. Invocar `NotificationFactory::create('whatsapp', '555123456')`.
  2. Comprobar la excepción lanzada.
- **Resultado esperado:** Se lanza `InvalidArgumentException` con el mensaje `Tipo de notificación no soportado: whatsapp`.
