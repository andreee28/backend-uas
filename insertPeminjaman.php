<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';
include 'header.php';

// Mendapatkan data yang dikirim melalui metode POST
$tanggal_peminjaman = isset($_POST['tanggal_peminjaman']) ? $_POST['tanggal_peminjaman'] : '';
$nomor_anggota = isset($_POST['nomor_anggota']) ? $_POST['nomor_anggota'] : '';
$tanggal_pengembalian = isset($_POST['tanggal_pengembalian']) ? $_POST['tanggal_pengembalian'] : '';
$durasi_pengembalian = isset($_POST['durasi_pengembalian']) ? $_POST['durasi_pengembalian'] : '';
$kode_buku = isset($_POST['kode_buku']) ? $_POST['kode_buku'] : '';

try {
    // Establish database connection
    $conn = getConnection();
    
    $tanggal_pengembalian = date("Y-m-d", strtotime($tanggal_pengembalian));

    // Query SQL untuk melakukan insert data buku
    $query = "INSERT INTO peminjaman_master (tanggal_peminjaman, nomor_anggota, tanggal_pengembalian) 
              VALUES (:tanggal_peminjaman, :nomor_anggota, :tanggal_pengembalian)";
    
    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);
    
    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':tanggal_peminjaman', $tanggal_peminjaman);
    $statement->bindParam(':nomor_anggota', $nomor_anggota);
    $statement->bindParam(':tanggal_pengembalian', $tanggal_pengembalian);
    
    // Eksekusi statement
    $statement->execute();

    // Mendapatkan ID terakhir yang di-generate oleh database
    $id_peminjaman_master = $conn->lastInsertId();

    $query = "INSERT INTO peminjaman_detail (id_peminjaman_master, kode_buku) 
              VALUES (:id_peminjaman_master, :kode_buku)";
    
    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);
    
    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id_peminjaman_master', $id_peminjaman_master);
    $statement->bindParam(':kode_buku', $kode_buku);
    
    // Eksekusi statement
    $statement->execute();
    
    // Mengembalikan response sukses
    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil ditambahkan'
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error' . $kode,
        'message' => 'Terjadi kesalahan saat menambahkan data peminjaman: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>