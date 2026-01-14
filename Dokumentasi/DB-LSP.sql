-- create database lsp;
-- use lsp;

CREATE TABLE anggota (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT NOT NULL,
    nohp VARCHAR(15) NOT NULL,
    email VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL
);

CREATE TABLE petugas (
    id VARCHAR(36) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(225) NOT NULL
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
    image VARCHAR(225) NOT NULL
);

CREATE TABLE peminjaman (
    id VARCHAR(36) PRIMARY KEY,
    login_id VARCHAR(36) NOT NULL,
    tanggal_pinjam DATETIME NOT NULL,
    tanggal_kembali DATETIME NOT NULL,
    jenis_peminjaman ENUM('pickup','delivery') NOT NULL,
    alamat_kirim TEXT NOT NULL,
    ongkir VARCHAR(150) Not Null DEFAULT 'Ditanggung penerima',
    status ENUM('dipinjam','dikembalikan','terlambat'),

    CONSTRAINT fk_login
        FOREIGN KEY (login_id) REFERENCES log_in(id)
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

INSERT INTO petugas (id, nama, username, password)
VALUES 
(UUID(), 'Admin Perpustakaan', 'admin', 'admin123');

insert into	log_in (id, username, password, petugas_id) value
(uuid(), "admin", "admin123", "b3773e15-f037-11f0-a306-005056c00001");

select * from katalog_buku;

SELECT * FROM peminjaman;



