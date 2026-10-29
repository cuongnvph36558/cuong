<?php

namespace Database\Seeders;

use App\Models\Lead;
use Illuminate\Database\Seeder;

class DemoLeadSeeder extends Seeder
{
    /**
     * Seed a handful of demo registrations so the landing page social proof
     * notifications have something to show.
     */
    public function run(): void
    {
        $leads = [
            ['Nguyễn Văn An', '0975123456', 'Đắk Lắk', 'Combo 5 lít'],
            ['Trần Thị Bình', '0985123456', 'Gia Lai', 'Combo 2 lít'],
            ['Lê Hữu Cường', '0915123456', 'Vĩnh Long', 'Gói 1 lít'],
            ['Phạm Thị Dung', '0925123456', 'Đắk Nông', 'Combo 5 lít'],
            ['Hoàng Văn Em', '0935123456', 'Tây Ninh', 'Gói 1 lít'],
            ['Vũ Đình Phong', '0945123456', 'Bình Phước', 'Combo 2 lít'],
            ['Đặng Thị Quỳnh', '0955123456', 'Nghệ An', 'Combo 5 lít'],
            ['Bùi Văn Sơn', '0965123456', 'Lâm Đồng', 'Gói 1 lít'],
        ];

        foreach ($leads as $index => $lead) {
            Lead::query()->firstOrCreate(
                ['phone' => $lead[1]],
                [
                    'name' => $lead[0],
                    'address' => $lead[2],
                    'variant' => $lead[3],
                    'source' => 'demo',
                ],
            );
        }
    }
}
