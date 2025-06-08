<?= $this->extend('layout/base') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kamar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Kamar</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-body">
            <a href="<?= base_url('kamar') ?>" class="btn btn-info btn-md mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?= session()->getFlashdata('error') ?>
            <?= validation_list_errors() ?>
            <form action="<?= base_url('kamar/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $kamar['id'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Kamar</label>
                        <input type="text" name="nama_kamar" value="<?= $kamar['nama_kamar'] ?? set_value('nama_kamar') ?>" class="form-control" placeholder="Nama Kamar">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama Pengguna</label>
                        <select name="id_user" class="form-control">
                            <option value="" hidden>--pilih pengguna--</option>
                            <?php foreach($users as $user): ?>
                                <option value="<?= esc($user['id']) ?>" <?= $kamar['id_user'] === $user['id'] ? 'selected' : '' ?>><?= esc($user['nama_lengkap']) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-md btn-primary float-right">Submit</button>
            </form>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
<?= $this->endSection() ?>