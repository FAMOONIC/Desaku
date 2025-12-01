<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kegiatan Sosial</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #444;
            padding: 6px;
        }
    </style>
</head>
<body>
    <h2>Laporan Kegiatan Sosial</h2>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>PJ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sosial as $k=>$it)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>{{ $it['nama'] }}</td>
                    <td>{{ $it['tanggal'] }}</td>
                    <td>{{ $it['lokasi'] }}</td>
                    <td>{{ $it['pj'] }}</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <strong>Deskripsi:</strong><br>{!! nl2br(e($it['deskripsi'])) !!}
                        @if(!empty($it['file']))
                            <br><strong>Lampiran:</strong> {{ $it['file'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>