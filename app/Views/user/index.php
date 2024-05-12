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
            <a href="<?= base_url('user/add') ?>" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Tambah User</a>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No.Telp</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['nama_lengkap']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td><?= esc($user['no_hp']) ?></td>
                        <td>
                            <a href="<?= base_url("user/" . $user['id'] . "/edit") ?>" class="btn btn-md btn-primary">Edit</a>
                            <a href="" class="btn btn-md btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->
<?= $this->endSection() ?>