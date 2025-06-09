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
            <div class="col-lg-5 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="total-power"><?= esc($total_power) ?> W</h3>
                        <p>Total penggunaan listrik</p>
                        <select name="bulan" id="bulan" class="form-control">
                            <?php
                            $bulan = [
                                "01" => "Januari",
                                "02" => "Februari",
                                "03" => "Maret",
                                "04" => "April",
                                "05" => "Mei",
                                "06" => "Juni",
                                "07" => "Juli",
                                "08" => "Agustus",
                                "09" => "September",
                                "10" => "Oktober",
                                "11" => "November",
                                "12" => "Desember"
                            ];

                            $bulan_sekarang = date("m"); // ambil bulan sekarang dalam format dua digit

                            foreach ($bulan as $value => $nama) {
                                $selected = ($value == $bulan_sekarang) ? "selected" : "";
                                echo "<option value=\"$value\" $selected>$nama</option>";
                            }
                            ?>
                        </select>

                    </div>
                    <div class="icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3 id="total-harga">Rp <?= number_format($total_power * $harga_listrik, 0, ',', '.') ?></h3>
                        <p>Total tagihan listrik bulan <b><u><span class="bulan-tagihan"><?= esc($bulan_berjalan) ?></u></span></b></p>

                        <div class="input-group align-items-center">
                            <div class="input-group-prepend d-flex align-items-center">
                                <h5 class="mb-0 mr-2"><b>Harga Listrik</b></h5>
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" id="harga_listrik" class="form-control" value="<?= esc($harga_listrik ?? '') ?>">
                            <div class="input-group-append">
                                <button type="button" id="updateHarga" class="btn btn-info btn-flat">Update</button>
                            </div>
                        </div>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <div class="card card-warning">
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