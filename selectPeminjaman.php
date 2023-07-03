<?php
include 'koneksi.php';
include 'header.php';

$connection = getConnection();

    if ($connection) {
        try {
            $statement = $connection->query("SELECT pm.id, pm.tanggal_peminjaman, pm.tanggal_pengembalian, pm.status_peminjaman, a.nama AS nama_anggota, b.judul AS judul_buku
                                            FROM peminjaman_master pm
                                            JOIN anggota a ON pm.nomor_anggota = a.nomor
                                            JOIN peminjaman_detail pd ON pm.id = pd.id_peminjaman_master
                                            JOIN buku b ON pd.kode_buku = b.kode");

            $statement->setFetchMode(PDO::FETCH_ASSOC);

            $result = $statement->fetchAll();

            echo json_encode($result, JSON_PRETTY_PRINT);
        } catch (PDOException $e) {
            echo $e;
        }
    } else {
        echo "Failed to connect to the database.";
    }
?>