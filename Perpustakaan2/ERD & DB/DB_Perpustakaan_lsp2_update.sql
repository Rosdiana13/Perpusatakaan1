CREATE DATABASE perpustakaan_lsp2;
USE perpustakaan_lsp2;

CREATE TABLE anggota (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    nohp VARCHAR(15) NOT NULL,
    email VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL,
    is_aktive CHAR(2) NOT NULL DEFAULT '1',
    created_at DATETIME NULL,
    created_by VARCHAR(36) NULL,
    update_at DATETIME NULL,
    update_by VARCHAR(36) NULL
);

CREATE TABLE petugas (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    nohp VARCHAR(15) NOT NULL,
    username VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL,
    is_aktive CHAR(2) NOT NULL DEFAULT '1',
    created_at DATETIME NULL,
    created_by VARCHAR(36) NULL,
    update_at DATETIME NULL,
    update_by VARCHAR(36) NULL
);

CREATE TABLE log_in (
    id VARCHAR(36) PRIMARY KEY,
    username VARCHAR(225) NOT NULL,
    password VARCHAR(225) NOT NULL,
    anggota_id VARCHAR(36),
    petugas_id VARCHAR(36),

    CONSTRAINT fk_login_anggota 
        FOREIGN KEY (anggota_id) REFERENCES anggota(id),
    CONSTRAINT fk_login_petugas 
        FOREIGN KEY (petugas_id) REFERENCES petugas(id)
);

CREATE TABLE katalog_buku (
    id VARCHAR(36) PRIMARY KEY,
    judul VARCHAR(225) NOT NULL,
    pengarang VARCHAR(150) NOT NULL,
    penerbit VARCHAR(150) NOT NULL,
    tahun YEAR NOT NULL,
    stok INT NOT NULL DEFAULT 1,
    image VARCHAR(225) NOT NULL,
    is_aktive CHAR(2) Not Null DEFAULT '1',
    created_at DATETIME NULL,
    created_by VARCHAR(36) NULL,
    update_at DATETIME NULL,
    update_by VARCHAR(36) NULL
);

CREATE TABLE peminjaman (
    id VARCHAR(36) PRIMARY KEY,
    anggota_id VARCHAR(36) NOT NULL,
    petugas_id VARCHAR(36) NOT NULL,
    tanggal_pinjam DATETIME NOT NULL,
    tanggal_kembali DATETIME NOT NULL,
    jenis_peminjaman ENUM('pickup','delivery') NOT NULL,
    alamat_kirim TEXT NOT NULL,
    ongkir VARCHAR(150) Not Null DEFAULT 'Ditanggung penerima',
    is_aktive CHAR(2) Not Null DEFAULT '1',
    created_at DATETIME NULL,
    created_by VARCHAR(36) NULL,

    CONSTRAINT fk_peminjaman_anggota
        FOREIGN KEY (anggota_id) REFERENCES anggota(id),
    CONSTRAINT fk_peminjaman_petugas
        FOREIGN KEY (petugas_id) REFERENCES petugas(id)
);

CREATE TABLE detail_peminjaman (
    id VARCHAR(36) PRIMARY KEY,
    peminjaman_id VARCHAR(36) NOT NULL,
    katalog_buku_id VARCHAR(36) NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,

    CONSTRAINT fk_detail_peminjaman
        FOREIGN KEY (peminjaman_id) REFERENCES peminjaman(id),
    CONSTRAINT fk_detail_buku
        FOREIGN KEY (katalog_buku_id) REFERENCES katalog_buku(id)
);

select * from katalog_buku;

INSERT INTO petugas (
    id, nama, alamat, nohp, username, password
) VALUES (
    UUID(),
    'Admin Perpustakaan',
    'Kantor Perpustakaan',
    '08123456789',
    'admin',
    'admin1'
);
-- 1. Hapus foreign key
ALTER TABLE peminjaman
DROP FOREIGN KEY fk_peminjaman_petugas;

-- 2. Ganti nama kolom dan tipenya
ALTER TABLE peminjaman
CHANGE COLUMN petugas_id nama_petugas VARCHAR(100) NULL;

select * from peminjaman;

DELETE  FROM peminjaman;





