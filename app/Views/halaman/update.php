<?= $this->extend('layout/layout_utama') ?>
<?= $this->section('content') ?>
<form action="" method="POST">
    <table>
        <tr>
            <td>Judul</td>
            <td><input type="text" value="<?= $halaman_isi['halaman_judul'] ?>" name="halaman_judul"></td>
        </tr>
        <tr>
            <td>Isi Halaman</td>
            <td><input type="text" value="<?= $halaman_isi['halaman_isi'] ?>" name="halaman_isi"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="simpan" value="Simpan Data"></td>
        </tr>
    </table>
</form>
<?= $this->endSection() ?>