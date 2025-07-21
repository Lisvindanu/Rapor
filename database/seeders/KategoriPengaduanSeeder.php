<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('📝 Cek struktur tabel dan membuat data kategori pengaduan...');

        // Cek kolom yang ada di tabel
        $columns = Schema::getColumnListing('ref_kategori_pengaduan');
        $this->command->info('Kolom yang tersedia: ' . implode(', ', $columns));

        // Data kategori
        $kategori = [
            'Kekerasan Seksual',
            'Pelecehan Seksual',
            'Diskriminasi',
            'Bullying/Perundungan',
            'Penyalahgunaan Wewenang',
            'Lainnya'
        ];

        // Hapus data lama
        try {
            DB::table('ref_kategori_pengaduan')->delete();
            $this->command->info('🗑️ Data lama berhasil dihapus');
        } catch (\Exception $e) {
            $this->command->warning('Warning: ' . $e->getMessage());
        }

        $success = 0;

        // Insert dengan hanya kolom yang pasti ada
        foreach ($kategori as $nama) {
            try {
                $data = [];
                
                // Field yang wajib ada
                if (in_array('id', $columns)) {
                    $data['id'] = Str::uuid();
                }
                
                if (in_array('nama_kategori', $columns)) {
                    $data['nama_kategori'] = $nama;
                }
                
                // Field optional
                if (in_array('is_active', $columns)) {
                    $data['is_active'] = true;
                }
                
                if (in_array('created_at', $columns)) {
                    $data['created_at'] = now();
                }
                
                if (in_array('updated_at', $columns)) {
                    $data['updated_at'] = now();
                }

                // Jika ada kolom deskripsi
                if (in_array('deskripsi', $columns)) {
                    $data['deskripsi'] = "Kategori pengaduan: $nama";
                }
                
                DB::table('ref_kategori_pengaduan')->insert($data);
                $this->command->line("   ✅ {$nama}");
                $success++;
                
            } catch (\Exception $e) {
                $this->command->line("   ❌ {$nama}: " . $e->getMessage());
            }
        }

        $this->command->info("✅ Total {$success} kategori berhasil dibuat!");
        
        // Verifikasi hasil
        $count = DB::table('ref_kategori_pengaduan')->count();
        $this->command->info("📊 Total data di database: {$count}");
    }
}