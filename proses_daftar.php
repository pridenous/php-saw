<?php
// Load file koneksi.php
include "koneksi.php";
// Ambil Data yang Dikirim dari Form
$iddaftar = $_POST['iddaftar'];
$tgldaftar = $_POST['tgldaftar'];
$semester = $_POST['semester'];
$tahun = $_POST['tahun'];
$nim = $_POST['nim'];
$pendapatan = $_POST['pendapatan'];
$ipk = $_POST['ipk'];
$saudara = $_POST['saudara'];
// Proses simpan ke Database
$sql = $pdo->prepare("INSERT INTO daftar(iddaftar, tgldaftar, semester,tahun,nim,pendapatan,ipk,saudara) VALUES(:iddaftar,:tgldaftar,:semester,:tahun,:nim,:pendapatan,:ipk,:saudara)");
$sql->bindParam(':iddaftar', $iddaftar);
$sql->bindParam(':tgldaftar', $tgldaftar);
$sql->bindParam(':semester', $semester);
$sql->bindParam(':tahun', $tahun);
$sql->bindParam(':nim', $nim);
$sql->bindParam(':pendapatan', $pendapatan);
$sql->bindParam(':ipk', $ipk);
$sql->bindParam(':saudara', $saudara);
$sql->execute(); // Eksekusi query insert
if ($sql) { // Cek jika proses simpan ke database sukses atau tidak
    // Jika Sukses, Lakukan :
    header("location: index.php"); // Redirect ke halaman index.php
} else {
    // Jika Gagal, Lakukan :
    echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
    echo "<br><a href='form_simpan.php'>Kembali Ke Form</a>";
}
