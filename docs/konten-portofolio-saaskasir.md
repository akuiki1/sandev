# Konten portofolio — SIKASIR SaaS

Siap disalin ke panel admin nusandi.page.gd (**Admin → Projects → tambah**).
Tiap bagian di bawah memetakan satu field pada form.

Ditulis mengikuti kedalaman entri SIGAP yang sudah tayang: masalahnya konkret,
solusinya menyebut keputusan teknis, bukan janji pemasaran.

> **Kenapa perlu ditambahkan:** situs saat ini memuat lima proyek, dan versi
> multi-toko ini tidak termasuk. Yang tayang baru "Cemilan Mba Tutut" — SIKASIR
> versi satu-instalasi-satu-klien. Padahal versi SaaS-nya justru yang paling
> menunjukkan kemampuan arsitektural: isolasi multi-tenant, gerbang fitur
> berbayar, dan kasir yang tetap jalan tanpa internet.

---

## title

```
SIKASIR SaaS — Platform Kasir Multi-Toko Berlangganan
```

## slug

```
sikasir-saas
```

## summary

```
Versi multi-toko SIKASIR yang dijual sebagai layanan berlangganan: satu instalasi melayani banyak toko, dengan kasir yang tetap melayani penjualan saat internet putus.
```

## case_study

```
SIKASIR versi pertama dipasang satu instalasi untuk satu klien. Selama penggunanya baru satu toko hal itu tidak jadi masalah, tapi begitu ada toko lain yang berminat, setiap penambahan berarti hosting baru, basis data baru, dan setiap perbaikan harus dikerjakan ulang di tiap tempat. Model seperti itu tidak mungkin dijual sebagai langganan.

Masalah kedua datang dari lapangan. Warung yang menjadi pengguna pertama berjualan di lokasi yang sinyalnya naik-turun. Ketika koneksi putus di tengah antrean pembeli, kasir berbasis web berhenti total — dan berhenti berjualan adalah kerugian yang paling tidak bisa ditoleransi pemilik toko.
```

## solution

```
Satu instalasi kini melayani banyak toko sekaligus. Pemisahan datanya tidak diserahkan pada kedisiplinan penulis kueri, melainkan ditegakkan di lapisan model: sebuah trait memasang global scope yang menyaring setiap kueri ke toko yang sedang aktif dan mengisi kolom pemiliknya otomatis saat baris dibuat. Kolom itu sengaja tidak pernah dibuat fillable, supaya tidak ada celah berpindah toko lewat mass assignment. Peran kantor pusat bekerja lintas-toko lewat panelnya sendiri, terpisah dari panel pemilik toko.

Paket langganan disusun bertingkat dengan gerbang fitur yang ditegakkan di sisi server — menu yang bergembok di antarmuka hanya penanda, bukan pengaman. Masa berlaku diterjemahkan menjadi tier efektif, sehingga langganan yang lewat tanggal otomatis turun ke paket gratis tanpa perlu proses terjadwal, dan langganan seumur hidup tetap bisa diberikan tanpa perlakuan khusus.

Kasirnya berjalan sebagai PWA yang tetap melayani penjualan ketika internet putus. Penjualan yang dibuat offline masuk ke antrean di perangkat dan disinkronkan begitu koneksi kembali. Kunci idempotensinya berupa UUID yang dibuat di sisi kasir dan dijaga di dua lapis — pemeriksaan sebelum menyimpan, ditambah penangkapan pelanggaran indeks unik untuk kasus dua perangkat menyinkronkan nyaris bersamaan — sehingga satu transaksi tidak pernah memotong stok dua kali. Penjualan yang ditolak server, misalnya karena stoknya sudah berubah, ditandai sebagai konflik untuk ditinjau kasir, bukan dibuang diam-diam.
```

## features

Satu baris satu fitur:

```
Satu instalasi melayani banyak toko, dengan pemisahan data ditegakkan di lapisan model
Panel kantor pusat lintas-toko, terpisah dari panel pemilik toko
Empat peran: CEO dan superadmin di tingkat platform, admin dan kasir di tingkat toko
Registrasi mandiri untuk pemilik toko baru
Tiga tingkat langganan dengan gerbang fitur yang ditegakkan di sisi server
Tier efektif otomatis turun ke gratis saat masa langganan lewat
Kasir PWA yang tetap melayani penjualan saat internet putus
Sinkronisasi penjualan offline yang idempoten, aman dari potong stok ganda
Penjualan yang ditolak server ditandai sebagai konflik untuk ditinjau, bukan dibuang
Storefront per toko lewat slug, dengan pemesanan dan pelacakan pesanan online
Penjualan satuan, curah, dan jasa dengan tarif fee bertingkat dalam satu alur
Harga reseller, promo, dan diskon per produk
Modul produksi dengan perhitungan modal per batch
Cetak struk ke printer termal dan pembuatan barcode produk
Impor data produk massal dari berkas Excel
Laporan penjualan, stok, pelanggan, dan laba rugi
Laporan tutup toko harian terkirim otomatis lewat WhatsApp
Pesanan online telantar dibatalkan terjadwal dan stoknya dikembalikan
Token API untuk integrasi dari luar aplikasi
Autentikasi dua faktor dan login dengan passkey
```

## technologies

```
Laravel
MySQL
PHP
Inertia.js
Vue.js
TypeScript
Tailwind CSS
Reka UI
Laravel Fortify
Laravel Sanctum
Laravel Wayfinder
PWA
IndexedDB
JsBarcode
Laravel Excel
Vite
```

## github_url

```
https://github.com/akuiki1/SaaSKasir
```

## demo_url

Kosongkan dulu. Isi setelah demo tayang mengikuti `docs/DEPLOY.md` di repo
SaaSKasir — Jalur A, InfinityFree.

⚠️ Sebelum tautan demo dipasang di sini, unggah satu foto produk di demo itu dan
pastikan tampil. Ada ketidakcocokan jalur penyimpanan foto yang tercatat di
bagian "Batasan yang sudah diketahui" pada DEPLOY.md.

## status & sort_order

`Publish`, dan `sort_order` **1** — taruh paling depan. Ini karya dengan
kompleksitas arsitektur tertinggi, dan menempatkannya di urutan pertama membuat
pengunjung menilai dari puncaknya, bukan dari yang kebetulan paling lama.
Geser lima proyek lain turun satu tingkat.

---

## Yang masih harus kamu kerjakan sendiri

**Screenshot.** Bagian SCREENSHOT di halaman SIGAP tayang dalam keadaan kosong,
dan kemungkinan besar begitu juga di proyek lain. Bagi perekrut, satu tangkapan
layar berbicara lebih cepat daripada enam belas butir fitur. Tidak butuh alat
khusus — buka aplikasinya lokal, potret layar kasir, dashboard, dan laporan.

Tiga tangkapan layar SIKASIR bahkan sudah tersedia di
`C:\laragon\www\fiverr-banners\` (`shot-cashier.png`, `shot-dashboard.png`,
`shot-stock.png`) dan bisa langsung dipakai.
