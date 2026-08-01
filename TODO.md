# TODO - Keranjang Langsung ke Checkout (Multi Produk) ✅

## Masalah
- `checkout.php` hanya mendukung 1 produk (`?id_produk=`) → dari keranjang error jika banyak item.

## Langkah Perbaikan

- [x] Analisis `keranjang.php`, `checkout.php`, `pilih_alamat.php`, `tambah_alamat.php`
- [x] Edit `checkout.php` → dukung multi-produk dari keranjang + beli langsung (id_produk)
- [x] Edit `keranjang.php` → tombol "Lanjut ke Pemesanan" langsung ke `checkout.php` (tanpa id_produk)
- [x] Edit `pilih_alamat.php` → aman dipakai dari mode keranjang (tanpa id_produk) & mode beli langsung
- [x] Edit `tambah_alamat.php` → mempertahankan `id_produk` (beli langsung) lewat GET/POST + hidden field
- [x] Edit `detail_produk.php` → redirect login memakai `checkout.php?id_produk=` (bukan `?id=`)
- [x] Edit `lengkapi_profil.php` → redirect ke `checkout.php?id_produk=` (bukan `?id=`)
- [x] Verifikasi sintaks PHP semua file (No syntax errors)
- [x] Bersihkan file sementara

## Alur yang Berjalan
1. User tambah berapapun produk ke keranjang.
2. Klik "Lanjut ke Pemesanan" → langsung ke `checkout.php` (tanpa id_produk).
3. Checkout menampilkan SEMUA produk di keranjang + total + ongkir (gratis jika ≥5 item).
4. "Buat Pesanan" → simpan ke `pesanan` + `detail_pesanan` untuk semua item, lalu keranjang dikosongkan.
5. Tetap mendukung beli langsung via `checkout.php?id_produk=...` (termasuk pilih alamat & tambah alamat).
6. `pilih_alamat.php` & `tambah_alamat.php` menangani mode keranjang (tanpa id_produk) dan mode beli langsung (dengan id_produk).

