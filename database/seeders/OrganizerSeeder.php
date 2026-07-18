<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organizer;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $surabayaUser = User::where('email', 'organizer@stridetix.com')->first();
        if ($surabayaUser) {
            Organizer::create([
                'user_id' => $surabayaUser->id,
                'company_name' => 'PT Surabaya Runners Indonesia',
                'logo' => 'logos/sub-runners.png'
            ]);
        }

        $jakartaUser = User::where('email', 'jkt.marathon@stridetix.com')->first();
        if ($jakartaUser) {
            Organizer::create([
                'user_id' => $jakartaUser->id,
                'company_name' => 'Jakarta Marathon Global EO',
                'logo' => 'logos/jkt-marathon.png'
            ]);
        }
    }
}