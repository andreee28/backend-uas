<?php
// Include file connection.php untuk mendapatkan koneksi ke database
include 'koneksi.php';
include 'header.php';

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode POST
$id = isset($_POST['id']) ? $_POST['id'] : '';

try {
    // Query SQL untuk menghapus data buku berdasarkan id
    $query = "DELETE FROM peminjaman_detail WHERE id_peminjaman_master = :id";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);


    // Query SQL untuk menghapus data buku berdasarkan id
    $query = "DELETE FROM peminjaman_master WHERE id = :id";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);

    // Eksekusi statement
    $statement->execute();


    // Query SQL untuk menghapus data buku berdasarkan id
    $query = "DELETE FROM peminjaman_detail WHERE id_peminjaman_master = :id";

    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);

    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);

    // Eksekusi statement
    $statement->execute();

    // Mengembalikan response sukses
    $response = [
        'status' => 'success',
        'message' => 'Data peminjaman berhasil dihapus'
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat menghapus data peminjaman: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>