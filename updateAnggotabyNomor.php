<?php
// Include file koneksi.php untuk mendapatkan koneksi ke database
include 'koneksi.php';
include 'header.php';

$conn = getConnection();

// Mendapatkan data yang dikirim melalui metode POST
$id = isset($_POST['id']) ? $_POST['id'] : '';
$nomor = isset($_POST['nomor']) ? $_POST['nomor'] : '';
$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
$jenis_kelamin = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
$no_hp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
$tanggal_terdaftar = isset($_POST['tanggal_terdaftar']) ? $_POST['tanggal_terdaftar'] : '';

try {
    // Query SQL untuk melakukan update data buku berdasarkan nomor
    $query = "UPDATE anggota SET id = :id, nama = :nama, jenis_kelamin = :jenis_kelamin, alamat = :alamat, no_hp = :no_hp, tanggal_terdaftar = :tanggal_terdaftar WHERE nomor = :nomor";
    
    // Mempersiapkan statement PDO untuk eksekusi query
    $statement = $conn->prepare($query);
    
    // Mengikat parameter dengan nilai yang sesuai
    $statement->bindParam(':id', $id);
    $statement->bindParam(':nama', $nama);
    $statement->bindParam(':jenis_kelamin', $jenis_kelamin);
    $statement->bindParam(':alamat', $alamat);
    $statement->bindParam(':no_hp', $no_hp);
    $statement->bindParam(':tanggal_terdaftar', $tanggal_terdaftar);
    $statement->bindParam(':nomor', $nomor);
    
    // Eksekusi statement
    $statement->execute();
    
    // Mengembalikan response sukses
    $response = [
        'status' => 'success',
        'message' => 'Data anggota berhasil diperbarui'
    ];
} catch(PDOException $e) {
    // Jika terjadi error, tampilkan pesan error
    $response = [
        'status' => 'error',
        'message' => 'Terjadi kesalahan saat memperbarui data anggota: ' . $e->getMessage()
    ];
}

// Mengirimkan response JSON
echo json_encode($response);

// Menutup koneksi
$conn = null;
?>