# Casos de prueba: Decorator

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que los decoradores se puedan encadenar y agregar sus elementos al reporte.
- **Precondiciones:** El reporte base y los tres decoradores implementan `Report`.
- **Datos de entrada:** Contenido `Pedidos del dia`.
- **Pasos:**
  1. Crear `ReportGenerator` con el contenido indicado.
  2. Envolverlo, en orden, con `DigitalSignatureDecorator`, `PdfReportDecorator` y `WatermarkDecorator`.
  3. Ejecutar `generate()`.
- **Resultado esperado:** El resultado es `Reporte: Pedidos del dia + firma digital + PDF + marca de agua`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que un decorador no acepte un componente ajeno al contrato `Report`.
- **Precondiciones:** El constructor de `PdfReportDecorator` requiere `Report`.
- **Datos de entrada:** Una instancia de `stdClass`.
- **Pasos:**
  1. Intentar construir `PdfReportDecorator` con `stdClass`.
  2. Comprobar la excepción lanzada.
- **Resultado esperado:** Se lanza `TypeError`.
