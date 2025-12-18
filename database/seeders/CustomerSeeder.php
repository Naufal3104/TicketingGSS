<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'customer_id' => 'CUST001',
                'customer_name' => 'PT Sinarmas',
                'phone_number' => '08111111111',
                'email' => 'contact@sinarmas.com',
                'address_primary' => 'Jl. Thamrin No. 1, Jakarta Pusat',
                'status' => 'active',
            ],
            [
                'customer_id' => 'CUST002',
                'customer_name' => 'CV Abadi Jaya',
                'phone_number' => '08222222222',
                'email' => 'info@abadijaya.com',
                'address_primary' => 'Jl. Sudirman No. 50, Jakarta Selatan',
                'status' => 'active',
            ],
            [
                'customer_id' => 'CUST003',
                'customer_name' => 'Toko Maju Terus',
                'phone_number' => '08333333333',
                'email' => 'owner@maju.com',
                'address_primary' => 'Jl. Gatot Subroto No. 100, Jakarta Timur',
                'status' => 'active',
            ],
            [
                'customer_id' => 'CUST004',
                'customer_name' => 'PT Telkom Indonesia',
                'phone_number' => '08444444444',
                'email' => 'support@telkom.co.id',
                'address_primary' => 'Jl. Japati No. 1, Bandung',
                'status' => 'active',
            ],
            [
                'customer_id' => 'CUST005',
                'customer_name' => 'Bank BCA',
                'phone_number' => '08555555555',
                'email' => 'halo@bca.co.id',
                'address_primary' => 'Menara BCA, Jakarta',
                'status' => 'active',
            ],
        ];

        foreach ($customers as $customer) {
            \App\Models\Customer::firstOrCreate(
                ['customer_id' => $customer['customer_id']],
                $customer
            );
        }
    }
}
