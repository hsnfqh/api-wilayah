<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelurahan Indonesia</title>
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
        .menu { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; flex-wrap: wrap; }
        .menu a { background: #003566; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px; }
        .menu a:hover { background: #001d3d; }
        .filter { margin-bottom: 20px; padding: 15px; background: #f5f5f5; border-radius: 15px; }
        select, .btn-filter { padding: 10px 15px; border-radius: 10px; border: 1px solid #ddd; }
        .btn-filter { background: #003566; color: white; border: none; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: linear-gradient(135deg, #001d3d 0%, #003566 100%); color: white; }
        .total { text-align: right; margin-top: 20px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Kelurahan</h1>
        <div class="subtitle">Pilih provinsi, kota/kabupaten, dan kecamatan untuk melihat kelurahan</div>

        <div class="menu">
            <a href="/">Provinsi</a>
            <a href="/kota">Kota/Kabupaten</a>
            <a href="/kecamatan">Kecamatan</a>
            <a href="/kelurahan" style="background: #001d3d;">Kelurahan</a>
        </div>

        <div class="filter">
            <form method="GET" action="/kelurahan" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <select name="provinceId" onchange="this.form.submit()">
                    <option value="">-- Pilih Provinsi --</option>
                    @foreach($provinces as $prov)
                        <option value="{{ $prov['id'] }}" {{ $provinceId == $prov['id'] ? 'selected' : '' }}>
                            {{ $prov['value'] }}
                        </option>
                    @endforeach
                </select>
                <select name="regencyId" onchange="this.form.submit()">
                    <option value="">-- Pilih Kota/Kabupaten --</option>
                    @foreach($regencies as $regency)
                        <option value="{{ $regency['id'] }}" {{ $regencyId == $regency['id'] ? 'selected' : '' }}>
                            {{ $regency['value'] }}
                        </option>
                    @endforeach
                </select>
                <select name="districtId">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($districts as $district)
                        <option value="{{ $district['id'] }}" {{ $districtId == $district['id'] ? 'selected' : '' }}>
                            {{ $district['value'] }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn-filter">Tampilkan Kelurahan</button>
            </form>
        </div>

        @if($provinceId && $regencyId && $districtId)
            <div style="overflow-x: auto;">
                <table>
                    <thead><tr><th>Kode</th><th>Nama Kelurahan</th></tr></thead>
                    <tbody>
                        @forelse($subdistricts as $subdistrict)
                            <tr>
                                <td>{{ $subdistrict['id'] }}</td>
                                <td><strong>{{ $subdistrict['value'] }}</strong></td>
                            </tr>
                        @empty
                            <tr><td colspan="2" style="text-align: center;">Data kelurahan tidak ditemukan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="total">Total Kelurahan: {{ count($subdistricts) }}</div>
        @else
            <div style="text-align: center; padding: 40px; color: #666; background: #f9f9f9; border-radius: 15px;">
                Silakan lengkapi pilihan sampai kecamatan.
            </div>
        @endif
    </div>
</body>
</html>
