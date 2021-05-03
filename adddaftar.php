<html>

<head>
    <title>Aplikasi CRUD dengan PHP</title>
</head>

<body>
    <h1>Tambah Data Siswa</h1>
    <form method="post" action="proses_daftar.php">
        <table cellpadding="8">
            <tr>
                <td>Id</td>
                <td><input type="text" name="iddaftar"></td>
            </tr>
            <tr>
                <td>Tanggal Daftar</td>
                <td><input type="date" name="tgldaftar"></td>
            </tr>
            <tr>
                <td>Semester</td>
                <td><input type="text" name="semester"></td>
            </tr>
            <tr>
                <td>Tahun</td>
                <td><input type="text" name="tahun"></input></td>
            </tr>
            <tr>
                <td>Nim</td>
                <td><input type="text" name="nim"></input></td>
            </tr>
            <tr>
                <td>Pendapatan</td>
                <td><input type="text" name="pendapatan"></input></td>
            </tr>
            <tr>
                <td>IPK</td>
                <td><input type="text" name="ipk"></input></td>
            </tr>
            <tr>
                <td>Saudara</td>
                <td><input type="text" name="saudara"></input></td>
            </tr>
        </table>
        <hr>
        <input type="submit" value="Simpan">
        <a href="index.php"><input type="button" value="Batal"></a>
    </form>
</body>

</html>