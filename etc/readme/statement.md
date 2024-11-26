# Time Tracker Developer Exercise

## Objetivo

El objetivo es desarrollar una aplicación simple de seguimiento de tiempo donde el usuario pueda:

1. **Iniciar tareas**:
    - Escribir el nombre de la tarea en la que está trabajando y hacer clic en “Start”.
    - Ver un temporizador que muestra cuánto tiempo lleva trabajando en la tarea.

2. **Detener tareas**:
    - Hacer clic en “Stop” para detener el trabajo en la tarea (el temporizador se detiene).
    - Escribir otro nombre de tarea y hacer clic en “Start” para comenzar desde cero.

3. **Resumen**:
    - Ver un resumen del tiempo dedicado a las tareas en la misma página (o en otra, según preferencia).
    - Mostrar cuánto tiempo se ha trabajado hoy y cuánto tiempo se dedicó a cada tarea.

## Requisitos

1. **Repositorio**:
    - Subir el código a un repositorio en GitHub o Bitbucket.

2. **Contenedor**:
    - Configurar la aplicación para ejecutarse en un contenedor Docker.

3. **Framework**:
    - Usar el framework PHP de tu preferencia. Symfony es preferido y apreciado.

4. **Principios de desarrollo**:
    - Utilizar principios SOLID para un diseño limpio y mantenible.

5. **Base de datos**:
    - Usar cualquier base de datos relacional para almacenar los datos.

6. **Gestión de tareas**:
    - Las tareas deben ser identificadas por su nombre. Si se registra una tarea con el mismo nombre en diferentes momentos del día, se debe sumar el tiempo dedicado.
    - Ejemplo: Si la tarea “Desarrollo de la página principal” ocupa 2 horas por la mañana y 30 minutos por la tarde, el total al final del día debe ser 2.5 horas.

7. **Estilo y diseño**:
    - El diseño no necesita ser complejo, pero debe ser responsivo, siguiendo el enfoque "mobile-first".

8. **README**:
    - No olvidar incluir un archivo `README.md` para describir cómo configurar y usar la aplicación.

## Pistas

- No es necesario que la página sea visualmente atractiva, pero debe ser funcional y responsive.
- Prioriza la funcionalidad para móviles.

## Extensiones Opcionales

1. **Script en PHP**:
    - Escribir un script en PHP que permita:
        - Recibir por parámetro la acción (`start` / `end`) y el nombre de la tarea.
        - Devolver una lista de todas las tareas con su estado, hora de inicio, hora de finalización y tiempo total transcurrido.

---

¡Buena suerte con el desarrollo del proyecto!
