
# ⏰ **Time Tracker Developer Exercise**

¡Bienvenido a mi implementación del ejercicio de seguimiento de tiempo! 🎉  
Esta solución está dividida en **dos proyectos**:

- 🖥️ **Backend**: Implementado con **Symfony**.
- 🌐 **Frontend**: Construido con **Angular**.

Puedes consultar el enunciado de la prueba haciendo clic [aquí](etc/readme/statement.md)
o el archivo original [aquí](etc/readme/statement.pdf)
---

## 📚 **Estructura del README**

1. [🔍 Introducción](#-introducción)
2. [🛠️ Solución Técnica](#-solución-técnica)
3. [🚀 Preparar el Entorno](#-preparar-el-entorno)
4. [🖥️ Comandos de Terminal](#-comandos-de-terminal)
5. [🎯 Consideraciones Finales](#-consideraciones-finales)

---

## 🔍 **Introducción**

El objetivo de este proyecto es ofrecer una aplicación simple para que los usuarios puedan:
- Crear tareas, iniciar y detener su seguimiento de tiempo.
- Visualizar un resumen del tiempo dedicado a cada tarea.

---

## 🛠️ **Solución Técnica**

### 🖥️ **Backend**
El backend se ha implementado en **Symfony** y se organiza en los siguientes módulos:

1. **App**: Módulo principal para la configuración inicial y las dependencias principales.
2. **Auth**: Módulo encargado de la autenticación y gestión de usuarios (JWT incluido 🚀).
3. **Core**: Contiene la lógica compartida y componentes reutilizables del sistema.
4. **TimeRecording**: Maneja la lógica específica del seguimiento de tiempo y las tareas.

#### 📦 **Arquitectura**
- **Bundles Symfony**: Cada módulo es un bundle autocontenido, siguiendo una estructura modular.
- **DDD y CQS**:
    - Contextos delimitados claramente definidos en cada módulo.
    - Aplicación de consultas y comandos separados para mejorar la mantenibilidad.

#### ✅ **Pruebas**
Cada módulo incluye sus propias pruebas:
- 🧪 **Unitarias**: Validan funcionalidades individuales.
- 🔄 **Integración**: Comprueban la comunicación entre los módulos.
- 🌐 **End-to-End (E2E)**: Validan flujos completos de la aplicación.

### 🌐 **Frontend**
El frontend utiliza **Angular** con las siguientes características:
- **Responsividad**: Diseño adaptado a dispositivos móviles y de escritorio.
- **Integración con el Backend**: Uso de servicios HTTP para interactuar con los endpoints del backend.
- **Flujo de Usuario**:
    1. Registro / Inicio de Sesión.
    2. Gestión de tareas (crear, iniciar, detener).
    3. Resumen de tareas y tiempo.

---

## 🚀 **Preparar el Entorno**

### 🖥️ **Backend**

1. Nos movemos al backend:
   ```bash
   cd time-tracker-backend
   ```
2. Inicia el entorno Docker:
   ```bash
   make docker-db-start
   ```
3. Instala las dependencias:
   ```bash
   make first-env
   ```
4. Aplica las migraciones:
   ```bash
   make restore-env
   ```
5. Levanta el servidor de desarrollo:
   ```bash
   symfony server:start --no-tls
   ```
---

## 🖥️ **Comandos de Terminal**

El backend incluye comandos para facilitar la gestión de tareas desde la terminal:

### 🔧 **Comandos Disponibles**

1. Iniciar una tarea:
   ```bash
   php bin/console time-recording:task:register start <name> <email>
   ```  
   Inicia una nueva tarea con el nombre proporcionado.

2. Detener una tarea:
   ```bash
   php bin/console time-recording:task:register stop <name> <email>
   ```  
   Detiene la tarea en ejecución.

3. Listar tareas:
   ```bash
   php bin/console time-recording:task:list <email>
   ```  
   Muestra todas las tareas con su identificador, tiempo de inicio, fin y tiempo total transcurrido.

---

## **Archivos**

El backend incluye archivos que merece la pena dar un ojo.
1. En 'etc/postman': hay una coleccion que puedes importar para probar los endpoints que tiene el backend.
    2. Login y register no tiene segurida.
    3. El resto de endpoints es necesario que hagas una llamada al endpoint 'aut/json' y internamente se guarda el token para utilizar en las siguientes llamadas.
2. En la carpeta raiz del proyecto hay un Makefile con una bateria enorme de comandos para administrar el proyecto.
3. En el Modulo de 'Core' hay un comando de cli para hacer pruebas.

---

## **Test**
Para ejecutar los tests has de realizar estos pasos.
1. Si es la primera vez que ejecutas los test ejecuta:
    ```bash
    make init-env-test
    ```
Este comando replica la estructura de la base de datos y la inicializa con los datos minimos.
La base de datos tendra el mismo nombre de la original pero al final se le añade un prefijo "_test".
Por cada ejecucion de los test la bases de datos vuelve al estado inicial.

2. En el caso de ya tener la base de datos de test y querer que se inicialize de nuevo hay que ejecutar:
    ```bash
    make restore-env-test
    ```
3. Para ejecutar todos los test:
    ```bash
   make test-run-all 
   ```
4. Ejecutar un modulo:
    ```bash
   make test-run-auth
   make test-run-core
   make test-run-time-recordin
   ```
5. Test unitarios:
    ```bash
   make test-run-unit 
   ```
6. Test integracion:
    ```bash
   make test-run-integration 
   ```
7. Test e2e:
    ```bash
   make test-run-e2e 
   ```
---

## Docker

1. Construir los servicios:
   ```bash
   docker-compose build
   docker compose build --no-cache 
   ```
2. Levantar los servicios:
   ```bash
   docker-compose up -d
   docker compose up --pull always -d --wait
   ```
3. Ver los logs:
   ```bash
   docker-compose logs -f
   ```
4. Detener los servicios:
   ```bash
   docker-compose down
   docker compose down --remove-orphans
   ```
5. Acceder a los contenedores:
    1. Backend:
   ```bash
   docker exec -it time-tracker-backend bash
   ```
    2. Base de datos:
   ```bash
   docker exec -it time-tracker-db mysql -uuser -ppassword
   ```
    3. Frontend:
   ```bash
   docker exec -it time-tracker-frontend bash
   ```
6. Listar los contenedores activos:
   ```bash
   docker ps
   ```

Desde el directorio time-tracker-backend
1. Construir la imagen:
   ```bash
   docker build -t time-tracker-backend .
   ```
2. Ejecutar el contenedor:
   ```bash
   docker run -p 8000:9000 -v $(pwd):/var/www/html time-tracker-backend
   ```
   
---

## 🎯 **Consideraciones Finales**

- **Escalabilidad**: La estructura modular permite agregar nuevos módulos fácilmente.
- **Calidad del Código**: Aplicación de principios SOLID y separación de responsabilidades.
- **Facilidad de Uso**: Interfaz simple y comandos intuitivos.

¡Gracias por revisar esta solución! 🎉 Espero que sea de tu agrado.  
Si tienes alguna pregunta, no dudes en abrir un issue en el repositorio. 🚀










