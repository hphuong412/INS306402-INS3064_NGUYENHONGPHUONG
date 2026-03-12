-- Tạo database
CREATE DATABASE hospital_management;
USE hospital_management;

-- Patients
CREATE TABLE patients (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  date_of_birth DATE,
  phone VARCHAR(20)
);

-- Doctors
CREATE TABLE doctors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  specialty VARCHAR(100)
);

-- Appointments
CREATE TABLE appointments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  patient_id INT NOT NULL,
  doctor_id INT NOT NULL,
  appointment_date DATETIME,

  FOREIGN KEY (patient_id) REFERENCES patients(id),
  FOREIGN KEY (doctor_id) REFERENCES doctors(id)
);

-- Prescriptions
CREATE TABLE prescriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  appointment_id INT UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (appointment_id) 
  REFERENCES appointments(id) 
  ON DELETE CASCADE
);

-- Medicines
CREATE TABLE medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
);

-- Junction table (Prescription ↔ Medicine)
CREATE TABLE prescription_medicines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  prescription_id INT NOT NULL,
  medicine_id INT NOT NULL,
  dosage VARCHAR(80),
  frequency VARCHAR(80),

  FOREIGN KEY (prescription_id) 
  REFERENCES prescriptions(id) 
  ON DELETE CASCADE,

  FOREIGN KEY (medicine_id) 
  REFERENCES medicines(id),

  UNIQUE KEY (prescription_id, medicine_id)
);