<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makanan Khas Daerah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #001d3d 0%, #003566 100%); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 1000px; margin: auto; background: white; border-radius: 20px; padding: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        h1 { text-align: center; color: #001d3d; margin-bottom: 8px; }
        .subtitle { text-align: center; color: #7f8c8d; margin-bottom: 24px; }
        .menu { display: flex; justify-content: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
        .menu a { background: #003566; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px; }
        .toolbar { display: flex; gap: 10px; align-items: center; justify-content: space-between; flex-wrap: wrap; margin-bottom: 18px; }
        select, button, .btn { padding: 10px 15px; border-radius: 10px; border: 1px solid #ddd; text-decoration: none; }
        .btn-primary { background: #003566; color: white; border: none; }
        .btn-warning { background: #f39c12; color: white; border: none; }
        .btn-danger { background: #c0392b; color: white; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #003566; color: white; }
        .actions { display: flex; gap: 8px; }
        .alert { background: #e8f6ef; border: 1px solid #b7e4c7; color: #1e8449; padding: 12px; border-radius: 10px; margin-bottom: 15px; }
        .thumb { width: 110px; height: 80px; object-fit: cover; border-radius: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
<div class="container">
    <h1>CRUD Makanan Khas Daerah</h1>
    <div class="subtitle">Data makanan khas berdasarkan provinsi</div>

    <div class="menu">
        <a href="/">Kembali ke Provinsi</a>
        <a href="{{ route('makanan-khas.create', ['provinceId' => $provinceId]) }}">Tambah Data</a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('makanan-khas.index') }}" class="toolbar">
        <div style="display: flex; gap: 10px; align-items: center;">
            <label for="provinceId"><strong>Filter Provinsi:</strong></label>
            <select id="provinceId" name="provinceId">
                <option value="">Semua Provinsi</option>
                @foreach($provinces as $province)
                    <option value="{{ $province['id'] }}" {{ $provinceId == $province['id'] ? 'selected' : '' }}>
                        {{ $province['value'] }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary">Filter</button>
        </div>
    </form>

    <div style="overflow-x: auto;">
        <table>
            <thead>
            <tr>
                <th>Foto</th>
                <th>Provinsi</th>
                <th>Nama Makanan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($makananList as $makanan)
                <tr>
                    <td>
                        @if($makanan->foto_path)
                            <img class="thumb" src="{{ asset('storage/' . $makanan->foto_path) }}" alt="Foto {{ $makanan->nama_makanan }}">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $makanan->province_name }}</td>
                    <td><strong>{{ $makanan->nama_makanan }}</strong></td>
                    <td>{{ $makanan->deskripsi ?: '-' }}</td>
                    <td>
                        <div class="actions">
                            <a class="btn btn-warning" href="{{ route('makanan-khas.edit', ['makanan_khas' => $makanan->id]) }}">Edit</a>
                            <form action="{{ route('makanan-khas.destroy', ['makanan_khas' => $makanan->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center;">Belum ada data makanan khas</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
