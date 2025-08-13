<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'description' => 'Buku-buku fiksi mencakup cerita imajinatif, novel, cerpen, dan karya sastra kreatif lainnya. Kategori ini cocok untuk pembaca yang menyukai dunia imajinasi dan kisah fiksi.'
            ],
            [
                'name' => 'Non-Fiksi',
                'description' => 'Buku non-fiksi berisi fakta dan informasi nyata seperti biografi, sejarah, ilmu pengetahuan, dan panduan praktis. Cocok untuk pengetahuan dan pembelajaran.'
            ],
            [
                'name' => 'Pelajaran Sekolah',
                'description' => 'Buku teks pelajaran untuk semua jenjang sekolah mulai dari SD, SMP, hingga SMA. Meliputi semua mata pelajaran seperti Matematika, IPA, IPS, Bahasa Indonesia, dan lainnya.'
            ],
            [
                'name' => 'Referensi & Ensiklopedia',
                'description' => 'Buku referensi seperti kamus, ensiklopedia, atlas, dan panduan cepat. Berguna untuk mencari informasi dan pengetahuan umum secara cepat dan akurat.'
            ],
            [
                'name' => 'Bahasa & Sastra',
                'description' => 'Buku tentang tata bahasa, kesusastraan, puisi, drama, dan analisis karya sastra. Cocok untuk siswa dan guru bahasa serta pecinta sastra.'
            ],
            [
                'name' => 'Matematika & IPA',
                'description' => 'Buku matematika, fisika, kimia, biologi, dan sains lainnya. Termasuk buku latihan soal dan panduan belajar untuk persiapan ujian.'
            ],
            [
                'name' => 'IPS & Sejarah',
                'description' => 'Buku sejarah, geografi, ekonomi, sosiologi, dan ilmu sosial lainnya. Membantu memahami peristiwa sejarah dan fenomena sosial.'
            ],
            [
                'name' => 'Komputer & Teknologi',
                'description' => 'Buku tentang teknologi informasi, pemrograman, desain grafis, dan perkembangan teknologi modern. Cocok untuk siswa TKJ dan pecinta teknologi.'
            ],
            [
                'name' => 'Seni & Budaya',
                'description' => 'Buku tentang seni rupa, musik, tari, teater, dan kebudayaan. Memperkenalkan kekayaan budaya Indonesia dan dunia seni.'
            ],
            [
                'name' => 'Agama & Spiritual',
                'description' => 'Buku keagamaan untuk semua keyakinan, termasuk Al-Quran, Hadis, Bible, dan literatur spiritual lainnya. Untuk pembinaan rohani dan moral.'
            ],
            [
                'name' => 'Kesehatan & Olahraga',
                'description' => 'Buku tentang kesehatan, gizi, olahraga, dan panduan hidup sehat. Cocok untuk siswa PJOK dan pembaca yang peduli kesehatan.'
            ],
            [
                'name' => 'Komik & Novel Grafis',
                'description' => 'Komik, manga, novel grafis, dan cerita bergambar. Menyenangkan untuk semua usia dengan kombinasi gambar dan cerita yang menarik.'
            ],
            [
                'name' => 'Cerita Anak & Dongeng',
                'description' => 'Cerita anak-anak, dongeng, fabel, dan cerita moral untuk PAUD hingga SD. Mengandung nilai-nilai pendidikan dan hiburan edukatif.'
            ],
            [
                'name' => 'Biografi & Otobiografi',
                'description' => 'Kisah nyata tokoh-tokoh inspiratif, pahlawan nasional, ilmuwan, dan tokoh dunia. Memberikan inspirasi dan motivasi untuk pembaca.'
            ],
            [
                'name' => 'Panduan & Tips Belajar',
                'description' => 'Buku panduan belajar efektif, tips sukses ujian, strategi belajar, dan motivasi pendidikan. Untuk membantu siswa mencapai prestasi akademik.'
            ],
            [
                'name' => 'Bahasa Asing',
                'description' => 'Buku pembelajaran bahasa asing seperti Inggris, Jepang, Korea, Arab, dan lainnya. Termasuk kamus dan panduan percakapan.'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
