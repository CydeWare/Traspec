-- Database Schema untuk Aplikasi Manajemen Pegawai PNS
-- Menggunakan normalisasi database (3NF)

--CREATE DATABASE sistem_manajemen_pns;
--USE sistem_manajemen_pns;

-- Tabel Master Agama
CREATE TABLE agama (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_agama VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Master Unit Kerja
CREATE TABLE unit_kerja (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_unit VARCHAR(10) UNIQUE NOT NULL,
    nama_unit VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Master Golongan
CREATE TABLE golongan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_golongan VARCHAR(10) UNIQUE NOT NULL,
    nama_golongan VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Master Eselon
CREATE TABLE eselon (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kode_eselon VARCHAR(10) UNIQUE NOT NULL,
    nama_eselon VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Master Jabatan
CREATE TABLE jabatan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_jabatan VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Master Tempat
CREATE TABLE tempat (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_tempat VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Utama Pegawai
CREATE TABLE pegawai (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nip VARCHAR(18) UNIQUE NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tempat_lahir_id INT,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    alamat TEXT NOT NULL,
    tempat_tugas_id INT,
    agama_id INT NOT NULL,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tempat_lahir_id) REFERENCES tempat(id) ON DELETE SET NULL,
    FOREIGN KEY (tempat_tugas_id) REFERENCES tempat(id) ON DELETE SET NULL,
    FOREIGN KEY (agama_id) REFERENCES agama(id) ON DELETE RESTRICT
);

-- Tabel Detail Kepegawaian
CREATE TABLE detail_kepegawaian (
    id INT PRIMARY KEY AUTO_INCREMENT,
    pegawai_id INT NOT NULL,
    golongan_id INT NOT NULL,
    eselon_id INT,
    jabatan_id INT NOT NULL,
    unit_kerja_id INT NOT NULL,
    no_hp VARCHAR(15),
    npwp VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pegawai_id) REFERENCES pegawai(id) ON DELETE CASCADE,
    FOREIGN KEY (golongan_id) REFERENCES golongan(id) ON DELETE RESTRICT,
    FOREIGN KEY (eselon_id) REFERENCES eselon(id) ON DELETE SET NULL,
    FOREIGN KEY (jabatan_id) REFERENCES jabatan(id) ON DELETE RESTRICT,
    FOREIGN KEY (unit_kerja_id) REFERENCES unit_kerja(id) ON DELETE RESTRICT
);

-- Tabel Users untuk Login
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data master agama
INSERT INTO agama (nama_agama) VALUES 
('Islam'), ('Kristen'), ('Katolik'), ('Hindu'), ('Buddha'), ('Konghucu');

-- Insert data master golongan
INSERT INTO golongan (kode_golongan, nama_golongan) VALUES 
('I/a', 'Golongan I/a'), ('I/b', 'Golongan I/b'), ('I/c', 'Golongan I/c'), ('I/d', 'Golongan I/d'),
('II/a', 'Golongan II/a'), ('II/b', 'Golongan II/b'), ('II/c', 'Golongan II/c'), ('II/d', 'Golongan II/d'),
('III/a', 'Golongan III/a'), ('III/b', 'Golongan III/b'), ('III/c', 'Golongan III/c'), ('III/d', 'Golongan III/d'),
('IV/a', 'Golongan IV/a'), ('IV/b', 'Golongan IV/b'), ('IV/c', 'Golongan IV/c'), ('IV/d', 'Golongan IV/d'), ('IV/e', 'Golongan IV/e');

-- Insert data master eselon
INSERT INTO eselon (kode_eselon, nama_eselon) VALUES 
('I', 'Eselon I'), ('II', 'Eselon II'), ('III', 'Eselon III'), ('IV', 'Eselon IV'), ('V', 'Eselon V');

-- Insert sample user
INSERT INTO users (username, password, email, nama_lengkap, role) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@pns.go.id', 'Administrator', 'admin');
-- Password: password

-- Index untuk performa
CREATE INDEX idx_pegawai_nip ON pegawai(nip);
CREATE INDEX idx_pegawai_nama ON pegawai(nama);
CREATE INDEX idx_detail_unit ON detail_kepegawaian(unit_kerja_id);
CREATE INDEX idx_detail_pegawai ON detail_kepegawaian(pegawai_id);