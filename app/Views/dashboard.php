<?= $this->extend('layout/base') ?>
<?= $this->section('content') ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="#">Dashboard</a></li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= esc('2') ?>w</h3>

                        <p>Total penggunaan listrik</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Controlling AC</h3>
                    </div>
                    <div class="card-body text-center">
                        <input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <input type="checkbox" class="relay-switch" name="relay" data-bootstrap-switch data-off-color="danger"
                            data-id="<?= $lampu['id'] ?>" data-on-color="success" <?= $lampu['status'] ? 'checked' : '' ?>>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-info">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            <i class="fas fa-th mr-1"></i>
                            Sales Graph
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas class="chart" id="line-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>