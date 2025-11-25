<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Peraturan Desa - PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        h2 { text-align: center; margin-bottom: 15px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
        }

        .poin-box {
            margin-top: 10px;
        }

        .poin-box ol {
            margin-left: 20px;
        }
    </style>
</head>

<body>

<h2>DAFTAR PERATURAN DESA</h2>

<table>
    <thead>
        <tr>
            <th width="40">No</th>
            <th>Judul</th>
            <th width="100">Nomor</th>
            <th width="80">Tahun</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($peraturan as $p)
            <tr>
                <td>{{ $p['id'] }}</td>
                <td>{{ $p['judul'] }}</td>
                <td>{{ $p['nomor'] }}</td>
                <td>{{ $p['tahun'] }}</td>
            </tr>

            <tr>
                <td colspan="4">
                    <strong>Poin Peraturan:</strong>
                    <ol>
                        @foreach ($p['poin'] as $pp)
                            <li>{{ $pp }}</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
