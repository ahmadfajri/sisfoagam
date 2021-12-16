<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pengunjung | Pesona Agam Beragam</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('admin/assets') }}/dist/css/adminlte.min.css">
</head>
<body>
    <style>
        table > * {
            font-size: .9em;
        }
    </style>
    <div class="container-fluid">
        <table class="table table-borderless">
            <tr>
                <th class="text-center" width="20%">
                    <img src="{{ url('admin/assets') }}/bg/kab-agam.png" alt="" width="50px">
                </th>
                <th class="text-center">
                    <h6>REKAP DATA PENGUNJUNG AKOMODASI</h6>
                    <h6>DINAS PARIWISATA KAB. AGAM</h6>

                </th>
                <th class="text-center" width="20%"></th>
            </tr>
        </table>
        <hr style="margin-bottom: 3px;border:.5px solid rgb(143, 143, 143);">
        <h5 class="text-center"><u>Report Akomodasi</u> </h5>
        @php
            $total_all = 0;
        @endphp
        @foreach ($visitors as $periode_key => $periode)
            <h6>Periode : {{ date("F Y", strtotime($periode_key)) }}</h6>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Akomodasi</th>
                        <th width="20%">Jumlah Pengunjung</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $i = 1;
                    $total = 0;
                @endphp
                @foreach ($periode as $item)
                    @php
                        $total += $item->visitor ?? 0;
                    @endphp

                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item->akomodasi->nama_akomodasi }}</td>
                        <td>{{ $item->visitor ?? 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th>{{ $total ?? 0 }}</th>
                    </tr>
                </tfoot>
            </table>

            @php
                $total_all += $total;
            @endphp
        @endforeach
        <hr>
        <table class="table table-bordered">
            <tr>
                <th>
                    Total Keseluruhan
                </th>
                <th width="20%">
                    {{ $total_all ?? 0 }}
                </th>
            </tr>
        </table>
    </div>
</body>
</html>
