<?= $this->extend('layout/layout_utama') ?>
<?= $this->section('content') ?>
<style>
    table, tr, th, td{
        border-collapse: collapse;
        border: 1px solid black;
    }
    table{
        width: 100%;
    }
</style>
<h1><?= $title ?></h1>
<table>
    <tr>
        <th>Judul</th>
        <th>Isi</th>
        <th>Aksi</th>
    </tr>
    <?php foreach($halaman as $data):?>
        <tr>
            <td><?= $data['halaman_judul'] ?></td>
            <td><?= $data['halaman_isi'] ?></td>
            <td>
                <a href="/halaman/edit/<?= $data['halaman_id'] ?>">Edit</a>
                <a href="/halaman/delete/<?= $data['halaman_id'] ?>">Hapus</a>
            </td>
        </tr>
    <?php endforeach ?>
</table>
<?= $this->endSection() ?>