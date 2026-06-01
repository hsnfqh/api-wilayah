<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kota/Kabupaten Indonesia</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #001d3d 0%, #003566 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 { text-align: center; color: #001d3d; }
        .subtitle { text-align: center; color: #7f8c8d; margin-bottom: 30px; }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .menu a {
            background: #003566;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
        }
        .menu a:hover { background: #001d3d; }
        .filter {
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 15px;
        }
        select, .btn-filter {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
        }
        .btn-filter {
            background: #003566;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-filter:hover { background: #001d3d; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: linear-gradient(135deg, #001d3d 0%, #003566 100%); color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { background: #003566; color: white; padding: 5px 12px; text-decoration: none; border-radius: 15px; font-size: 12px; }
        .total { text-align: right; margin-top: 20px; color: #666; }
        footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <h1> Data Kota/Kabupaten</h1>
        <div class="subtitle">Pilih provinsi untuk melihat daftar kota/kabupaten</div>
        
        <div class="menu">
            <a href="/"> Provinsi</a>
            <a href="/kota" style="background: #001d3d;"> Kota/Kabupaten</a>
            <a href="/kecamatan"> Kecamatan</a>
            <a href="/kelurahan"> Kelurahan</a>
        </div>
        
        <div class="filter">
            <form method="GET" action="/kota" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <label style="font-weight: bold;">Pilih Provinsi:</label>
                <select name="provinceId">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov['id'] }}" {{ $provinceId == $prov['id'] ? 'selected' : '' }}>
                            {{ $prov['value'] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-filter">Tampilkan Kota</button>
            </form>
        </div>
        
        @if($provinceId)
            @php
                $selectedProvince = collect($provinces)->firstWhere('id', $provinceId);
            @endphp
            <h2> Daftar Kota/Kabupaten di {{ $selectedProvince['value'] ?? '' }}</h2>
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr><th>Kode</th><th>Nama Kota/Kabupaten</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($regencies as $r)
                        <tr>
                            <td>{{ $r['id'] }}</td>
                            <td><strong>{{ $r['value'] }}</strong></td>
                            <td>
                                <a href="/kecamatan/provinsi/{{ $provinceId }}/kota/{{ $r['id'] }}" class="btn">
                                    Lihat Kecamatan
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="3" style="text-align: center;">Belum ada data, pilih provinsi dulu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="total">Total Kota: {{ count($regencies) }}</div>
        @else
            <div style="text-align: center; padding: 50px; color: #666; background: #f9f9f9; border-radius: 15px;">
                Silakan pilih provinsi untuk melihat daftar kota/kabupaten
            </div>
        @endif
        
        <footer>Sumber Data: API Wilayah Indonesia (ihsaninh/wilayah-indonesia)</footer>
    </div>
</body>
</html>
