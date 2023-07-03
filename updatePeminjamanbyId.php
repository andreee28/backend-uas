<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';
include 'header.php';

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode POST
$id = isset($_POST['id']) ? $_POST['id'] : '';
$status_peminjaman = isset($_POST['status_peminjaman']) ? $_POST['status_peminjaman'] : '';

try {
    // $status_peminjaman = 'DIKEMBALIKAN';
    // Query SQL untuk memperbarui data peminjaman_master berdasarkan kode
    $query = "UPDATE peminjaman_master SET status_peminjaman = :status_peminjaman WHERE id = :id";
    
    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);
    
    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);
    $statement->bindParam(':status_peminjaman', $status_peminjaman);
    
    // Eksekusi statement
    $statement->execute();
    
    // Mengirimkan response dalam format JSON
    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil diperbarui'
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memperbarui data peminjaman: ' . $e->getMessage()
    ];
}

// Mengirimkan response dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>