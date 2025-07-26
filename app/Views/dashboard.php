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
        <div class="row mb-3">
            <div class="col-12 text-left">
                <button id="voiceBtn" class="btn btn-danger">
                    <i class="fas fa-microphone"></i> Voice Command
                </button>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="total-power"><?= number_format($total_power, 2) ?> Kwh</h3>
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
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 class="total-jam"><?= $total_jam ?> Jam</h3>
                        <p>Lama penggunaan listrik</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3 id="total-harga">Rp <?= $total_bayar ?></h3>
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
            <div class="col-lg-3 col-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Controlling AC</h3>
                    </div>
                    <div class="card-body text-center">
                        <input type="hidden" id="csrf_token" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                        <input type="checkbox" class="relay-switch" name="relay" data-bootstrap-switch data-off-color="danger"
                            data-id="<?= $lampu['id'] ?>" data-on-color="success" <?= $lampu['status'] ? 'checked' : '' ?>>
                        <hr>
                        <div class="timer-setting mt-3">
                            <label for="ac-timer" class="mb-2"><b>Timer AC (menit)</b></label>
                            <div class="input-group justify-content-center">
                                <button type="button" class="btn btn-outline-secondary" id="timer-minus"><i class="fas fa-minus"></i></button>
                                <input type="number" data-relay-id="<?= $lampu['id'] ?>" id="ac-timer" class="form-control text-center mx-2" value="<?= $timer_lampu ?>" min="1" max="720" style="width:80px;">
                                <button type="button" class="btn btn-outline-secondary" id="timer-plus"><i class="fas fa-plus"></i></button>
                            </div>
                            <button type="button" class="btn btn-success mt-2" id="set-timer-btn">Set Timer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary border-0">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Watt
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
    <div id="voice-modal" class="voice-modal-overlay d-none">
        <div class="voice-modal-content text-center">
            <div class="voice-circle">
                <div class="pulse-ring"></div>
                <div class="mic-icon"><i class="fas fa-microphone"></i></div>
            </div>
            <div class="voice-text mt-3" id="voice-status">Mendengarkan...</div>
            <div class="voice-transcript mt-1" id="voice-transcript"></div>
        </div>
    </div>
</section>
<!-- /.content -->
<?= $this->endSection() ?>