<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SecondOrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::firstOrCreate(
            ['email' => 'organizer2@organizer.com'],
            [
                'name' => 'Pro Event Organizer',
                'password' => Hash::make('password'),
                'role' => 'organizer',
                'organizer_status' => 'approved', 
            ],
        );

        $orgId = $organizer->id;

        $events = [
            [
                'user_id' => $orgId,
                'title' => 'PSM Makassar vs Persija Jakarta',
                'category' => 'Olahraga',
                'description' => 'Big Match Liga 1 Indonesia! Dukung tim kebanggaanmu di Stadion Gelora BJ Habibie. Pertandingan penentuan juara musim ini.',
                'start_time' => Carbon::parse('2026-09-15 15:30:00'),
                'location' => 'Makassar',
                'image' => null,
                'tickets' => [['name' => 'VIP Utama', 'price' => 250000, 'quota' => 50, 'description' => 'Kursi tengah, atap tertutup'], ['name' => 'Tribun Timur', 'price' => 75000, 'quota' => 500, 'description' => 'Tanpa atap'], ['name' => 'Tribun Utara', 'price' => 50000, 'quota' => 1000, 'description' => 'Supporter Area']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Workshop Fotografi: Capture The Light',
                'category' => 'Seminar',
                'description' => 'Belajar teknik pencahayaan studio dan outdoor langsung dari fotografer profesional National Geographic. Bawa kameramu sendiri!',
                'start_time' => Carbon::parse('2026-08-20 10:00:00'),
                'location' => 'Surabaya',
                'image' => null,
                'tickets' => [['name' => 'Peserta', 'price' => 500000, 'quota' => 30, 'description' => 'Termasuk makan siang & sertifikat']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Java Jazz Festival 2026',
                'category' => 'Konser Musik',
                'description' => 'Festival Jazz terbesar di belahan bumi selatan kembali hadir. Menampilkan musisi jazz legendaris dunia dan talenta lokal terbaik.',
                'start_time' => Carbon::parse('2026-11-01 16:00:00'),
                'location' => 'Jakarta',
                'image' => null,
                'tickets' => [['name' => '3 Day Pass', 'price' => 1800000, 'quota' => 1000, 'description' => 'Akses semua hari'], ['name' => 'Daily Pass', 'price' => 750000, 'quota' => 500, 'description' => 'Akses 1 hari bebas pilih']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Teater Koma: Sampek Engtay',
                'category' => 'Teater',
                'description' => 'Pementasan ulang lakon legendaris Sampek Engtay. Kisah cinta klasik dengan sentuhan komedi khas Teater Koma.',
                'start_time' => Carbon::parse('2026-10-05 19:30:00'),
                'location' => 'Solo',
                'image' => null,
                'tickets' => [['name' => 'VVIP', 'price' => 500000, 'quota' => 50, 'description' => 'Baris 1-3 Tengah'], ['name' => 'Kelas 1', 'price' => 250000, 'quota' => 200, 'description' => 'Sayap Kiri/Kanan'], ['name' => 'Balkon', 'price' => 100000, 'quota' => 300, 'description' => 'Lantai 2']],
            ],
        ];

        // 3. Simpan ke Database
        foreach ($events as $data) {
            $ticketsData = $data['tickets'];
            unset($data['tickets']);

            $event = Event::create($data);

            foreach ($ticketsData as $ticket) {
                $event->tickets()->create($ticket);
            }
        }
    }
}