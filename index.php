<?php
// Koneksi

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("saw") or die(mysql_error());

//Buat array bobot { C1 = 35%; C2 = 25%; C3 = 25%; dan C4 = 15%.}
$bobot = array(0.30, 0.30, 0.20, 0.20);

//Buat fungsi tampilkan nama
function getNama($id)
{
    $q = mysql_query("SELECT * FROM mahasiswa where nim = '$id'");
    $d = mysql_fetch_array($q);
    return $d['nama'];
}
echo "<button>Add Mahasiswa</button>";
echo "<button>Add Kriteria</button>";
//Setelah bobot terbuat select semua di tabel Matrik
$sql = mysql_query("SELECT * FROM daftar");

//Lakukan Normalisasi dengan rumus pada langkah 2
//Cari Max atau min dari tiap kolom Matrik
$crMax = mysql_query("SELECT min(pendapatan) as maxK1, 
      max(ipk) as maxK2,
      max(saudara) as maxK3
   FROM daftar");
$max = mysql_fetch_array($crMax);

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
    // Hasil Akhir SAW
    $poin = round(
        (($dt['pendapatan'] / $max['maxK1']) * $bobot[0]) +
            (($dt['ipk'] / $max['maxK2']) * $bobot[1]) +
            (($dt['saudara'] / $max['maxK3']) * $bobot[2])
    );
    $jumlah = ($dt['pendapatan']) + ($dt['ipk']) + ($dt['saudara']);
    echo "<tr>
   <td>$no</td>
   <td>" . getNama($dt['nim']) . "</td>
   <td>$dt[pendapatan]</td>
   <td>$dt[ipk]</td>
   <td>$dt[saudara]</td>
   <td>$jumlah</td>
   <td>" . round($dt['pendapatan'] / $max['maxK1'], 2) . "</td>
   <td>" . round($dt['ipk'] / $max['maxK2'], 2) . "</td>
   <td>" . round($dt['saudara'] / $max['maxK3'], 2) . "</td>
   <td>$poin</td>
  </tr>";
    $no++;
}
echo "</table>";



//Proses perangkingan dengan rumus langkah 3
$sql3 = mysql_query("SELECT * FROM daftar");
//Buat tabel untuk menampilkan hasil
echo "<H3>Perangkingan</H3>
 <table width=500 style='border:1px; #ddd; solid; border-collapse:collapse' border=1>
  <tr>
   <td>no</td>
   <td>Nama</td>
   <td>total poin</td>
   <td>SAW</td>
  </tr>
  ";

//Kita gunakan rumus (Normalisasi x bobot)
while ($dt3 = mysql_fetch_array($sql3)) {
    $jumlah = ($dt3['pendapatan']) + ($dt3['ipk']) + ($dt3['saudara']);
    $poin = round(
        (($dt3['pendapatan'] / $max['maxK1']) * $bobot[0]) +
            (($dt3['ipk'] / $max['maxK2']) * $bobot[1]) +
            (($dt3['saudara'] / $max['maxK3']) * $bobot[2])
    );

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

foreach ($data as $item) { ?>
    <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $item['nama'] ?></td>
        <td><?php echo $item['jumlah'] ?></td>
        <td><?php echo $item['poin'] ?></td>
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