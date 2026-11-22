USE warehouse_1;

CREATE TABLE barang (
	id_barang INT NOT NULL PRIMARY KEY,
	nama_barang VARCHAR (100) null,
	kategory VARCHAR (100) null,
	stok INT NULL,
	satuan VARCHAR (100) null
) ENGINE = INNODB;