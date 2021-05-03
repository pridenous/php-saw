<?php
// Koneksi

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("saw") or die(mysql_error());

//Buat array bobot { C1 = 35%; C2 = 25%; C3 = 25%; dan C4 = 15%.}
$bobot = array(0.50, 0.30, 0.20);

//Buat fungsi tampilkan nama
function getNama($id)
{
    $q = mysql_query("SELECT * FROM mahasiswa where nim = '$id'");
    $d = mysql_fetch_array($q);
    return $d['nama'];
}
?>
<a href="addmahasiswa.php">
    <button>Add Mahasiswa</button>
</a>
<a href="adddaftar.php">
    <button>Add Kriteria</button>
</a>

<?php
//Setelah bobot terbuat select semua di tabel Matrik
$sql = mysql_query("SELECT * FROM mahasiswa");

//Lakukan Normalisasi dengan rumus pada langkah 2
//Cari Max atau min dari tiap kolom Matrik
?>
<!-- Table Mahasiswa -->
<div>
    <H3>Mahasiswa</H3>
    <table width=500 border=1>
        <tr>
            <td>Nim</td>
            <td>Nama</td>
            <td>Alamat</td>
            <td>Telepon</td>
        </tr>
        <?php
        $no = 1;
        while ($dt = mysql_fetch_array($sql)) {

            echo "<tr>
   <td>$dt[nim]</td>
   <td>$dt[nama]</td>
   <td>$dt[alamat]</td>
   <td>$dt[telp]</td>
 
  </tr>
  ";
        }
        ?>
    </table>
    <!-- Table daftar -->
    <?php
    //Setelah bobot terbuat select semua di tabel Matrik
    $sql2 = mysql_query("SELECT * FROM daftar");

    //Lakukan Normalisasi dengan rumus pada langkah 2
    //Cari Max atau min dari tiap kolom Matrik
    ?>
    <div>
        <H3>Daftar</H3>
        <table width=500 border=1>
            <tr>
                <td>No</td>
                <td>NIM</td>
                <td>Pendapatan</td>
                <td>IPK</td>
                <td>Jumlah Saudara</td>

            </tr>
            <?php
            $no = 1;
            while ($dt = mysql_fetch_array($sql2)) {

                echo "<tr>
   <td>$no</td>
   <td>$dt[nim]</td>
   <td>$dt[pendapatan]</td>
   <td>$dt[ipk]</td>
   <td>$dt[saudara]</td>
 
  </tr>
  ";
                $no++;
            }
            ?>
        </table>
    </div>
    <a href="home.php"><button>proses saw</button></a>


    <style>
        .center {
            border: 5px solid #FFFF00;
            display: flex;
            justify-content: center;
        }
    </style>