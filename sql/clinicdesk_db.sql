CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100) NOT NULL,

    email VARCHAR(150)
    NOT NULL UNIQUE,

    password VARCHAR(255)
    NOT NULL,

    role ENUM(
        'admin',
        'doctor',
        'patient'
    ) NOT NULL,

    phone VARCHAR(20),

    is_active TINYINT(1)
    DEFAULT 1,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP

)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


CREATE TABLE specializations (

    id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(100)
    NOT NULL UNIQUE

)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


CREATE TABLE doctors (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    specialization_id INT
    NOT NULL,

    bio TEXT,

    consultation_fee
    DECIMAL(10,2),

    available_days TEXT,

    photo VARCHAR(255),

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_doctor_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_doctor_specialization
    FOREIGN KEY (
        specialization_id
    )
    REFERENCES specializations(id)
    ON DELETE CASCADE

)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


CREATE TABLE appointments (

    id INT AUTO_INCREMENT PRIMARY KEY,

    patient_id INT NOT NULL,

    doctor_id INT NOT NULL,

    appt_date DATE NOT NULL,

    appt_time TIME NOT NULL,

    status ENUM(
        'pending',
        'confirmed',
        'completed',
        'cancelled'
    )
    DEFAULT 'pending',

    reason TEXT,

    doctor_notes TEXT,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_appt_patient
    FOREIGN KEY (patient_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_appt_doctor
    FOREIGN KEY (doctor_id)
    REFERENCES doctors(id)
    ON DELETE CASCADE

)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


CREATE TABLE prescriptions (

    id INT AUTO_INCREMENT PRIMARY KEY,

    appointment_id INT
    NOT NULL,

    diagnosis TEXT,

    medications TEXT,

    notes TEXT,

    file_path VARCHAR(255),

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_prescription_appt
    FOREIGN KEY (appointment_id)
    REFERENCES appointments(id)
    ON DELETE CASCADE

)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;


INSERT INTO specializations (name)
VALUES
('Cardiology'),
('Dermatology'),
('Neurology'),
('Orthopedics'),
('Pediatrics');


INSERT INTO users
(
    name,
    email,
    password,
    role
)
VALUES
(
    'Admin',
    'admin@clinic.local',

    '$2y$10$X9mQ3QJ8W5rR7kM2tY9fUuL4aZP8xK3jN6bV1cT5dE7fG2hH1iJ2K',

    'admin'
);


INSERT INTO users
(name, email, password, role)

VALUES
(
'Patient User',
'patient@test.com',
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
'patient'
);

INSERT INTO doctors
(name, specialty, phone)

VALUES
('Dr Ahmad', 'Cardiology', '0599999999');

CREATE TABLE logs (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    action TEXT NOT NULL,

    created_at TIMESTAMP
    DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_logs_user

    FOREIGN KEY (user_id)

    REFERENCES users(id)

    ON DELETE CASCADE
);

INSERT INTO prescriptions
(
appointment_id,
diagnosis,
medications,
notes,
file_path
)
VALUES
(
2,
'Flu',
'Panadol',
'Take twice daily',
NULL
);