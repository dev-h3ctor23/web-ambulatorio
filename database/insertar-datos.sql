-- ? Insertar usuarios con datos realistas

    -- * INSERT: Insertar datos las tablas
    -- * IGNORE: Ignorar si ya existe el registro
    -- * INTO + TABLA (COLUMNAS): Insertar en la tabla y sus columnas
    -- * VALUES + (VALORES): Valores a insertar

INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (1, '82109206', 'Password1', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (2, '27331141', 'Password2', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (3, '88096934', 'Password3', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (4, '76589411', 'Password4', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (5, '45044092', 'Password5', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (6, '84294410', 'Password6', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (7, '62376187', 'Password7', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (8, '59842977', 'Password8', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (9, '24944562', 'Password9', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (10, '49983664', 'Password10', 'doctor');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (11, '26467936', 'Password11', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (12, '58337548', 'Password12', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (13, '50715738', 'Password13', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (14, '83471071', 'Password14', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (15, '70549748', 'Password15', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (16, '51144231', 'Password16', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (17, '15110809', 'Password17', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (18, '50892921', 'Password18', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (19, '99346214', 'Password19', 'paciente');
INSERT IGNORE INTO usuario (id_usuario, dni, contrasena, tipo_usuario) VALUES (20, '17010113', 'Password20', 'paciente');

-- Insertar pacientes
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (11, 'Miguel García', 'miguel_garcía@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (12, 'Carmen Martínez', 'carmen_martínez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (13, 'Juan Jiménez', 'juan_jiménez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (14, 'Carlos Pérez', 'carlos_pérez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (15, 'Elena Martínez', 'elena_martínez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (16, 'Miguel López', 'miguel_lópez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (17, 'Lucía Hernández', 'lucía_hernández@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (18, 'José Pérez', 'josé_pérez@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (19, 'Luis González', 'luis_gonzález@example.com');
INSERT IGNORE INTO paciente (id_paciente, nombre_paciente, correo_paciente) VALUES (20, 'Juan Hernández', 'juan_hernández@example.com');

-- Insertar doctores
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (1, 'Elena García', 'elena_garcía@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (2, 'Carlos López', 'carlos_lópez@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (3, 'José Jiménez', 'josé_jiménez@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (4, 'Carmen López', 'carmen_lópez@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (5, 'María González', 'maría_gonzález@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (6, 'Elena Pérez', 'elena_pérez@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (7, 'Miguel Fernández', 'miguel_fernández@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (8, 'Elena Martínez', 'elena_martínez@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (9, 'Carmen Hernández', 'carmen_hernández@example.com');
INSERT IGNORE INTO doctor (id_doctor, nombre_doctor, correo_doctor) VALUES (10, 'Luis Sánchez', 'luis_sánchez@example.com');

-- Insertar especialidades
INSERT IGNORE INTO especialidad (id_especialidad, nombre_especialidad) VALUES (1, 'Cardiología');
INSERT IGNORE INTO especialidad (id_especialidad, nombre_especialidad) VALUES (2, 'Pediatría');
INSERT IGNORE INTO especialidad (id_especialidad, nombre_especialidad) VALUES (3, 'Neurología');
INSERT IGNORE INTO especialidad (id_especialidad, nombre_especialidad) VALUES (4, 'Dermatología');
INSERT IGNORE INTO especialidad (id_especialidad, nombre_especialidad) VALUES (5, 'Ginecología');

-- Relación entre doctores y especialidades una especialidad por doctor
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (4, 1); -- Doctor 1
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (5, 2); -- Doctor 2
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (5, 3); -- Doctor 3
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (4, 4); -- Doctor 4
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (3, 5); -- Doctor 5
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (3, 6); -- Doctor 6
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (2, 7); -- Doctor 7
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (5, 8); -- Doctor 8
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (3, 9); -- Doctor 9
INSERT IGNORE INTO doctor_especialidad (id_especialidad, id_doctor) VALUES (5, 10); -- Doctor 10

-- Relación entre pacientes y médicos
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (11, 1); -- Paciente 11 asignado al Doctor 1
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (12, 2); -- Paciente 12 asignado al Doctor 2
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (13, 3); -- Paciente 13 asignado al Doctor 3
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (14, 4); -- Paciente 14 asignado al Doctor 4
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (15, 5); -- Paciente 15 asignado al Doctor 5
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (16, 6); -- Paciente 16 asignado al Doctor 6
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (17, 7); -- Paciente 17 asignado al Doctor 7
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (18, 8); -- Paciente 18 asignado al Doctor 8
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (19, 9); -- Paciente 19 asignado al Doctor 9
INSERT IGNORE INTO medico_cabecera (id_paciente, id_doctor) VALUES (20, 10); -- Paciente 20 asignado al Doctor 10
