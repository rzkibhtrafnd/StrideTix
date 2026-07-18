<?php

namespace Database\Seeders;

use App\Models\Organizer;
use App\Models\Event;
use App\Models\RaceCategory;
use App\Models\TicketTier;
use App\Enums\EventStatus;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventMasterSeeder extends Seeder
{
    public function run(): void
    {
        $organizers = Organizer::all();
        
        if ($organizers->isEmpty()) {
            return;
        }

        $eoSurabaya = $organizers->where('company_name', 'PT Surabaya Runners Indonesia')->first() ?? $organizers->first();
        $eoJakarta = $organizers->where('company_name', 'Jakarta Marathon Global EO')->first() ?? $organizers->first();

        $eventsData = [
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Surabaya Heroic Marathon 2026',
                'description' => 'Rayakan semangat kepahlawanan dengan berlari menyusuri rute bersejarah ikon Kota Surabaya.',
                'location' => 'Panglima Sudirman, Surabaya',
                'google_maps_url' => 'https://maps.google.com/?q=Panglima+Sudirman+Surabaya',
                'event_date' => Carbon::now()->addMonths(2)->toDateString(),
                'status' => 2, 
                'categories' => [
                    ['name' => 'Full Marathon', 'dist' => '42', 'slots' => 500, 'tiers' => [['name' => 'Early Bird', 'price' => 650000, 'qty' => 100], ['name' => 'Normal', 'price' => 850000, 'qty' => 400]]],
                    ['name' => 'Half Marathon', 'dist' => '21', 'slots' => 800, 'tiers' => [['name' => 'Early Bird', 'price' => 450000, 'qty' => 200], ['name' => 'Normal', 'price' => 550000, 'qty' => 600]]],
                    ['name' => '10K Run', 'dist' => '10', 'slots' => 1000, 'tiers' => [['name' => 'Normal Price', 'price' => 350000, 'qty' => 1000]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Jakarta Midnight Street Run',
                'description' => 'Rasakan sensasi dingin malam hari melintasi megahnya gedung pencakar langit Sudirman-Thamrin.',
                'location' => 'Gelora Bung Karno, Jakarta',
                'google_maps_url' => 'https://maps.google.com/?q=Gelora+Bung+Karno',
                'event_date' => Carbon::now()->addMonths(3)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '5K Fun Run', 'dist' => '5', 'slots' => 1500, 'tiers' => [['name' => 'Presale', 'price' => 200000, 'qty' => 500], ['name' => 'Normal', 'price' => 275000, 'qty' => 1000]]],
                    ['name' => '10K Night Run', 'dist' => '10', 'slots' => 1200, 'tiers' => [['name' => 'Normal', 'price' => 375000, 'qty' => 1200]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Bromo Volcano Trail Challenge',
                'description' => 'Tantang adrenalinmu menerjang lautan pasir dan dinginnya elevasi ekstrem pegunungan Tengger Bromo.',
                'location' => 'Taman Nasional Bromo Tengger Semeru',
                'google_maps_url' => 'https://maps.google.com/?q=Gunung+Bromo',
                'event_date' => Carbon::now()->addMonths(4)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '30K Ultra Trail', 'dist' => '30', 'slots' => 300, 'tiers' => [['name' => 'Reguler', 'price' => 950000, 'qty' => 300]]],
                    ['name' => '15K Mountain Run', 'dist' => '15', 'slots' => 500, 'tiers' => [['name' => 'Reguler', 'price' => 600000, 'qty' => 500]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Borobudur Heritage Cultural Run',
                'description' => 'Berlari melintasi pedesaan asri Magelang dengan latar belakang kemegahan Candi Borobudur.',
                'location' => 'Candi Borobudur, Magelang',
                'google_maps_url' => 'https://maps.google.com/?q=Candi+Borobudur',
                'event_date' => Carbon::now()->addMonths(5)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '21K Half Marathon', 'dist' => '21', 'slots' => 1000, 'tiers' => [['name' => 'Early Bird', 'price' => 500000, 'qty' => 300], ['name' => 'Normal', 'price' => 700000, 'qty' => 700]]],
                    ['name' => '10K Heritage', 'dist' => '10', 'slots' => 1500, 'tiers' => [['name' => 'Normal', 'price' => 400000, 'qty' => 1500]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'East Java Coastal Eco Run',
                'description' => 'Lintasan lari flat menyusuri garis pantai eksotis dengan tiupan angin laut yang menyegarkan.',
                'location' => 'Pantai Kenjeran, Surabaya',
                'google_maps_url' => 'https://maps.google.com/?q=Pantai+Kenjeran',
                'event_date' => Carbon::now()->addWeeks(6)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '10K Sunset Run', 'dist' => '10', 'slots' => 800, 'tiers' => [['name' => 'All Tier', 'price' => 300000, 'qty' => 800]]],
                    ['name' => '5K Family Walk & Run', 'dist' => '5', 'slots' => 1200, 'tiers' => [['name' => 'Normal', 'price' => 180000, 'qty' => 1200]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Bali Sunset Beach Ultra',
                'description' => 'Kombinasi lari maraton di atas hamparan pasir putih Kuta hingga Uluwatu menjelang matahari terbenam.',
                'location' => 'Kuta Beach, Badung, Bali',
                'google_maps_url' => 'https://maps.google.com/?q=Kuta+Beach+Bali',
                'event_date' => Carbon::now()->addMonths(6)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '50K Ultra Marathon', 'dist' => '50', 'slots' => 250, 'tiers' => [['name' => 'Slot Terbatas', 'price' => 1200000, 'qty' => 250]]],
                    ['name' => '21K Tropical Run', 'dist' => '21', 'slots' => 600, 'tiers' => [['name' => 'Normal', 'price' => 750000, 'qty' => 600]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Malang Heritage Highlands Run',
                'description' => 'Lintasan berbukit dengan hawa sejuk pegunungan mengitari bangunan kolonial bersejarah Kota Malang.',
                'location' => 'Ijen Boulevard, Malang',
                'google_maps_url' => 'https://maps.google.com/?q=Ijen+Boulevard+Malang',
                'event_date' => Carbon::now()->addMonths(2)->addWeeks(2)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '10K Hills', 'dist' => '10', 'slots' => 700, 'tiers' => [['name' => 'Reguler', 'price' => 320000, 'qty' => 700]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Bandung City Light Dash',
                'description' => 'Event lari santai menikmati gemerlap malam Gedung Sate dan keindahan kota Paris Van Java.',
                'location' => 'Dago, Bandung',
                'google_maps_url' => 'https://maps.google.com/?q=Gedung+Sate+Bandung',
                'event_date' => Carbon::now()->addMonths(3)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '5K Spark', 'dist' => '5', 'slots' => 1000, 'tiers' => [['name' => 'Early', 'price' => 150000, 'qty' => 300], ['name' => 'Late Bird', 'price' => 220000, 'qty' => 700]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Surabaya Green Smart City Run',
                'description' => 'Kampanye lari ramah lingkungan melewati taman-taman kota terbaik di pusat Jawa Timur.',
                'location' => 'Taman Bungkul, Surabaya',
                'google_maps_url' => 'https://maps.google.com/?q=Taman+Bungkul+Surabaya',
                'event_date' => Carbon::now()->addMonths(1)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '10K Eco Speed', 'dist' => '10', 'slots' => 500, 'tiers' => [['name' => 'Normal', 'price' => 280000, 'qty' => 500]]],
                    ['name' => '5K Green Walk', 'dist' => '5', 'slots' => 500, 'tiers' => [['name' => 'Normal', 'price' => 200000, 'qty' => 500]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Yogyakarta Sultanate Palace Run',
                'description' => 'Berlari dengan nuansa magis budaya melintasi Malioboro hingga Alun-Alun Kidul Kraton Jogja.',
                'location' => 'Malioboro, Yogyakarta',
                'google_maps_url' => 'https://maps.google.com/?q=Malioboro+Jogja',
                'event_date' => Carbon::now()->addMonths(4)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '21K Royal Run', 'dist' => '21', 'slots' => 800, 'tiers' => [['name' => 'Standard', 'price' => 480000, 'qty' => 800]]],
                    ['name' => '10K Culture Dash', 'dist' => '10', 'slots' => 1200, 'tiers' => [['name' => 'Standard', 'price' => 330000, 'qty' => 1200]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => '[DRAFT] Madura Bridge Championship Trail',
                'description' => 'Rencana event lari melintasi jembatan Suramadu hingga pesisir barat pulau Madura.',
                'location' => 'Jembatan Suramadu, sisi Surabaya',
                'google_maps_url' => 'https://maps.google.com/?q=Jembatan+Suramadu',
                'event_date' => Carbon::now()->addMonths(7)->toDateString(),
                'status' => 1,
                'categories' => [
                    ['name' => '10K Bridge Cross', 'dist' => '10', 'slots' => 500, 'tiers' => [['name' => 'Draft Pricing', 'price' => 300000, 'qty' => 500]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Semarang Old Town Chrono Run',
                'description' => 'Uji kecepatan larimu membelah rute eksotis wilayah Kota Lama Semarang (Little Netherlands).',
                'location' => 'Kota Lama, Semarang',
                'google_maps_url' => 'https://maps.google.com/?q=Kota+Lama+Semarang',
                'event_date' => Carbon::now()->addMonths(5)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '10K Time Attack', 'dist' => '10', 'slots' => 600, 'tiers' => [['name' => 'Reguler', 'price' => 310000, 'qty' => 600]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Gresik Industrial Heritage Run',
                'description' => 'Event lari menyusuri kawasan utilitas pabrik modern bercampur cagar budaya pesisir utara.',
                'location' => 'Alun-Alun Gresik',
                'google_maps_url' => 'https://maps.google.com/?q=Alun+Alun+Gresik',
                'event_date' => Carbon::now()->addMonths(6)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '12K Cross Border', 'dist' => '12', 'slots' => 400, 'tiers' => [['name' => 'Promo Merdeka', 'price' => 250000, 'qty' => 400]]],
                ]
            ],
            [
                'organizer_id' => $eoJakarta->id,
                'title' => 'Lombok Rinjani Foothills Marathon',
                'description' => 'Menyuguhkan panorama sabana kaki gunung Rinjani yang menakjubkan bagi para pecinta marathon sejati.',
                'location' => 'Sembalun, Lombok Timur',
                'google_maps_url' => 'https://maps.google.com/?q=Sembalun+Rinjani',
                'event_date' => Carbon::now()->addMonths(8)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '42K Mountain Road', 'dist' => '42', 'slots' => 300, 'tiers' => [['name' => 'Standard', 'price' => 900000, 'qty' => 300]]],
                    ['name' => '21K Sembalun Trek', 'dist' => '21', 'slots' => 500, 'tiers' => [['name' => 'Standard', 'price' => 600000, 'qty' => 500]]],
                ]
            ],
            [
                'organizer_id' => $eoSurabaya->id,
                'title' => 'Solo Batik Carnival Fun Run',
                'description' => 'Berlari santai menggunakan atribut kain batik sekreatif mungkin bersama ribuan peserta se-Solo Raya.',
                'location' => 'Stadion Manahan, Surakarta',
                'google_maps_url' => 'https://maps.google.com/?q=Stadion+Manahan+Solo',
                'event_date' => Carbon::now()->addMonths(3)->addWeeks(3)->toDateString(),
                'status' => 2,
                'categories' => [
                    ['name' => '5K Carnival Run', 'dist' => '5', 'slots' => 2000, 'tiers' => [['name' => 'Tiket Masuk', 'price' => 150000, 'qty' => 2000]]],
                ]
            ],
        ];

        foreach ($eventsData as $eData) {
            $event = Event::create([
                'organizer_id' => $eData['organizer_id'],
                'title' => $eData['title'],
                'description' => $eData['description'],
                'location' => $eData['location'],
                'google_maps_url' => $eData['google_maps_url'],
                'event_date' => $eData['event_date'],
                'status' => $eData['status'],
            ]);

            foreach ($eData['categories'] as $cData) {
                $category = RaceCategory::create([
                    'event_id' => $event->id,
                    'category_name' => $cData['name'],
                    'distance_km' => $cData['dist'],
                    'total_slot' => $cData['slots'],
                    'available_slot' => $cData['slots'],
                ]);

                foreach ($cData['tiers'] as $tData) {
                    TicketTier::create([
                        'race_category_id' => $category->id,
                        'tier_name' => $tData['name'],
                        'price' => $tData['price'],
                        'start_date' => Carbon::now()->subDays(5)->toDateString(),
                        'end_date' => Carbon::parse($event->event_date)->subDays(3)->toDateString(),
                        'slot_limit' => $tData['qty'],
                    ]);
                }
            }
        }
    }
}