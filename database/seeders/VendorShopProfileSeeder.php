<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorShopProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendor = new Vendor();

        $user = User::query()->where('email', '=', 'vendor@gmail.com')->first();

        $vendor->user_id = $user->id;
        $vendor->shop_name = 'Vendor Shop';
        $vendor->banner = 'uploads/1234.jpg';
        $vendor->phone = '1212121212';
        $vendor->email = 'vendor@gmail.com';
        $vendor->address = '123 Address Location';
        $vendor->description = 'This is a description';

        $vendor->save();
    }
}
