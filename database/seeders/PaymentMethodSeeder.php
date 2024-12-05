<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Upload;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'original_name' => 'bank-logo.svg',
                'new_name' => 'bank-logo.svg',
                'path' => 'uploads/payment-methods/bank-logo.svg',
                'size' => 0,
                'extension' => 'svg',
                'type' => 'image/svg+xml',
                'payment_methods' => [
                    [
                        'name' => 'Bank',
                        'description' => 'Bank card payment method',
                    ]
                ],
            ],
            [
                'original_name' => 'paypal.svg',
                'new_name' => 'paypal.svg',
                'path' => 'uploads/payment-methods/paypal.svg',
                'size' => 0,
                'extension' => 'svg',
                'type' => 'image/svg+xml',
                'payment_methods' => [
                    [
                        'name' => 'PayPal',
                        'description' => 'PayPal payment method',
                    ]
                ],
            ],
            [
                'original_name' => 'crypto-icon.png',
                'new_name' => 'crypto-icon.png',
                'path' => 'uploads/payment-methods/crypto-icon.png',
                'size' => 0,
                'extension' => 'png',
                'type' => 'image/png',
                'payment_methods' => [
                    [
                        'name' => 'Crypto',
                        'description' => 'Crypto payment method',
                    ]
                ],
            ]
        ];

        foreach ($methods as $method) {
            $upload = Upload::query()->create([
                'original_name' => $method['original_name'],
                'new_name' => $method['new_name'],
                'path' => $method['path'],
                'size' => $method['size'],
                'extension' => $method['extension'],
                'type' => $method['type'],
            ]);

            PaymentMethod::query()->create([
                'name' => $method['payment_methods'][0]['name'],
                'description' => $method['payment_methods'][0]['description'],
                'logo' => $upload->id,
            ]);
        }
    }
}
