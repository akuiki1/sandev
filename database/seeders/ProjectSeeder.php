<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the portfolio projects shown on the landing page.
     */
    public function run(): void
    {
        foreach ($this->projects() as $project) {
            Project::query()->updateOrCreate(['slug' => $project['slug']], $project);
        }
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function projects(): array
    {
        return [
            [
                'title' => 'SIKASIR',
                'slug' => 'sikasir',
                'summary' => 'Aplikasi Point of Sale untuk UMKM: kelola produk, transaksi, dan laporan penjualan harian.',
                'case_study' => 'Banyak UMKM masih mencatat transaksi secara manual sehingga rekap penjualan lambat dan rawan selisih. Pemilik toko membutuhkan alat kasir sederhana yang bisa langsung dipakai tanpa pelatihan panjang.',
                'solution' => 'Membangun POS berbasis web dengan alur transaksi cepat, pencarian produk instan, dan cetak struk. Laporan penjualan terekap otomatis per hari dan per bulan sehingga pemilik dapat memantau omzet secara real-time.',
                'features' => ['Manajemen produk dan stok', 'Transaksi kasir dan cetak struk', 'Laporan penjualan harian dan bulanan', 'Multi metode pembayaran', 'Manajemen kategori dan diskon'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
                'screenshots' => ['Dashboard penjualan', 'Halaman transaksi kasir', 'Laporan dan rekap omzet'],
                'github_url' => 'https://github.com/sandev/sikasir',
                'demo_url' => 'https://sikasir.demo.sandev.id',
                'status' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'SIARSIP',
                'slug' => 'siarsip',
                'summary' => 'Sistem pengelolaan arsip digital: klasifikasi, penyimpanan, dan peminjaman dokumen instansi.',
                'case_study' => 'Arsip fisik instansi menumpuk dan sulit ditemukan saat dibutuhkan, sementara risiko dokumen hilang cukup tinggi. Petugas arsip memerlukan sistem terpusat untuk mengelola surat masuk dan keluar.',
                'solution' => 'Menyediakan repositori arsip digital dengan klasifikasi berdasarkan kode arsip, pencarian cepat, serta pelacakan peminjaman dan pengembalian dokumen. Setiap dokumen memiliki jadwal retensi yang jelas.',
                'features' => ['Klasifikasi dan kode arsip', 'Upload dan preview dokumen', 'Pencarian arsip cepat', 'Peminjaman dan pengembalian', 'Jadwal retensi arsip'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Livewire'],
                'screenshots' => ['Daftar arsip', 'Detail dan preview dokumen', 'Log peminjaman'],
                'github_url' => 'https://github.com/sandev/siarsip',
                'demo_url' => null,
                'status' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'SIHONOR',
                'slug' => 'sihonor',
                'summary' => 'Sistem penghitungan honorarium kegiatan lengkap dengan potongan pajak dan slip PDF.',
                'case_study' => 'Perhitungan honor panitia dan narasumber dilakukan manual di spreadsheet, memakan waktu dan sering salah menghitung pajak. Bendahara membutuhkan proses yang konsisten dan mudah diaudit.',
                'solution' => 'Mengotomatiskan perhitungan honor beserta potongan PPh 21, dengan approval bertingkat dan slip honor siap cetak dalam format PDF. Rekap per kegiatan mempermudah pelaporan keuangan.',
                'features' => ['Perhitungan honor otomatis', 'Potongan pajak PPh 21', 'Slip honor format PDF', 'Approval bertingkat', 'Rekap per kegiatan'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
                'screenshots' => ['Input kegiatan dan peserta', 'Rincian perhitungan honor', 'Slip honor PDF'],
                'github_url' => null,
                'demo_url' => 'https://sihonor.demo.sandev.id',
                'status' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'SIMASET',
                'slug' => 'simaset',
                'summary' => 'Manajemen aset dengan label QR Code, mutasi, dan penyusutan aset instansi.',
                'case_study' => 'Inventaris aset tersebar di banyak unit tanpa pencatatan terpusat, sehingga kondisi dan lokasi aset sulit dilacak. Tim sarana dan prasarana kesulitan ketika audit tahunan.',
                'solution' => 'Mendata seluruh aset dengan label QR Code untuk pelacakan cepat, mencatat mutasi dan peminjaman, serta menghitung penyusutan secara otomatis. Laporan kondisi aset tersedia per unit.',
                'features' => ['Inventarisasi aset terpusat', 'Label dan scan QR Code', 'Mutasi dan peminjaman aset', 'Penyusutan otomatis', 'Laporan kondisi aset'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
                'screenshots' => ['Daftar aset', 'Detail aset dan QR', 'Laporan penyusutan'],
                'github_url' => 'https://github.com/sandev/simaset',
                'demo_url' => 'https://simaset.demo.sandev.id',
                'status' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'SIPERJALANAN',
                'slug' => 'siperjalanan',
                'summary' => 'Pengelolaan Surat Perjalanan Dinas (SPPD): pengajuan, approval, dan rincian biaya.',
                'case_study' => 'Proses pengajuan perjalanan dinas berbasis kertas berjalan lambat dan sulit dilacak statusnya. Pegawai tidak mengetahui sejauh mana pengajuannya sedang diproses.',
                'solution' => 'Mendigitalkan alur SPPD dari pengajuan, persetujuan atasan, hingga rincian biaya perjalanan. Surat tugas dan SPPD dapat dicetak langsung, dengan rekap perjalanan per pegawai.',
                'features' => ['Pengajuan SPPD online', 'Approval berjenjang', 'Rincian biaya perjalanan', 'Cetak surat tugas dan SPPD', 'Rekap perjalanan pegawai'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js'],
                'screenshots' => ['Form pengajuan SPPD', 'Panel approval', 'Cetak surat tugas'],
                'github_url' => 'https://github.com/sandev/siperjalanan',
                'demo_url' => null,
                'status' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'SIMONITOR',
                'slug' => 'simonitor',
                'summary' => 'Dashboard monitoring progres kegiatan dengan grafik capaian dan notifikasi keterlambatan.',
                'case_study' => 'Pimpinan kesulitan memantau progres banyak kegiatan yang berjalan bersamaan dan sering terlambat mengetahui adanya keterlambatan. Laporan progres masih dikirim manual.',
                'solution' => 'Menyajikan dashboard monitoring real-time dengan grafik capaian per kegiatan dan notifikasi otomatis saat target meleset. Laporan dapat diekspor untuk kebutuhan rapat.',
                'features' => ['Dashboard real-time', 'Monitoring progres kegiatan', 'Notifikasi keterlambatan', 'Grafik capaian', 'Export laporan'],
                'technologies' => ['Laravel', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'Chart.js'],
                'screenshots' => ['Dashboard monitoring', 'Detail progres kegiatan', 'Grafik capaian'],
                'github_url' => 'https://github.com/sandev/simonitor',
                'demo_url' => 'https://simonitor.demo.sandev.id',
                'status' => true,
                'sort_order' => 6,
            ],
        ];
    }
}
