# Gestión de Ambulatorio 🚑

Este proyecto tiene como objetivo modernizar la gestión de consultas médicas en el ambulatorio del municipio de **Quintanilla del Matojo**. A través de un portal web, los pacientes y médicos podrán acceder y gestionar sus interacciones de forma sencilla, eficiente y centralizada. 📋💻

## Funcionalidades 🛠️

### Para Pacientes 👩‍⚕️👨‍⚕️
- Visualizar información personal y médica. 🩺
- Consultar citas próximas (ID, médico y fecha). 📅
- Acceder a la medicación actual y su posología. 💊
- Revisar consultas pasadas y, si aplica, descargar archivos PDF asociados. 📄
- Solicitar nuevas citas con médicos tratantes:
  - Selección de médico y especialidad.
  - Elección de fecha con validaciones inteligentes (días laborables, máximo 30 días en el futuro). ✅
  - Descripción opcional de sintomatología. ✍️

### Para Médicos 🧑‍⚕️👩‍⚕️
- Visualizar información personal (nombre, especialidad). 🔍
- Ver el número de consultas programadas en la semana. 📈
- Consultar citas del día con detalles básicos (paciente y extracto de síntomas). 🗓️
- Realizar consultas:
  - Editar síntomas y registrar diagnóstico. 🖊️
  - Prescribir medicación con opciones detalladas (frecuencia, duración, medicación crónica). ⚕️
  - Subir documentos (recetas, menús, etc.). 📤
  - Derivar al paciente a un especialista con una cita programada. 🏥

### Página de Consulta 🚪
- Información fija de la consulta (médico, paciente, fecha). 🧾
- Edición de síntomas, diagnóstico y medicación. 💬
- Registro de la consulta en el sistema. 📋

---

## Estructura del Proyecto 📂

El proyecto está compuesto por varios archivos PHP y JavaScript que manejan diferentes aspectos de la aplicación. A continuación, se describen las funciones y responsabilidades de cada archivo:

### Archivos PHP
#### `redireccion.php`
- **Función:** Maneja la autenticación de usuarios y redirige a sus respectivas páginas (médico o paciente).
- **Flujo:**
  1. Verifica la solicitud de tipo `POST`.
  2. Obtiene el DNI y la contraseña del formulario.
  3. Consulta la base de datos para determinar el tipo de usuario.
  4. Redirige según el rol: médico o paciente.
  5. Si no es válido, redirige a la página de inicio con un mensaje de error.

#### `obtener-consultas.php`
- **Función:** Recupera las próximas consultas de un paciente.
- **Flujo:**
  1. Verifica la conexión a la base de datos.
  2. Obtiene el ID del paciente desde la URL.
  3. Ejecuta una consulta SQL y devuelve los resultados en formato JSON.

#### `obtener-consultas-pasadas.php`
- Similar a `obtener-consultas.php`, pero obtiene consultas históricas.

#### `obtener-consultas-hoy.php`
- **Función:** Recupera las consultas de hoy para un médico.
- **Flujo:**
  1. Obtiene el ID del médico desde la URL.
  2. Ejecuta una consulta SQL para las consultas del día y las devuelve en JSON.

#### `guardar-consulta.php`
- **Función:** Guarda una nueva consulta en la base de datos.
- **Flujo:**
  1. Recoge datos del formulario.
  2. Inserta una nueva entrada en la tabla de consultas.
  3. Devuelve un mensaje de éxito en JSON.

#### Otros archivos PHP:
- `datos-paciente.php`: Obtiene datos de un paciente.
- `datos-medico.php`: Obtiene datos de un médico y sus consultas del día.
- `actualizar-consulta.php`: Actualiza el diagnóstico de una consulta.
- `actualizar-consulta-especialista.php`: Actualiza al especialista y fecha de una consulta.

---

### Archivos JavaScript
#### `datos-consulta.js`
- **Función:** Maneja la obtención y actualización de datos de una consulta.
- **Flujo:**
  1. Obtiene datos de la consulta mediante `fetch`.
  2. Llena los formularios con los datos recuperados.
  3. Envía datos actualizados al servidor al guardar cambios.

#### `validaciones-paciente.js`
- **Función:** Valida los campos del formulario de paciente.
- **Flujo:**
  1. Añade validaciones en eventos `blur` de los campos.
  2. Valida fechas y campos de texto para asegurar datos correctos.

---

## Instalación 🚀
1. Clona este repositorio:
   ```bash
   git clone https://github.com/usuario/proyecto-ambulatorio.git
