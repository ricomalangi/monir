<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Morlis | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('adminlte/dist/css/adminlte.min.css') ?>">
    <style>
        .voice-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            /* Setara dengan modal Bootstrap */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .voice-modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 300px;
            animation: fadeIn 0.3s ease;
        }

        /* Animasi dan visual mic */
        .voice-circle {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }

        .pulse-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 0, 0, 0.3);
            animation: pulse 1.5s infinite;
        }

        .mic-icon {
            position: relative;
            background: #dc3545;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #fff;
            z-index: 2;
        }

        .voice-text {
            font-weight: bold;
            font-size: 18px;
        }

        .voice-transcript {
            font-style: italic;
            color: #333;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?= $this->include('layout/navbar') ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?= $this->include('layout/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
        <!-- /.content-wrapper -->

        <?= $this->include('layout/footer') ?>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url('adminlte/plugins/jquery/jquery.min.js') ?>"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
    <script src="<?= base_url('adminlte/plugins/chart.js/Chart.min.js') ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('adminlte/dist/js/adminlte.min.js')  ?>"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>
    <script>
        // // watt chart
        // var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')

        // var salesGraphChartData = {
        //     labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
        //     datasets: [{
        //         label: 'Digital Goods',
        //         fill: false,
        //         borderWidth: 2,
        //         lineTension: 0,
        //         spanGaps: true,
        //         borderColor: '#efefef',
        //         pointRadius: 3,
        //         pointHoverRadius: 7,
        //         pointColor: '#efefef',
        //         pointBackgroundColor: '#efefef',
        //         data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
        //     }]
        // }

        // var salesGraphChartOptions = {
        //     maintainAspectRatio: false,
        //     responsive: true,
        //     legend: {
        //         display: false
        //     },
        //     scales: {
        //         xAxes: [{
        //             ticks: {
        //                 fontColor: '#efefef'
        //             },
        //             gridLines: {
        //                 display: false,
        //                 color: '#efefef',
        //                 drawBorder: false
        //             }
        //         }],
        //         yAxes: [{
        //             ticks: {
        //                 stepSize: 5000,
        //                 fontColor: '#efefef'
        //             },
        //             gridLines: {
        //                 display: true,
        //                 color: '#efefef',
        //                 drawBorder: false
        //             }
        //         }]
        //     }
        // }

        // var chartInstance = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
        //     type: 'line',
        //     data: salesGraphChartData,
        //     options: salesGraphChartOptions
        // })
        let chartInstance

        function updateChart(bulan) {
            const tokenName = $('#csrf_token').attr('name');
            const tokenValue = $('#csrf_token').val();

            const data = {
                bulan: bulan
            };
            data[tokenName] = tokenValue;

            $.ajax({
                url: "<?= base_url('dashboard/chart-power') ?>",
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#csrf_token').val(response.csrfToken);

                    if (chartInstance) {
                        chartInstance.destroy();
                    }

                    const ctx = $('#line-chart').get(0).getContext('2d');
                    chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Daya (Kwh)',
                                fill: false,
                                borderColor: '#e06666',
                                data: response.data,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                lineTension: 0.3
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        fontColor: '#444444'
                                    },
                                    gridLines: {
                                        display: false,
                                        color: '#444444'
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        fontColor: '#444444',
                                        beginAtZero: true
                                    },
                                    gridLines: {
                                        color: '#444444'
                                    }
                                }]
                            },
                            legend: {
                                labels: {
                                    fontColor: '#444444'
                                }
                            }
                        }
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            const bulan_aktif = $('#bulan').val();
            updateChart(bulan_aktif);
        });

        $('.relay-switch').on('switchChange.bootstrapSwitch', function(event, state) {
            var checkbox = $(this);
            var id = checkbox.data('id');
            var status = state ? 1 : 0;

            var tokenName = $('#csrf_token').attr('name');
            var tokenValue = $('#csrf_token').val();

            // Siapkan body data
            var data = {
                id: id,
                status: status
            };
            data[tokenName] = tokenValue; // tambahkan token ke body POST
            // Kirim data via AJAX
            $.ajax({
                url: '/relay/update-status', // Ganti sesuai endpoint-mu
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.csrfToken) {
                        $('#csrf_token').val(response.csrfToken);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating status:', error);
                    // Bisa juga rollback checkbox jika perlu
                    checkbox.bootstrapSwitch('state', !state, true); // Balik lagi ke posisi sebelumnya
                }
            });
        });

        $('#bulan').on('change', function() {
            var bulan = $(this).val();
            var nama_bulan = $(this).find(':selected').text();
            var tokenName = $('#csrf_token').attr('name');
            var tokenValue = $('#csrf_token').val();
            var data = {
                bulan: bulan,
            };
            data[tokenName] = tokenValue;
            $.ajax({
                url: '/dashboard/total_power',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('.total-power').html(response.total_power + ' Kwh');
                        $('.bulan-tagihan').html(nama_bulan)
                        $('#csrf_token').val(response.csrfToken);

                        let total_harga = response.total_harga;
                        $('#total-harga').html('Rp ' + total_harga.toLocaleString('id-ID'));

                        $('.total-jam').html(response.total_jam + ' Jam');
                    } else {
                        alert('Gagal mengambil data');
                    }
                    if (response.csrfToken) {
                        $('#csrf_token').val(response.csrfToken);
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
            updateChart(bulan);
        });

        $('#updateHarga').on('click', function() {
            const harga = $('#harga_listrik').val();
            const kwatt = parseFloat($('.total-power').text());
            const totalJam = parseFloat($('.total-jam').text());
            var tokenName = $('#csrf_token').attr('name');
            var tokenValue = $('#csrf_token').val();
            var data = {
                harga: harga,
            };
            data[tokenName] = tokenValue;
            $.ajax({
                url: "<?= base_url('dashboard/update-harga') ?>",
                method: "POST",
                data: data,
                success: function(response) {
                    if (response.success) {
                        $('#csrf_token').val(response.csrfToken);
                        let total_harga = parseFloat(harga) * kwatt;
                        $('#total-harga').html('Rp ' + total_harga.toLocaleString('id-ID'));
                    }
                },
                error: function(xhr) {
                    alert('Gagal memperbarui harga listrik: ' + xhr.responseText);
                }
            });
        });
    </script>
    <!-- <script>
        $(document).ready(function() {
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'id-ID';
            recognition.interimResults = false;

            $('#voiceBtn').on('click', function() {
                recognition.start();
            });

            recognition.onstart = () => {
                $('#voiceBtn').html('<i class="fas fa-microphone-slash"></i> Mendengarkan...');
            };

            recognition.onend = () => {
                $('#voiceBtn').html('<i class="fas fa-microphone"></i> Voice Command');
            };

            recognition.onresult = function(event) {
                const hasil = event.results[0][0].transcript.toLowerCase().trim();
                console.log("Voice command:", hasil);

                if (hasil.includes("nyalakan ac") || hasil.includes("hidupkan ac") || hasil.includes("ac on")) {
                    ubahStatusAC(true);
                } else if (hasil.includes("matikan ac") || hasil.includes("ac off")) {
                    ubahStatusAC(false);
                } else {
                    alert("Perintah tidak dikenali: " + hasil);
                }
            };

            function ubahStatusAC(status) {
                const relayCheckbox = $('.relay-switch');
                const id = relayCheckbox.data('id');
                var tokenName = $('#csrf_token').attr('name');
                var tokenValue = $('#csrf_token').val();
                var data = {
                    status: status ? 1 : 0,
                    id: id
                };
                data[tokenName] = tokenValue;

                $.ajax({
                    url: "<?= base_url('dashboard/update-relay') ?>",
                    method: "POST",
                    data: data,
                    success: function(res) {
                        if (res.success) {
                            $('#csrf_token').val(res.csrfToken);

                            // Update tampilan switch
                            relayCheckbox.prop('checked', status).bootstrapSwitch('state', status, true);
                            alert("AC berhasil " + (status ? "dinyalakan" : "dimatikan"));
                        }
                    },
                    error: function(xhr) {
                        alert("Gagal mengubah status AC: " + xhr.responseText);
                    }
                });
            }
        });
    </script> -->
    <script>
        $(document).ready(function() {
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.lang = 'id-ID';
            recognition.interimResults = true;

            $('#voiceBtn').on('click', function() {
                $('#voice-modal').removeClass('d-none');
                $('#voice-status').text('Mendengarkan...');
                $('#voice-transcript').text('');
                recognition.start();
            });

            recognition.onstart = function() {
                $('#voice-status').text('Mendengarkan...');
            };

            recognition.onresult = function(event) {
                let interimTranscript = '';
                let finalTranscript = '';

                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    const transcript = event.results[i][0].transcript;
                    if (event.results[i].isFinal) {
                        finalTranscript += transcript;
                    } else {
                        interimTranscript += transcript;
                    }
                }

                $('#voice-transcript').text(finalTranscript || interimTranscript);

                if (finalTranscript) {
                    handleVoiceCommand(finalTranscript.toLowerCase().trim());
                    recognition.stop();
                }
            };

            recognition.onend = function() {
                $('#voice-status').text('Selesai');
                setTimeout(() => $('#voice-modal').addClass('d-none'), 1500);
            };

            function handleVoiceCommand(perintah) {
                if (perintah.includes("nyalakan ac") || perintah.includes("hidupkan ac") || perintah.includes("ac on")) {
                    ubahStatusAC(true);
                } else if (perintah.includes("matikan ac") || perintah.includes("ac off")) {
                    ubahStatusAC(false);
                } else {
                    alert("Perintah tidak dikenali: " + perintah);
                }
            }

            function ubahStatusAC(status) {
                const relayCheckbox = $('.relay-switch');
                const id = relayCheckbox.data('id');
                var tokenName = $('#csrf_token').attr('name');
                var tokenValue = $('#csrf_token').val();
                var data = {
                    status: status ? 1 : 0,
                    id: id
                };
                data[tokenName] = tokenValue;

                $.ajax({
                    url: "<?= base_url('dashboard/update-relay') ?>",
                    method: "POST",
                    data: data,
                    success: function(res) {
                        if (res.success) {
                            $('#csrf_token').val(res.csrfToken);
                            relayCheckbox.prop('checked', status).bootstrapSwitch('state', status, true);
                            $('#voice-status').text("AC berhasil " + (status ? "dinyalakan" : "dimatikan"));
                        }
                    },
                    error: function() {
                        $('#voice-status').text("Gagal mengubah status AC");
                    }
                });
            }
        });

        function updateClock() {
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            const day = days[now.getDay()];
            const date = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const time = now.toLocaleTimeString('id-ID', {
                hour12: false
            });
            const fullString = `${day}, ${date} ${month} ${year} | ${time}`;
            const clockElem = document.getElementById('realtime-clock');
            if (clockElem) {
                clockElem.textContent = fullString;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    <script>
        // Timer AC logic dengan jQuery
        $(function() {
            var $timerInput = $('#ac-timer');
            var $relayId = $timerInput.data('relay-id');
            $('#timer-minus').on('click', function() {
                var val = parseInt($timerInput.val()) || 1;
                var min = parseInt($timerInput.attr('min'));
                if (val > min) $timerInput.val(val - 1);
            });
            $('#timer-plus').on('click', function() {
                var val = parseInt($timerInput.val()) || 1;
                var max = parseInt($timerInput.attr('max'));
                if (val < max) $timerInput.val(val + 1);
            });
            $('#set-timer-btn').on('click', function() {
                var tokenName = $('#csrf_token').attr('name');
                var tokenValue = $('#csrf_token').val();
                var data = {
                    timer: $timerInput.val(),
                    relay_id: $relayId
                };
                data[tokenName] = tokenValue;
                // alert($timerInput.val())
                $.ajax({
                    url: "<?= base_url('dashboard/set-timer') ?>",
                    method: "POST",
                    data: data,
                    success: function(res) {
                        if (res.success) {
                            $('#csrf_token').val(res.csrfToken);
                            alert('Timer AC di-set selama ' + $timerInput.val() + ' menit');
                        }
                    },
                    error: function() {

                    }
                });
            });

        });
    </script>
</body>

</html>