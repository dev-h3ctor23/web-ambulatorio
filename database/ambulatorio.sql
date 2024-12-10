CREATE DATABASE IF NOT EXISTS ambulatorio;
USE ambulatorio;

CREATE TABLE IF NOT EXISTS usuario (
  id_usuario INT PRIMARY KEY,
  dni VARCHAR(8),
  contrasena VARCHAR(255),
  tipo_usuario ENUM('doctor', 'paciente')
);

CREATE TABLE IF NOT EXISTS especialidad (
  id_especialidad INT PRIMARY KEY,
  nombre_especialidad VARCHAR(50)
);

CREATE TABLE IF NOT EXISTS paciente (
  id_paciente INT PRIMARY KEY,
  nombre_paciente VARCHAR(70),
  correo_paciente VARCHAR(255),
  FOREIGN KEY (id_paciente) REFERENCES usuario (id_usuario)
);

CREATE TABLE IF NOT EXISTS doctor (
  id_doctor INT PRIMARY KEY,
  nombre_doctor VARCHAR(70),
  correo_doctor VARCHAR(255),
  FOREIGN KEY (id_doctor) REFERENCES usuario (id_usuario)
);

CREATE TABLE IF NOT EXISTS doctor_especialidad (
  id_especialidad INT,
  id_doctor INT,
  PRIMARY KEY (id_especialidad, id_doctor),
  FOREIGN KEY (id_especialidad) REFERENCES especialidad (id_especialidad),
  FOREIGN KEY (id_doctor) REFERENCES doctor (id_doctor)
);

CREATE TABLE IF NOT EXISTS consulta (
  id_consulta INT PRIMARY KEY AUTO_INCREMENT,
  id_paciente INT,
  id_doctor INT,
  diagnostico VARCHAR(30),
  sintomas VARCHAR(100),
  fecha DATE,
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente),
  FOREIGN KEY (id_doctor) REFERENCES doctor (id_doctor)
);

CREATE TABLE IF NOT EXISTS paciente_medicacion (
  id_paciente INT,
  id_medicacion INT,
  cantidad INT,
  frecuencia INT,
  cronico TINYINT(1),
  numero_de_dias SMALLINT,
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente)
  
);

-- Crear la tabla medico_cabecera
CREATE TABLE IF NOT EXISTS medico_cabecera (
  id_paciente INT,
  id_doctor INT,
  PRIMARY KEY (id_paciente, id_doctor),
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente),
  FOREIGN KEY (id_doctor) REFERENCES doctor (id_doctor)
);

-- Crear la tabla medicacion
CREATE TABLE IF NOT EXISTS medicacion (
  id_medicacion INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL
);