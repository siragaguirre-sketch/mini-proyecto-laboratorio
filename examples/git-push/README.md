# Ejemplos de push y CI

El workflow de GitHub Actions corre PHPUnit al recibir cualquier `push` o
`pull_request`. Estos ejercicios sirven para comprobar el camino verde y, de
forma opcional, observar cómo se informa un fallo.

## Ejemplo 1: push que pasa

1. Confirma que estás en la carpeta raíz del proyecto y que el árbol de trabajo
   está limpio:

   ```powershell
   git status
   ```

2. Crea una rama de prueba:

   ```powershell
   git switch -c prueba/ci-verde
   ```

3. Edita `examples/git-push/cambio-seguro.md` y agrega una línea.
4. Guarda, crea un commit y publica la rama:

   ```powershell
   git add examples/git-push/cambio-seguro.md
   git commit -m "docs: probar CI con un cambio seguro"
   git push -u origin prueba/ci-verde
   ```

5. En GitHub, abre **Actions** y revisa la ejecución `PHP CI`. Aunque el cambio
   sea documental, el workflow ejecuta toda la suite. El resultado esperado es
   verde.

## Ejemplo 2: fallo controlado y recuperación (opcional)

Hazlo solo en una rama de prueba, nunca directamente en `main`:

1. Crea una rama nueva desde una copia actualizada de `main`:

   ```powershell
   git switch main
   git pull
   git switch -c prueba/ci-fallo-controlado
   ```

2. En `tests/StrategyTest.php`, cambia temporalmente el resultado esperado de
   `700.0` a `701.0` en la prueba de obra social.
3. Ejecuta las pruebas localmente. La prueba de Strategy debe fallar:

   ```powershell
   php vendor\bin\phpunit tests
   ```

4. Publica el cambio para comprobar que GitHub Actions también marca la
   ejecución como fallida:

   ```powershell
   git add tests/StrategyTest.php
   git commit -m "test: demostrar un fallo controlado del CI"
   git push -u origin prueba/ci-fallo-controlado
   ```

5. Restaura el valor esperado a `700.0`, vuelve a ejecutar los tests y publica
   la corrección:

   ```powershell
   php vendor\bin\phpunit tests
   git add tests/StrategyTest.php
   git commit -m "test: restaurar resultado esperado"
   git push
   ```

   La nueva ejecución del workflow debe quedar verde. No integres la versión
   fallida a `main`.

Para terminar y borrar localmente una rama de práctica después de integrarla o
descartarla:

```powershell
git switch main
git branch -d prueba/ci-verde
```
