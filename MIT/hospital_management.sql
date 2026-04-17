CREATE DATABASE IF NOT EXISTS hospital_management;
USE hospital_management;

-- Drop tables if they already exist
DROP TABLE IF EXISTS appointments;
DROP TABLE IF EXISTS patients;

-- Table 1: patients
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_code VARCHAR(20) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other') DEFAULT 'Other',
    phone VARCHAR(20),
    address VARCHAR(200)
);

-- Table 2: appointments
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_name VARCHAR(100) NOT NULL,
    appointment_date DATETIME NOT NULL,
    department VARCHAR(100) NOT NULL,
    reason TEXT,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    CONSTRAINT fk_patient_appointment
        FOREIGN KEY (patient_id) REFERENCES patients(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- Sample data for patients
INSERT INTO patients (patient_code, full_name, date_of_birth, gender, phone, address) VALUES
('PT001', 'Nguyen Van An', '2001-05-12', 'Male', '0901234567', '123 Le Loi, District 1, HCMC'),
('PT002', 'Tran Thi Bich', '1999-08-21', 'Female', '0912345678', '45 Nguyen Trai, District 5, HCMC'),
('PT003', 'Le Minh Khoa', '2003-01-15', 'Male', '0923456789', '78 Hai Ba Trung, District 3, HCMC'),
('PT004', 'Pham Thu Ha', '2000-11-02', 'Female', '0934567890', '22 Vo Van Tan, District 10, HCMC'),
('PT005', 'Hoang Gia Bao', '1998-04-19', 'Male', '0945678901', '19 Dien Bien Phu, Binh Thanh, HCMC'),
('PT006', 'Doan Ngoc Lan', '2002-09-30', 'Female', '0956789012', '66 Phan Xich Long, Phu Nhuan, HCMC'),
('PT007', 'Bui Quoc Viet', '1997-07-10', 'Male', '0967890123', '12 Truong Chinh, Tan Binh, HCMC'),
('PT008', 'Vo Thanh Truc', '2004-03-25', 'Female', '0978901234', '90 Cach Mang Thang 8, District 3, HCMC'),
('PT009', 'Dang Huu Phuc', '2001-12-14', 'Male', '0989012345', '155 Hoang Van Thu, Phu Nhuan, HCMC'),
('PT010', 'Nguyen Kim Ngan', '2000-06-08', 'Female', '0990123456', '200 Nguyen Van Cu, District 5, HCMC');

-- Sample data for appointments
INSERT INTO appointments (patient_id, doctor_name, appointment_date, department, reason, status) VALUES
(1, 'Dr. Tran Minh', '2026-04-02 08:00:00', 'Cardiology', 'Chest pain checkup', 'Scheduled'),
(2, 'Dr. Le Hoa', '2026-04-02 09:30:00', 'Dermatology', 'Skin allergy consultation', 'Completed'),
(3, 'Dr. Pham Tuan', '2026-04-03 10:00:00', 'Orthopedics', 'Knee pain examination', 'Scheduled'),
(4, 'Dr. Nguyen Mai', '2026-04-03 13:30:00', 'Neurology', 'Migraine follow-up', 'Cancelled'),
(5, 'Dr. Hoang Son', '2026-04-04 08:45:00', 'General Medicine', 'Routine health check', 'Completed'),
(6, 'Dr. Tran Minh', '2026-04-04 10:15:00', 'Cardiology', 'Blood pressure monitoring', 'Scheduled'),
(7, 'Dr. Vu Linh', '2026-04-05 14:00:00', 'ENT', 'Sore throat and cough', 'Scheduled'),
(8, 'Dr. Le Hoa', '2026-04-05 15:30:00', 'Dermatology', 'Acne treatment review', 'Completed'),
(9, 'Dr. Nguyen Mai', '2026-04-06 09:00:00', 'Neurology', 'Dizziness consultation', 'Scheduled'),
(10, 'Dr. Hoang Son', '2026-04-06 11:00:00', 'General Medicine', 'Fever and fatigue', 'Completed');