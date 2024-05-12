<?= $this->extend('layout/base') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">User</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card">
        <div class="card-body">
            <a href="<?= base_url('user') ?>" class="btn btn-info btn-md mb-3"><i class="fa fa-arrow-left"></i> Kembali</a>
            <?= session()->getFlashdata('error') ?>
            <?= validation_list_errors() ?>
            <form action="<?= base_url('user/update') ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="<?= $user['nama_lengkap'] ?? set_value('nama_lengkap') ?>" class="form-control" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group col-md-12">
                        <label>No Telepon</label>
                        <input type="number" name="no_hp" value="<?= $user['no_hp'] ?? set_value('no_hp') ?>" class="form-control" placeholder="081xxx">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $user['email'] ?? set_value('email') ?>" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
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