<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Makanan Khas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #001d3d 0%, #003566 100%); min-height: 100vh; padding: 40px 20px; }
        .container { max-width: 700px; margin: auto; background: white; border-radius: 20px; padding: 30px; }
        h1 { color: #001d3d; margin-bottom: 20px; }
        .field { margin-bottom: 15px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 10px; }
        textarea { min-height: 120px; }
        .actions { display: flex; gap: 10px; margin-top: 20px; }
        .btn { padding: 10px 16px; border-radius: 10px; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #003566; color: white; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .error { color: #b91c1c; font-size: 14px; margin-top: 4px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Makanan Khas</h1>

    <form action="{{ route('makanan-khas.update', ['makanan_khas' => $makananKhas->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="field">
            <label for="province_id">Provinsi</label>
            <select name="province_id" id="province_id" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinces as $province)
                    <option value="{{ $province['id'] }}" {{ old('province_id', $makananKhas->province_id) == $province['id'] ? 'selected' : '' }}>
                        {{ $province['value'] }}
                    </option>
                @endforeach
            </select>
            @error('province_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="nama_makanan">Nama Makanan</label>
            <input type="text" id="nama_makanan" name="nama_makanan" value="{{ old('nama_makanan', $makananKhas->nama_makanan) }}" maxlength="100" required>
            @error('nama_makanan') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="deskripsi">Deskripsi (opsional)</label>
            <textarea id="deskripsi" name="deskripsi" maxlength="1000">{{ old('deskripsi', $makananKhas->deskripsi) }}</textarea>
            @error('deskripsi') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="foto">Foto Masakan (opsional, max 2MB)</label>
            @if($makananKhas->foto_path)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $makananKhas->foto_path) }}" alt="Foto {{ $makananKhas->nama_makanan }}" style="width: 160px; height: 120px; object-fit: cover; border-radius: 10px;">
                </div>
            @endif
            <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            @error('foto') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('makanan-khas.index', ['provinceId' => old('province_id', $makananKhas->province_id)]) }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
