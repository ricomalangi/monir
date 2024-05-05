<?= $this->extend('layout/layout_utama') ?>
<?= $this->section('content') ?>
    <h2>Title</h2>
    <p><?= esc($text) ?></p>
    <?= view_cell('App\Libraries\Lib_halaman::info', ['txt' => $text]) ?>
<?= $this->endSection() ?>