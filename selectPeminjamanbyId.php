<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';
include 'header.php';

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode GET
$id = isset($_GET['id']) ? $_GET['id'] : '';

try {
    // Query SQL untuk memilih data buku berdasarkan id
    $query = "SELECT pm.id, pm.tanggal_peminjaman, pm.tanggal_pengembalian, pm.status_peminjaman, a.nama AS nama_anggota, b.judul AS judul_buku
              FROM peminjaman_master pm
              JOIN anggota a ON pm.nomor_anggota = a.nomor
              JOIN peminjaman_detail pd ON pm.id = pd.id_peminjaman_master
              JOIN buku b ON pd.kode_buku = b.kode
              WHERE pm.id = :id";
    
    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);
    
    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);
    
    // Eksekusi statement
    $statement->execute();
    
    // Mendapatkan hasil seleksi
    $kategori = $statement->fetch(PDO::FETCH_ASSOC);
    
    // Mengirimkan response dengan data buku
    if ($kategori) {
        $response = [
            'status' => 'success',
            'data' => $kategori
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Data peminjaman tidak ditemukan'
        ];
    }
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memilih data kategori: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>