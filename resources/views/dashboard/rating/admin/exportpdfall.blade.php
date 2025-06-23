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

    <h1>Laporan Rating Dosen</h1>
    <div class="table">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">NIPN Dosen</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Nilai</th>
                    <th scope="col">Mahasiswa Yang Memberi Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ratings as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        {{ $item->dosenpa->nama }}
                    </td>
                    <td>
                        {{ $item->dosenpa->nidn }}
                    </td>
                    <td>
                        @if ($item->rating)
                            {{ $item->rating }}
                        @else
                            Belum ada rating
                        @endif
                    </td>
                    <td>
                        @if ($item->rating)
                            @if ($item->rating == 1)
                                Sangat Kurang
                            @elseif ($item->rating == 2)
                                Kurang
                            @elseif ($item->rating == 3)
                                Cukup
                            @elseif ($item->rating == 4)
                                Baik
                            @elseif ($item->rating == 5)
                                Sangat Baik
                            @endif
                        @else
                            Belum ada penilaian
                        @endif
                    </td>
                    <td>{{ $item->mahasiswa->nama }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</body>
</html>

