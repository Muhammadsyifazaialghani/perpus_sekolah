<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengembalian Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }t
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #e1e8ed;
            border-radius: 8px;
            background-color: #f9fbfc;
        }
        .section-title {
            font-weight: bold;
            color: #34495e;
            margin-bottom: 15px;
            font-size: 1.1em;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: "📚";
            margin-right: 10px;
            font-size: 1.2em;
        }
        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        input:focus, select:focus, textarea:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e1e8ed;
        }
        th {
            background-color: #3498db;
            color: white;
            font-weight: 500;
        }
        tr:nth-child(even) {
            background-color: #f2f7fb;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .btn-add {
            background-color: #2ecc71;
            padding: 8px 15px;
            font-size: 14px;
        }
        .btn-add:hover {
            background-color: #27ae60;
        }
        .btn-danger {
            background-color: #e74c3c;
            padding: 6px 12px;
            font-size: 13px;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            height: 40px;
            margin: 5px 0 40px;
        }
        .note {
            font-style: italic;
            color: #7f8c8d;
            font-size: 0.9em;
            margin-top: 20px;
        }
        .required {
            color: #e74c3c;
        }
        .denda {
            background-color: #fff5f5;
            border-left: 4px solid #e74c3c;
            padding: 10px;
            margin: 10px 0;
            border-radius: 0 5px 5px 0;
        }
        .denda-label {
            font-weight: bold;
            color: #e74c3c;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-tepat {
            background-color: #d4edda;
            color: #155724;
        }
        .status-terlambat {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>FORM PENGEMBALIAN BUKU</h1>
        
        <div class="section">
            <div class="section-title">DATA PEMINJAM</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap <span class="required">*</span></label>
                    <input type="text" name="nama_peminjam" required>
                </div>
                <div class="form-group">
                    <label>No. Anggota <span class="required">*</span></label>
                    <input type="text" name="no_anggota" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>No. Telepon <span class="required">*</span></label>
                    <input type="tel" name="telepon" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">DATA PENGEMBALIAN</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Pinjam <span class="required">*</span></label>
                    <input type="date" name="tanggal_pinjam" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Jatuh Tempo <span class="required">*</span></label>
                    <input type="date" name="tanggal_jatuh_tempo" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Pengembalian <span class="required">*</span></label>
                    <input type="date" name="tanggal_kembali" required onchange="cekKeterlambatan()">
                </div>
                <div class="form-group">
                    <label>Status Pengembalian</label>
                    <div id="status_pengembalian" class="status-badge status-tepat">Tepat Waktu</div>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">DAFTAR BUKU YANG DIKEMBALIKAN</div>
            <table id="bukuTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>ISBN</th>
                        <th>Kondisi</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="judul_buku[]" required></td>
                        <td><input type="text" name="pengarang[]" required></td>
                        <td><input type="text" name="isbn[]" placeholder="ISBN/No. Katalog"></td>
                        <td>
                            <select name="kondisi[]" required>
                                <option value="">-- Pilih --</option>
                                <option value="baik">Baik</option>
                                <option value="rusak_ringan">Rusak Ringan</option>
                                <option value="rusak_berat">Rusak Berat</option>
                                <option value="hilang">Hilang</option>
                            </select>
                        </td>
                        <td><input type="text" name="keterangan[]"></td>
                        <td><button type="button" class="btn-danger" onclick="hapusBaris(this)">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn-add" onclick="tambahBaris()">+ Tambah Buku</button>
        </div>

        <div class="section">
            <div class="section-title">PERHITUNGAN DENDA</div>
            <div id="dendaSection" style="display: none;">
                <div class="denda">
                    <div class="denda-label">Informasi Denda Keterlambatan:</div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jumlah Hari Terlambat</label>
                            <input type="number" id="hari_terlambat" name="hari_terlambat" min="0" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tarif Denda per Hari (Rp)</label>
                            <input type="number" id="tarif_denda" name="tarif_denda" value="1000" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Total Denda (Rp)</label>
                            <input type="number" id="total_denda" name="total_denda" min="0" readonly>
                        </div>
                        <div class="form-group">
                            <label>Status Pembayaran</label>
                            <select name="status_pembayaran">
                                <option value="belum">Belum Dibayar</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div id="noDenda" style="display: block; color: #27ae60; font-weight: bold;">
                ✓ Tidak ada denda keterlambatan
            </div>
        </div>

        <div class="section">
            <div class="section-title">KETERANGAN TAMBAHAN</div>
            <div class="form-group">
                <label>Catatan Pengembalian</label>
                <textarea name="catatan" rows="4" placeholder="Masukkan keterangan tambahan jika diperlukan..."></textarea>
            </div>
        </div>

        <div class="signature">
            <div class="signature-box">
                <div>Petugas Perpustakaan</div>
                <div class="signature-line"></div>
                <div>(Nama & Tanda Tangan)</div>
            </div>
            <div class="signature-box">
                <div>Peminjam</div>
                <div class="signature-line"></div>
                <div>(Nama & Tanda Tangan)</div>
            </div>
        </div>

        <div class="note">
            <p><strong>Ketentuan Pengembalian:</strong></p>
            <ul>
                <li>Buku harus dikembalikan dalam kondisi baik sesuai saat dipinjam</li>
                <li>Denda keterlambatan: Rp 1.000/hari</li>
                <li>Kerusakan atau kehilangan buku akan dikenakan biaya ganti rugi sesuai harga buku</li>
                <li>Simpan bukti pengembalian ini sebagai referensi</li>
            </ul>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <button type="submit" class="btn">KIRIM FORM PENGEMBALIAN</button>
        </div>
    </div>

    <script>
        function tambahBaris() {
            const table = document.getElementById("bukuTable").getElementsByTagName('tbody')[0];
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            
            row.innerHTML = `
                <td>${rowCount + 1}</td>
                <td><input type="text" name="judul_buku[]" required></td>
                <td><input type="text" name="pengarang[]" required></td>
                <td><input type="text" name="isbn[]" placeholder="ISBN/No. Katalog"></td>
                <td>
                    <select name="kondisi[]" required>
                        <option value="">-- Pilih --</option>
                        <option value="baik">Baik</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">Rusak Berat</option>
                        <option value="hilang">Hilang</option>
                    </select>
                </td>
                <td><input type="text" name="keterangan[]"></td>
                <td><button type="button" class="btn-danger" onclick="hapusBaris(this)">Hapus</button></td>
            `;
        }

        function hapusBaris(btn) {
            const row = btn.parentNode.parentNode;
            const table = document.getElementById("bukuTable").getElementsByTagName('tbody')[0];
            
            if (table.rows.length > 1) {
                row.parentNode.removeChild(row);
                updateNomorUrut();
            } else {
                alert("Minimal harus ada satu buku!");
            }
        }

        function updateNomorUrut() {
            const table = document.getElementById("bukuTable").getElementsByTagName('tbody')[0];
            for (let i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[0].innerHTML = i + 1;
            }
        }

        function cekKeterlambatan() {
            const tanggalPinjam = new Date(document.querySelector('input[name="tanggal_pinjam"]').value);
            const tanggalJatuhTempo = new Date(document.querySelector('input[name="tanggal_jatuh_tempo"]').value);
            const tanggalKembali = new Date(document.querySelector('input[name="tanggal_kembali"]').value);
            const statusElement = document.getElementById('status_pengembalian');
            const dendaSection = document.getElementById('dendaSection');
            const noDenda = document.getElementById('noDenda');
            
            if (tanggalKembali > tanggalJatuhTempo) {
                const hariTerlambat = Math.ceil((tanggalKembali - tanggalJatuhTempo) / (1000 * 60 * 60 * 24));
                document.getElementById('hari_terlambat').value = hariTerlambat;
                
                const tarifDenda = parseInt(document.getElementById('tarif_denda').value) || 1000;
                const totalDenda = hariTerlambat * tarifDenda;
                document.getElementById('total_denda').value = totalDenda;
                
                statusElement.textContent = `Terlambat ${hariTerlambat} hari`;
                statusElement.className = 'status-badge status-terlambat';
                
                dendaSection.style.display = 'block';
                noDenda.style.display = 'none';
            } else {
                statusElement.textContent = 'Tepat Waktu';
                statusElement.className = 'status-badge status-tepat';
                
                dendaSection.style.display = 'none';
                noDenda.style.display = 'block';
            }
        }

        // Event listener untuk perubahan tarif denda
        document.getElementById('tarif_denda').addEventListener('input', function() {
            if (document.getElementById('hari_terlambat').value > 0) {
                const hariTerlambat = parseInt(document.getElementById('hari_terlambat').value);
                const tarifDenda = parseInt(this.value) || 1000;
                const totalDenda = hariTerlambat * tarifDenda;
                document.getElementById('total_denda').value = totalDenda;
            }
        });
    </script>
</body>
</html>