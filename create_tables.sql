CREATE TABLE IF NOT EXISTS administrator (
  administratorId INT AUTO_INCREMENT PRIMARY KEY,
  emailAddress VARCHAR(128) NOT NULL,
  passwordHash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS patient (
  patientId INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(128) NOT NULL,
  lastName VARCHAR(128) NOT NULL,
  gender VARCHAR(20) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(10) NOT NULL UNIQUE,
  location VARCHAR(255) NOT NULL,
  dateOfBirth TIMESTAMP NOT NULL,
  passwordHash VARCHAR(255) NOT NULL,
  SSN INT NOT NULL,
  activeStatus BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS health_center (
  healthCenterId INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  location VARCHAR(255) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS doctor (
  doctorId INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(128) NOT NULL,
  lastName VARCHAR(128) NOT NULL,
  gender VARCHAR(10) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE,
  specialization VARCHAR(128) NOT NULL,
  healthCenterId INT NOT NULL,
  SSN INT NOT NULL,
  startYear INT NOT NULL,
  activeStatus BOOLEAN DEFAULT TRUE,
  passwordHash VARCHAR(255) NOT NULL,
  FOREIGN KEY (healthCenterId) REFERENCES health_center(healthCenterId)
);

CREATE TABLE IF NOT EXISTS patient_doctor (
  patientDoctorId INT AUTO_INCREMENT PRIMARY KEY,
  patientId INT NOT NULL,
  doctorId INT NOT NULL,
  dateAssigned TIMESTAMP,
  isPrimary BOOLEAN DEFAULT TRUE,
  FOREIGN KEY (patientId) REFERENCES patient(patientId),
  FOREIGN KEY (doctorId) REFERENCES doctor(doctorId)
);

CREATE TABLE IF NOT EXISTS consultation (
  consultationID INT AUTO_INCREMENT PRIMARY KEY,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  dateScheduled TIMESTAMP NOT NULL,
  startTime TIMESTAMP NOT NULL,
  endTime TIMESTAMP NOT NULL,
  status VARCHAR(32),
  patientDoctorId INT,
  FOREIGN KEY (patientDoctorId) REFERENCES patient_doctor(patientDoctorId)
);

CREATE TABLE IF NOT EXISTS consultation_payment (
  consultationPaymentId INT AUTO_INCREMENT PRIMARY KEY,
  consultationId INT,
  amountCashed DECIMAL(10, 2) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  method VARCHAR(32) NOT NULL,
  FOREIGN KEY (consultationId) REFERENCES consultation(consultationID)
);

CREATE TABLE IF NOT EXISTS diagnosis (
  diagnosisId INT AUTO_INCREMENT PRIMARY KEY,
  consultationId INT,
  symptom VARCHAR(128) NOT NULL,
  description TEXT,
  FOREIGN KEY (consultationId) REFERENCES consultation(consultationID)
);

CREATE TABLE IF NOT EXISTS pharmacy (
  pharmacyId INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  location VARCHAR(255) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS pharmaceutical (
  pharmaceuticalId INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  location VARCHAR(255) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS contract (
  contractId INT AUTO_INCREMENT PRIMARY KEY,
  startDate TIMESTAMP NOT NULL,
  endDate TIMESTAMP NOT NULL,
  description TEXT,
  pharmacyId INT,
  pharmaceuticalId INT,
  FOREIGN KEY (pharmacyId) REFERENCES pharmacy(pharmacyId),
  FOREIGN KEY (pharmaceuticalId) REFERENCES pharmaceutical(pharmaceuticalId)
);

CREATE TABLE IF NOT EXISTS supply (
  supplyId INT AUTO_INCREMENT PRIMARY KEY,
  contractId INT,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(32),
  FOREIGN KEY (contractId) REFERENCES contract(contractId)
);

CREATE TABLE IF NOT EXISTS pharmacist (
  pharmacistId INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(128) NOT NULL,
  lastName VARCHAR(128) NOT NULL,
  gender VARCHAR(32) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE,
  passwordHash VARCHAR(255) NOT NULL,
  pharmacyId INT,
  FOREIGN KEY (pharmacyId) REFERENCES pharmacy(pharmacyId)
);

CREATE TABLE IF NOT EXISTS supervisor (
  supervisorId INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(128) NOT NULL,
  lastName VARCHAR(128) NOT NULL,
  gender VARCHAR(32) NOT NULL,
  emailAddress VARCHAR(255) NOT NULL UNIQUE,
  phoneNumber VARCHAR(20) NOT NULL UNIQUE,
  passwordHash VARCHAR(255) NOT NULL,
  pharmaceuticalId INT,
  FOREIGN KEY (pharmaceuticalId) REFERENCES pharmaceutical(pharmaceuticalId)
);

CREATE TABLE IF NOT EXISTS drug (
  drugId INT AUTO_INCREMENT PRIMARY KEY,
  tradeName VARCHAR(128) NOT NULL,
  scientificName VARCHAR(255) NOT NULL,
  formula VARCHAR(255) NOT NULL,
  form VARCHAR(128) NOT NULL,
  dateManufactured TIMESTAMP,
  expiryDate TIMESTAMP,
  supplyId INT,
  FOREIGN KEY (supplyId) REFERENCES supply(supplyId)
);

CREATE TABLE IF NOT EXISTS supply_payment (
  supplyPaymentId INT AUTO_INCREMENT PRIMARY KEY,
  supplyId INT,
  amountCashed DECIMAL(10, 2) NOT NULL,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  method VARCHAR(128) NOT NULL,
  FOREIGN KEY (supplyId) REFERENCES supply(supplyId)
);

CREATE TABLE IF NOT EXISTS prescription (
  prescriptionId INT AUTO_INCREMENT PRIMARY KEY,
  consultationId INT,
  drugId INT,
  dosage VARCHAR(32) NOT NULL,
  quantity INT NOT NULL,
  startDate TIMESTAMP,
  endDate TIMESTAMP,
  dateCreated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (consultationId) REFERENCES consultation(consultationID),
  FOREIGN KEY (drugId) REFERENCES drug(drugId)
);
