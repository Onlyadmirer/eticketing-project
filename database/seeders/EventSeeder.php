<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $organizer = User::where('role', 'organizer')->first();

        if (!$organizer) {
            $this->command->info('Harap buat akun Organizer terlebih dahulu!');
            return;
        }

        $orgId = $organizer->id;

        $events = [
            [
                'user_id' => $orgId,
                'title' => 'Coldplay: Music of the Spheres',
                'category' => 'Konser Musik',
                'description' => 'Saksikan penampilan spektakuler Coldplay secara langsung di Jakarta! Pengalaman konser stadion yang tak terlupakan dengan gelang LED dan kembang api.',
                'start_time' => Carbon::parse('2026-11-15 19:00:00'),
                'location' => 'Jakarta',
                'image' => null, 
                'tickets' => [['name' => 'Ultimate Experience', 'price' => 11000000, 'quota' => 20, 'description' => 'Backstage tour + Front row seat'], ['name' => 'Festival A', 'price' => 3500000, 'quota' => 500, 'description' => 'Standing area depan panggung'], ['name' => 'Tribune B', 'price' => 1200000, 'quota' => 1000, 'description' => 'Seated number']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Indonesia Tech Summit 2026',
                'category' => 'Seminar',
                'description' => 'Konferensi teknologi terbesar tahun ini. Menghadirkan pembicara dari Google, Meta, dan unicorn lokal. Membahas AI, Blockchain, dan Startup.',
                'start_time' => Carbon::parse('2026-10-20 09:00:00'),
                'location' => 'Bandung',
                'image' => null,
                'tickets' => [['name' => 'Early Bird', 'price' => 150000, 'quota' => 100, 'description' => 'Akses 2 hari seminar'], ['name' => 'Regular', 'price' => 300000, 'quota' => 200, 'description' => 'Akses 2 hari + Sertifikat']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Jazz Gunung Bromo',
                'category' => 'Konser Musik',
                'description' => 'Menikmati musik jazz syahdu di ketinggian 2000mdpl dengan latar belakang pemandangan Gunung Bromo yang ikonik.',
                'start_time' => Carbon::parse('2025-08-17 15:00:00'),
                'location' => 'Probolinggo',
                'image' => null,
                'tickets' => [['name' => 'VVIP', 'price' => 2500000, 'quota' => 50, 'description' => 'Dinner + Front Seat'], ['name' => 'Festival', 'price' => 750000, 'quota' => 300, 'description' => 'Free Raincoat + Standing']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Pameran Seni: Raden Saleh',
                'category' => 'Pameran',
                'description' => 'Retrospeksi karya-karya maestro lukis Indonesia, Raden Saleh. Koleksi langka yang didatangkan dari berbagai museum dunia.',
                'start_time' => Carbon::parse('2026-09-01 10:00:00'),
                'location' => 'Yogyakarta',
                'image' => null,
                'tickets' => [['name' => 'Umum', 'price' => 50000, 'quota' => 1000, 'description' => 'Sesi pagi'], ['name' => 'Pelajar', 'price' => 25000, 'quota' => 500, 'description' => 'Wajib kartu pelajar']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Final Indonesia Open 2026',
                'category' => 'Olahraga',
                'description' => 'Dukung atlet badminton kebanggaan Indonesia di partai final Indonesia Open. Istora Senayan akan bergemuruh!',
                'start_time' => Carbon::parse('2026-06-12 13:00:00'),
                'location' => 'Jakarta',
                'image' => null,
                'tickets' => [['name' => 'VIP', 'price' => 1000000, 'quota' => 100, 'description' => 'Best View'], ['name' => 'Regular', 'price' => 400000, 'quota' => 500, 'description' => 'Tribune atas']],
            ],
            [
                'user_id' => $orgId,
                'title' => 'Stand Up Comedy World Tour',
                'category' => 'Teater',
                'description' => 'Tertawa lepas bersama komika internasional yang sedang tur dunia. Materi fresh dan dijamin pecah!',
                'start_time' => Carbon::parse('2026-12-05 20:00:00'),
                'location' => 'Bali',
                'image' => null,
                'tickets' => [['name' => 'Gold', 'price' => 800000, 'quota' => 200, 'description' => 'Row 1-5'], ['name' => 'Silver', 'price' => 500000, 'quota' => 300, 'description' => 'Row 6-15']],
            ],
        ];

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