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
            <a href="<?= base_url('kamar/add') ?>" class="btn btn-primary btn-md"><i class="fa fa-plus"></i> Tambah Kamar</a>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kamar</th>
                        <th>Pengguna</th>
                        <th>Liter</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $id = 1; foreach($kamar as $k): ?>
                    <tr>
                        <td><?= esc($id++) ?></td>
                        <td><?= esc($k['nama_kamar']) ?></td>
                        <?php if($k['nama_lengkap']): ?>
                            <td><?= esc($k['nama_lengkap']) ?></td>
                        <?php else : ?>
                            <td><span class="badge badge-warning">Belum Ada Pengguna</span></td>
                        <?php endif ?>
                        <td><?= esc($k['penggunaan_air']) ?></td>
                        <td>
                            <a href="<?= base_url("kamar/" . $k['id'] . "/edit") ?>" class="btn btn-md btn-primary">Edit</a>
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
<section class="content">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Pengaturan Harga Air</h4>
        </div>
        <div class="card-body">
            <?= session()->getFlashdata('error') ?>
            <?= validation_list_errors() ?>
            <form action="<?= base_url('harga-air') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" name="id" value="<?= $harga_air['id'] ?>">
                    <label for="harga_iar" class="col-sm-2 col-form-label">Harga Air/Liter</label>
                    <div class="col-sm-10">
                      <input type="number" name="harga_air" value="<?= $harga_air['harga_air']  ?>" class="form-control" id="harga_iar" placeholder="harga air">
                    </div>
                </div>
                <button class="btn btn-md btn-primary float-right">Update</button>
            </form>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>