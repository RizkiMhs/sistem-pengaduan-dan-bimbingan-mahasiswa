{{-- cetak laporan --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}


</head>
<body>

    <h1>Laporan Pengaduan</h1>
    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NIM</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Nama Dosen PA</th>
                <th scope="col">Isi Pengaduan</th>
                <th scope="col">Isi Tanggapan</th>
                <th scope="col">Tanggal Masuk</th>
                <th scope="col">Tanggal Selesai</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tanggapan as $item)
            @if ($item->pengaduan->status == 'selesai')
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->pengaduan->mahasiswa->nim }}</td>
                <td>{{ $item->pengaduan->mahasiswa->nama }}</td>
                <td>{{ $item->dosenpa->nama }}</td>
                <td>{{ $item->pengaduan->isi_pengaduan }}</td>
                <td>{{ $item->isi_tanggapan }}</td>
                <td>{{ $item->pengaduan->created_at }}</td>
                <td>{{ $item->updated_at }}</td>
                <td>
                    @if ($item->pengaduan->status == 'proses')
                    <span class="badge bg-warning text-dark">{{ $item->pengaduan->status }}</span>
                    @else
                    <span class="badge bg-success">{{ $item->pengaduan->status }}</span>
                    @endif
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
    
</body>
</html>

