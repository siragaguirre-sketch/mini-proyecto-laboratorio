## Funcionalidad 1: Conexión Única a Base de Datos (Patrón Singleton - `Connection`)

### CP-01 (Caso Positivo) - Obtención de instancia única y persistencia compartida

- **Descripción:** Verificar que múltiples llamadas a `Connection::getInstance()` retornen exactamente la misma referencia en memoria y compartan el historial de consultas ejecutadas.
- **Precondiciones:** La clase `Connection` está cargada en el entorno de ejecución.
- **Datos de entrada:** Consulta SQL de prueba `"INSERT INTO pedidos (total) VALUES (1500)"`.S
- **Pasos:**
  1. Invocar `$instancia1 = Connection::getInstance()`.
  2. Invocar `$instancia2 = Connection::getInstance()`.
  3. Verificar identidad estricta (`assertSame`) entre ambas variables.
  4. Ejecutar `$instancia1->ejecutar($sqlPrueba)` y consultar `$instancia2->consultas()`.
- **Resultado esperado:** Ambas variables apuntan al mismo objeto en memoria y la consulta registrada desde `$instancia1` aparece en `$instancia2`.

### CP-02 (Caso Negativo) - Restricción de instanciación directa y clonación

- **Descripción:** Validar que la clase impida crear nuevas instancias externas mediante `new Connection()` o duplicar la existente mediante `clone`.
- **Precondiciones:** La clase `Connection` está definida en el proyecto.
- **Datos de entrada:** Metadatos de reflexión de `Connection::class`.
- **Pasos:**
  1. Inspeccionar la visibilidad del método `__construct()` mediante `ReflectionClass`.
  2. Inspeccionar la visibilidad del método `__clone()` mediante `ReflectionClass`.
- **Resultado esperado:** Tanto `__construct()` como `__clone()` tienen visibilidad `private`, bloqueando cualquier intento externo de duplicar la conexión.
