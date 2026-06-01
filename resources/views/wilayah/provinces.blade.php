<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provinsi Indonesia</title>
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
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: linear-gradient(135deg, #001d3d 0%, #003566 100%); color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { background: #003566; color: white; padding: 5px 12px; text-decoration: none; border-radius: 15px; font-size: 12px; }
        .total { text-align: right; margin-top: 20px; color: #666; }
        footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #7f8c8d; }
        .search-box { width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 25px; }
    </style>
</head>
<body>
    <div class="container">
        <h1> Data Wilayah Indonesia</h1>
        <div class="subtitle">Provinsi | Kota/Kabupaten | Kecamatan | Kelurahan</div>
        
        <div class="menu">
            <a href="/" style="background: #001d3d;"> Provinsi</a>
            <a href="/kota">Kota/Kabupaten</a>
            <a href="/kecamatan"> Kecamatan</a>
            <a href="/kelurahan"> Kelurahan</a>
        </div>
        
        <h2> Daftar Provinsi</h2>
        <input type="text" id="searchInput" class="search-box" placeholder=" Cari provinsi...">
        
        <div style="overflow-x: auto;">
            <table id="provinsiTable">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Provinsi</th>
                        <th>Aksi</th>
                    </tr></thead>
                <tbody>
                    @foreach($provinces as $p)
                    <tr>
                        <td>{{ $p['id'] }}</td>
                        <td><strong>{{ $p['value'] }}</strong></td>
                        <td style="display: flex; gap: 8px;">
                            <a href="/kota/provinsi/{{ $p['id'] }}" class="btn">Lihat Kota</a>
                            <a href="{{ route('makanan-khas.index', ['provinceId' => $p['id']]) }}" class="btn">Lihat Makanan Khas</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="total">Total Provinsi: {{ count($provinces) }}</div>
        <footer>Sumber Data: API Wilayah Indonesia (ihsaninh/wilayah-indonesia)</footer>
    </div>
    
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let search = this.value.toLowerCase();
            let rows = document.querySelectorAll('#provinsiTable tbody tr');
            rows.forEach(row => {
                let name = row.cells[1].textContent.toLowerCase();
                row.style.display = name.includes(search) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
