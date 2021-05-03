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
    <button>Ad d Mahasiswa</button>
</a>
<a href="adddaftar.php">
    <button>Add Kriteria</button>
</a>

<?php
//Setelah bobot terbuat select semua di tabel Matrik
$sql = mysql_query("SELECT * FROM daftar");

//Lakukan Normalisasi dengan rumus pada langkah 2
//Cari Max atau min dari tiap kolom Matrik
$crMax = mysql_query("SELECT min(pendapatan) as maxK1, 
      max(ipk) as maxK2,
      max(saudara) as maxK3
   FROM daftar");
$max = mysql_fetch_array($crMax);

$tbmax1 = $max['maxK1'];
$tbmax2 = $max['maxK2'];
$tbmax3 = $max['maxK3'];

//Buat tabel untuk menampilkan hasil
echo "<H3>Matrik Awal</H3>
 <table width=500 style='border:1px; #ddd; solid; border-collapse:collapse' border=1>
  <tr>
   <td>No</td>
   <td>Nama</td>
   <td>Pendapatan</td>
   <td>IPK</td>
   <td>Jumlah Saudara</td>
   <td>jumlah poin</td>
   <td>Pendapatan</td>
   <td>IPK</td>
   <td>Jumlah Saudara</td>
   <td><strong>SAW</strong></td>
  </tr>
  ";
$no = 1;
while ($dt = mysql_fetch_array($sql)) {
    //  Normalisasi
    $nor1 = round($max['maxK1'] / $dt['pendapatan'], 2);
    $nor2 = round($dt['ipk'] / $max['maxK2'], 2);
    $nor3 = round($dt['saudara'] / $max['maxK3'], 2);
    // Hasil Akhir SAW
    $poin =  $nor1 * $bobot[0] + $nor2 * $bobot[1] + $nor3 * $bobot[2];

    $jumlah = ($dt['pendapatan']) + ($dt['ipk']) + ($dt['saudara']);
    echo "<tr>
   <td>$no</td>
   <td>" . getNama($dt['nim']) . "</td>
   <td>$dt[pendapatan]</td>
   <td>$dt[ipk]</td>
   <td>$dt[saudara]</td>
   <td>$jumlah</td>
   <td>$nor1</td>
   <td>$nor2</td>
   <td>$nor3</td>
   <td>$poin</td>
  </tr>";
    $no++;
}
echo "
<tr>
   <td colspan=2></td>
   <td><strong>$tbmax1</strong></td>
   <td><strong>$tbmax2</strong></td>
   <td><strong>$tbmax3</strong></td>
   <td></td>
   <td colspan=3><center><strong>pembobotan</strong></center></td>
   <td>Hasil</td>
 </tr>
<tr>
   <td colspan=6></td>
   <td><strong>$bobot[0]</strong></td>
   <td><strong>$bobot[1]</strong></td>
   <td><strong>$bobot[2]</strong></td>
 </tr>
";
echo "</table>";



//Proses perangkingan dengan rumus langkah 3
$sql3 = mysql_query("SELECT * FROM daftar");
//Buat tabel untuk menampilkan hasil
echo "<H3>Perangkingan</H3>
 <table width=500 style='border:1px; #ddd; solid; border-collapse:collapse' border=1>
  <tr>
   <td>no</td>
   <td>Nama</td>
   <td>SAW</td>
  </tr>
  ";

//Kita gunakan rumus (Normalisasi x bobot)
while ($dt3 = mysql_fetch_array($sql3)) {

    //  Normalisasi
    $nor1 = round($max['maxK1'] / $dt3['pendapatan'], 2);
    $nor2 = round($dt3['ipk'] / $max['maxK2'], 2);
    $nor3 = round($dt3['saudara'] / $max['maxK3'], 2);
    // Hasil Akhir SAW
    $poin =  $nor1 * $bobot[0] + $nor2 * $bobot[1] + $nor3 * $bobot[2];

    $data[] = array(
        'nama' => getNama($dt3['nim']),
        'jumlah' => $jumlah,
        'poin' => $poin
    );
}


//mengurutkan data
foreach ($data as $key => $isi) {
    $nama[$key] = $isi['nama'];
    $jlh[$key] = $isi['jumlah'];
    $poin1[$key] = $isi['poin'];
}
array_multisort($poin1, SORT_DESC, $jlh, SORT_DESC, $data);
$no = 1;
$h = "berhak mendapat beasiswa";
$juara = 1;
$hr = 1;
?>
<?php foreach ($data as $item) { ?>

    <tr>
        <?php if ($no > 1) { ?>
            <td><?php echo $no ?></td>
            <td><?php echo $item['nama'] ?></td>
            <td><?php echo $item['poin'] ?></td>
        <?php } else { ?>
            <td><strong><?php echo $no ?></strong></td>
            <td><strong><?php echo $item['nama'] ?></strong></td>
            <td><strong><?php echo $item['poin'] ?></strong></td>
        <?php } ?>
    </tr>
<?php
    $no++;
    if ($no >= 2) {
        $h = "  ";
        $juara = " ";
    } else {
        $juara++;
    }
}
echo "</table>";
?>