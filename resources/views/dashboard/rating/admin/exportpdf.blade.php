<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard </title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/"> --}}



  </head>
  <body>

    <h3 class="text-center">Rating Dosen</h3>

<div class="container-fluid">
  <div class="row">
    <div class="table">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Dosen</th>
                    <th scope="col">NIPN Dosen</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Nilai</th>
                    {{-- <th scope="col">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($dosenpa as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        {{ $item->nama }}
                    </td>
                    <td>
                        {{ $item->nidn }}
                    </td>
                    <td>
                        @if ($item->rating->count())
                            @php
                                $hasil = $item->rating->avg('rating');
                                $bulat = round($hasil);
                            @endphp
                            {{ $hasil }}
                        @else
                            Belum ada rating
                        @endif
                    </td>
                    <td>
                        @if ($item->rating->count())
                            @php
                                $hasil = $item->rating->avg('rating');
                                $bulat = round($hasil);
                            @endphp
                            @if ($bulat == 1)
                                Sangat Kurang
                            @elseif ($bulat == 2)
                                Kurang
                            @elseif ($bulat == 3)
                                Cukup
                            @elseif ($bulat == 4)
                                Baik
                            @elseif ($bulat == 5)
                                Sangat Baik
                            @endif
                        @else
                            Belum ada penilaian
                        @endif
                    </td>
                    {{-- <td>
                        @if ( $item->rating->where('mahasiswa_id', auth()->user()->mahasiswa->id)->isEmpty())
                            <button class="badge bg-warning border-0" data-bs-toggle="modal" data-bs-target="#add{{ $item->id }}"><span data-feather="edit"></span></button>
                        @else
                            <button class="badge bg-success border-0"><span data-feather="check"></span></button>
                        @endif
                    </td> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
    {{-- <script src="/js/dashboard.js"></script> --}}
    {{-- <script src="sidebars.js"></script> --}}

  </body>
</html>
