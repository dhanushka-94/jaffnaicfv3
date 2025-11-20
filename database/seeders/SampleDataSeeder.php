<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\Venue;
use App\Models\Slider;
use App\Models\ScheduleImage;
use App\Models\MasterclassImage;
use App\Models\DebutFilmImage;
use App\Models\JuryDebutImage;
use App\Models\JuryShortImage;
use App\Models\NationalShortImage;
use App\Models\InternationalShortImage;
use App\Models\NewAsianCurrentImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = (int) date('Y');

        // Truncate all content tables (keep settings and users)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        TeamMember::truncate();
        Partner::truncate();
        PartnerCategory::truncate();
        Venue::truncate();
        Slider::truncate();
        ScheduleImage::truncate();
        MasterclassImage::truncate();
        DebutFilmImage::truncate();
        JuryDebutImage::truncate();
        JuryShortImage::truncate();
        NationalShortImage::truncate();
        InternationalShortImage::truncate();
        NewAsianCurrentImage::truncate();
        
        // Also truncate other content tables if they exist
        $otherTables = [
            'news',
            'films',
            'categories',
            'schedules',
            'jury_members',
            'masterclasses',
            'contact_messages',
            'downloads',
            'archives',
        ];
        
        foreach ($otherTables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed Partner Categories
        $categories = [
            ['name' => 'Main Sponsor', 'sort_order' => 1],
            ['name' => 'Co-Sponsor', 'sort_order' => 2],
            ['name' => 'Media Partner', 'sort_order' => 3],
            ['name' => 'Venue Partner', 'sort_order' => 4],
            ['name' => 'Supporting Partner', 'sort_order' => 5],
        ];

        foreach ($categories as $cat) {
            PartnerCategory::create($cat);
        }

        $mainSponsorId = PartnerCategory::where('name', 'Main Sponsor')->first()->id;
        $coSponsorId = PartnerCategory::where('name', 'Co-Sponsor')->first()->id;
        $mediaPartnerId = PartnerCategory::where('name', 'Media Partner')->first()->id;
        $venuePartnerId = PartnerCategory::where('name', 'Venue Partner')->first()->id;
        $supportingPartnerId = PartnerCategory::where('name', 'Supporting Partner')->first()->id;

        // Seed Partners
        $partners = [
            ['name' => 'Agenda 14', 'category_id' => $mainSponsorId, 'url' => 'https://agenda14.com', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Ministry of Culture', 'category_id' => $coSponsorId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'National Film Corporation', 'category_id' => $coSponsorId, 'url' => 'https://example.com', 'sort_order' => 2, 'year' => $currentYear],
            ['name' => 'Daily News', 'category_id' => $mediaPartnerId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Regal Cinemas', 'category_id' => $venuePartnerId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Majestic Cineplex', 'category_id' => $venuePartnerId, 'url' => 'https://example.com', 'sort_order' => 2, 'year' => $currentYear],
            ['name' => 'Local Cinema Association', 'category_id' => $supportingPartnerId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $currentYear],
        ];

        foreach ($partners as $partner) {
            Partner::create($partner);
        }

        // Seed Team Members
        $teamMembers = [
            ['name' => 'Dr. Sivamohan Sumathy', 'role' => 'Director', 'email' => 'director@jaffnaicf.local', 'phone' => '+94 77 123 4567', 'bio' => 'Festival Director with extensive experience in cinema and cultural studies.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Prof. K. Sivathamby', 'role' => 'Consultant', 'email' => 'consultant1@jaffnaicf.local', 'phone' => '+94 77 234 5678', 'bio' => 'Programme consultant specializing in South Asian cinema.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Dr. A. Sivanandan', 'role' => 'Consultant', 'email' => 'consultant2@jaffnaicf.local', 'phone' => '+94 77 345 6789', 'bio' => 'Film scholar and cultural critic.', 'sort_order' => 2, 'year' => $currentYear],
            ['name' => 'Mr. R. Karthigesu', 'role' => 'Advisory Committee', 'email' => 'advisory1@jaffnaicf.local', 'phone' => '+94 77 456 7890', 'bio' => 'Member of the advisory committee.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Ms. N. Thamilselvam', 'role' => 'Advisory Committee', 'email' => 'advisory2@jaffnaicf.local', 'phone' => '+94 77 567 8901', 'bio' => 'Member of the advisory committee.', 'sort_order' => 2, 'year' => $currentYear],
            ['name' => 'Mr. K. Jeyakumar', 'role' => 'Manager', 'email' => 'manager@jaffnaicf.local', 'phone' => '+94 77 678 9012', 'bio' => 'Festival Manager overseeing day-to-day operations.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Ms. S. Kamaladevi', 'role' => 'Coordinator — Colombo', 'email' => 'colombo@jaffnaicf.local', 'phone' => '+94 11 234 5678', 'bio' => 'Colombo coordinator handling administrative tasks.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Mr. T. Selvakumar', 'role' => 'Coordinator — Jaffna', 'email' => 'jaffna@jaffnaicf.local', 'phone' => '+94 21 222 7703', 'bio' => 'Jaffna coordinator managing local arrangements.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Ms. A. Priyadharshini', 'role' => 'Festival Team', 'email' => 'team1@jaffnaicf.local', 'phone' => '+94 77 789 0123', 'bio' => 'Festival team member.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Mr. M. Senthilkumar', 'role' => 'Festival Team', 'email' => 'team2@jaffnaicf.local', 'phone' => '+94 77 890 1234', 'bio' => 'Festival team member.', 'sort_order' => 2, 'year' => $currentYear],
            ['name' => 'Design Studio', 'role' => 'Design & Illustrations', 'email' => 'design@jaffnaicf.local', 'phone' => '+94 77 901 2345', 'bio' => 'Graphic design and visual identity.', 'sort_order' => 1, 'year' => $currentYear],
            ['name' => 'Print Solutions', 'role' => 'Printers', 'email' => 'print@jaffnaicf.local', 'phone' => '+94 77 012 3456', 'bio' => 'Printing services provider.', 'sort_order' => 1, 'year' => $currentYear],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::create($member);
        }

        // Seed Venues
        $venues = [
            [
                'name' => 'Regal Cinemas',
                'address' => 'Cargills Square, Mahathma Gandhi Road, Jaffna 40000',
                'contacts' => '021 222 7703',
                'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31465.480542213012!2d80.01359!3d9.665223!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe56aa1875e9af%3A0xf7d2bd379eb01577!2sMajestic%20Cineplex%20-%20Jaffna!5e0!3m2!1sen!2slk!4v1763313237269!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'description' => 'Main screening venue for the festival.',
                'sort_order' => 1,
                'year' => $currentYear,
            ],
            [
                'name' => 'Majestic Cineplex',
                'address' => 'Mahathma Gandhi Road, Jaffna 40000',
                'contacts' => '021 222 7703',
                'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31465.480542213012!2d80.01359!3d9.665223!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe56aa1875e9af%3A0xf7d2bd379eb01577!2sMajestic%20Cineplex%20-%20Jaffna!5e0!3m2!1sen!2slk!4v1763313237269!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'description' => 'Secondary screening venue.',
                'sort_order' => 2,
                'year' => $currentYear,
            ],
        ];

        foreach ($venues as $venue) {
            Venue::create($venue);
        }

        // Seed Sliders
        $sliders = [
            [
                'title' => 'Welcome to JAFFNA ICF 2025',
                'subtitle' => 'Celebrating Cinema from South Asia and Beyond',
                'image_path' => 'sliders/sample-slider-1.jpg', // Placeholder - upload actual image via admin
                'button_text' => 'View Programme',
                'button_url' => '/programme/schedule',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'International Cinema Festival',
                'subtitle' => 'Showcasing the Best of Independent Cinema',
                'image_path' => 'sliders/sample-slider-2.jpg', // Placeholder - upload actual image via admin
                'button_text' => 'Learn More',
                'button_url' => '/about',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Join Us in Jaffna',
                'subtitle' => 'Experience Cinema in the Heart of Northern Sri Lanka',
                'image_path' => 'sliders/sample-slider-3.jpg', // Placeholder - upload actual image via admin
                'button_text' => 'Get Tickets',
                'button_url' => '/contact',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        // Seed Programme Images (with placeholder paths - upload actual images via admin)
        // Schedule Images
        for ($i = 1; $i <= 3; $i++) {
            ScheduleImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/schedule/sample-schedule-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // Masterclass Images
        for ($i = 1; $i <= 3; $i++) {
            MasterclassImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/masterclasses/sample-masterclass-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // Debut Film Images
        for ($i = 1; $i <= 4; $i++) {
            DebutFilmImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/debut-films/sample-debut-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // Jury Debut Images
        for ($i = 1; $i <= 3; $i++) {
            JuryDebutImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/jury-debut/sample-jury-debut-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // Jury Short Images
        for ($i = 1; $i <= 3; $i++) {
            JuryShortImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/jury-short/sample-jury-short-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // National Short Images
        for ($i = 1; $i <= 5; $i++) {
            NationalShortImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/national-shorts/sample-national-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // International Short Images
        for ($i = 1; $i <= 5; $i++) {
            InternationalShortImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/international-shorts/sample-international-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // New Asian Currents Images
        for ($i = 1; $i <= 4; $i++) {
            NewAsianCurrentImage::create([
                'year' => $currentYear,
                'image_path' => 'programme/new-asian-currents/sample-asian-' . $i . '.jpg',
                'sort_order' => $i,
            ]);
        }

        // Seed Archive Data (Previous Years - 2024 and 2023)
        $archiveYears = [2024, 2023];
        
        foreach ($archiveYears as $archiveYear) {
            // Archive Team Members
            $archiveTeamMembers = [
                ['name' => 'Dr. Archive Director', 'role' => 'Director', 'email' => 'director@jaffnaicf.local', 'phone' => '+94 77 123 4567', 'bio' => 'Festival Director for ' . $archiveYear, 'sort_order' => 1, 'year' => $archiveYear],
                ['name' => 'Archive Manager', 'role' => 'Manager', 'email' => 'manager@jaffnaicf.local', 'phone' => '+94 77 234 5678', 'bio' => 'Festival Manager for ' . $archiveYear, 'sort_order' => 1, 'year' => $archiveYear],
                ['name' => 'Archive Coordinator', 'role' => 'Coordinator — Jaffna', 'email' => 'coord@jaffnaicf.local', 'phone' => '+94 21 222 7703', 'bio' => 'Jaffna coordinator for ' . $archiveYear, 'sort_order' => 1, 'year' => $archiveYear],
            ];
            
            foreach ($archiveTeamMembers as $member) {
                TeamMember::create($member);
            }
            
            // Archive Partners
            $archivePartners = [
                ['name' => 'Archive Sponsor ' . $archiveYear, 'category_id' => $mainSponsorId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $archiveYear],
                ['name' => 'Archive Media Partner ' . $archiveYear, 'category_id' => $mediaPartnerId, 'url' => 'https://example.com', 'sort_order' => 1, 'year' => $archiveYear],
            ];
            
            foreach ($archivePartners as $partner) {
                Partner::create($partner);
            }
            
            // Archive Venues
            Venue::create([
                'name' => 'Archive Venue ' . $archiveYear,
                'address' => 'Archive Address, Jaffna 40000',
                'contacts' => '021 222 7703',
                'map_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31465.480542213012!2d80.01359!3d9.665223!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe56aa1875e9af%3A0xf7d2bd379eb01577!2sMajestic%20Cineplex%20-%20Jaffna!5e0!3m2!1sen!2slk!4v1763313237269!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'description' => 'Archive venue for ' . $archiveYear,
                'sort_order' => 1,
                'year' => $archiveYear,
            ]);
            
            // Archive Programme Images (2 images per section)
            ScheduleImage::create(['year' => $archiveYear, 'image_path' => 'programme/schedule/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            ScheduleImage::create(['year' => $archiveYear, 'image_path' => 'programme/schedule/archive-' . $archiveYear . '-2.jpg', 'sort_order' => 2]);
            
            MasterclassImage::create(['year' => $archiveYear, 'image_path' => 'programme/masterclasses/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            MasterclassImage::create(['year' => $archiveYear, 'image_path' => 'programme/masterclasses/archive-' . $archiveYear . '-2.jpg', 'sort_order' => 2]);
            
            DebutFilmImage::create(['year' => $archiveYear, 'image_path' => 'programme/debut-films/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            DebutFilmImage::create(['year' => $archiveYear, 'image_path' => 'programme/debut-films/archive-' . $archiveYear . '-2.jpg', 'sort_order' => 2]);
            
            JuryDebutImage::create(['year' => $archiveYear, 'image_path' => 'programme/jury-debut/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            JuryShortImage::create(['year' => $archiveYear, 'image_path' => 'programme/jury-short/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            NationalShortImage::create(['year' => $archiveYear, 'image_path' => 'programme/national-shorts/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            InternationalShortImage::create(['year' => $archiveYear, 'image_path' => 'programme/international-shorts/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
            NewAsianCurrentImage::create(['year' => $archiveYear, 'image_path' => 'programme/new-asian-currents/archive-' . $archiveYear . '-1.jpg', 'sort_order' => 1]);
        }

        $this->command->info('Sample data seeded successfully!');
        $this->command->info('✓ Partner Categories: ' . PartnerCategory::count());
        $this->command->info('✓ Partners: ' . Partner::count());
        $this->command->info('✓ Team Members: ' . TeamMember::count());
        $this->command->info('✓ Venues: ' . Venue::count());
        $this->command->info('✓ Sliders: ' . Slider::count());
        $this->command->info('✓ Schedule Images: ' . ScheduleImage::count());
        $this->command->info('✓ Masterclass Images: ' . MasterclassImage::count());
        $this->command->info('✓ Debut Film Images: ' . DebutFilmImage::count());
        $this->command->info('✓ Jury Debut Images: ' . JuryDebutImage::count());
        $this->command->info('✓ Jury Short Images: ' . JuryShortImage::count());
        $this->command->info('✓ National Short Images: ' . NationalShortImage::count());
        $this->command->info('✓ International Short Images: ' . InternationalShortImage::count());
        $this->command->info('✓ New Asian Currents Images: ' . NewAsianCurrentImage::count());
        $this->command->info('');
        $this->command->info('Archive data added for years: ' . implode(', ', $archiveYears));
        $this->command->info('Note: Programme images have placeholder paths. Upload actual images via the admin panel.');
    }
}

