# Casos de prueba: Strategy

### CP-01
- **Identificador:** CP-01
- **Descripción:** Verifica que la estrategia particular devuelva el importe sin descuento.
- **Precondiciones:** `ParticularStrategy` implementa `PricingStrategy`.
- **Datos de entrada:** Importe `1000.0`.
- **Pasos:**
  1. Crear `PriceCalculator` con `ParticularStrategy`.
  2. Calcular el importe.
- **Resultado esperado:** El resultado es exactamente `1000.0`.

### CP-02
- **Identificador:** CP-02
- **Descripción:** Verifica que la estrategia de obra social aplique el factor de `0.7`.
- **Precondiciones:** `InsuranceStrategy` implementa `PricingStrategy`.
- **Datos de entrada:** Importe `1000.0`.
- **Pasos:**
  1. Crear `PriceCalculator` con `InsuranceStrategy`.
  2. Calcular el importe.
- **Resultado esperado:** El resultado es exactamente `700.0`.

### CP-03
- **Identificador:** CP-03
- **Descripción:** Verifica que la estrategia para jubilados aplique el factor de `0.5`.
- **Precondiciones:** `RetireeStrategy` implementa `PricingStrategy`.
- **Datos de entrada:** Importe `1000.0`.
- **Pasos:**
  1. Crear `PriceCalculator` con `RetireeStrategy`.
  2. Calcular el importe.
- **Resultado esperado:** El resultado es exactamente `500.0`.

### CP-04
- **Identificador:** CP-04
- **Descripción:** Verifica que el calculador no acepte una dependencia que no implemente `PricingStrategy`.
- **Precondiciones:** El tipo del constructor de `PriceCalculator` está declarado como `PricingStrategy`.
- **Datos de entrada:** Una instancia de `stdClass`.
- **Pasos:**
  1. Intentar crear `PriceCalculator` con `stdClass`.
  2. Comprobar la excepción lanzada.
- **Resultado esperado:** Se lanza `TypeError`.
