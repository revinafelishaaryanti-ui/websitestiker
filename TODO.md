#  TODO - Perbaikan Foto Bukti Pembayaran Custom Tidak Muncul

## Akar Masalah
- Folder `uploads/pembayaran/` tidak ada → upload lama gagal tersimpan, database hanya berisi nama file yang file fisiknya hilang.
- Data lama (id_custom 3 & 4) masih berisi nama file, bukan base64 → tidak bisa ditampilkan otomatis.

## Langkah Perbaikan

- [x] Analisis akar masalah
- [x] Edit `pembayaran_custom.php` → simpan bukti sebagai **base64 langsung di database** (tidak butuh folder)
- [x] Edit `admin/detail_costum.php` → deteksi otomatis base64 vs nama file, hanya **menampilkan foto yang dikirim user**
- [x] Verifikasi sintaks PHP (No syntax errors)
- [x] Bersihkan file sementara

## Catatan Penting
- **Upload baru** dari user → tersimpan base64 → langsung tampil di detail custom.
- **Data lama** (yang file-nya hilang) → menampilkan keterangan "File bukti pembayaran tidak ditemukan di server." karena file fisiknya memang sudah tidak ada.
- Tidak ada form upload dari sisi admin (sesuai permintaan: hanya menampilkan foto yang dikirim user).

