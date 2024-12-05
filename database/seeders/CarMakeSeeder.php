<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarMake;
use App\Models\CarModel;
use App\Models\CarVariant;
use App\Models\Upload;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Nette\Schema\Schema;

class CarMakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carMakes = [
            [
                'name' => 'Toyota',
                'logo' => [
                    'original_name' => 'toyota.png',
                    'new_name' => 'toyota.png',
                    'path' => 'uploads/car-makes/toyota.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Land Cruiser 78', 'Land Cruiser 76', 'Land Cruiser 79', 'Land Cruiser Prado',
                    'Land Cruiser 300', 'Hilux', 'Rav4', 'Hiace', 'Coaster', 'Sienna',
                    'Sequoia', 'Tacoma', 'Crown', 'Tundra', 'Venza', '4runner',
                    'BZ4X', 'Camry', 'Corolla', 'Corolla Cross', 'GR86', 'Supra',
                    'Highlander', 'Mirai', 'Prius'
                ]
            ],
            [
                'name' => 'Nissan',
                'logo' => [
                    'original_name' => 'nissan.png',
                    'new_name' => 'nissan.png',
                    'path' => 'uploads/car-makes/nissan.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Patrol', 'Kicks', 'X-trail', 'X-terra', 'Pathfinder', 'Patrol Safari',
                    'Sunny', 'Altima', 'Nissan Z', 'Urvan'
                ]
            ],
            [
                'name' => 'Mercedes-Benz',
                'logo' => [
                    'original_name' => 'mercedes.png',
                    'new_name' => 'mercedes.png',
                    'path' => 'uploads/car-makes/mercedes.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'A-Class', 'EQE Sedan', 'EQS Sedan', 'A-Class Sedan', 'C-Class Sedan',
                    'E-Class Sedan', 'S-Class Sedan', 'Mercedes – Maybach S-Class',
                    'EQA', 'EQB', 'EQS SUV', 'Maybach EQS SUV', 'Electric G-Class',
                    'GLA', 'GLB', 'GLC SUV', 'GLS', 'Maybach GLS', 'G-Class',
                    'CLA Coupe', 'GLC Coupe', 'GLE Coupe', 'CLE Coupe', 'AMG GT Coupe',
                    'AMG GT 4 Door Coupe', 'Maybach SL 680 Monogram Series',
                    'CLE Cabriolet', 'SL Roadster'
                ]
            ],
            [
                'name' => 'BMW',
                'logo' => [
                    'original_name' => 'bmw.png',
                    'new_name' => 'bmw.png',
                    'path' => 'uploads/car-makes/bmw.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'XM', 'X7', 'X7 M60i', 'X6', 'X6 M', 'X5', 'X5 M', 'X4', 'X4 M',
                    'X3', 'X3 M50 xDrive', 'X3 Plug-in-Hybrid', 'X1', 'iX2', 'X2',
                    'X2 M35i xDrive', 'X1 M35i xDrive', 'IX', 'iX3', 'iX1', 'M760e',
                    'M8 competition convertible', 'M8 Competition Coupe', 'M5 sedan',
                    'M440i Gran Coupe', 'M4 Convertible', 'M4 Competition', 'M3 Competition',
                    'M235i Gran Coupe', 'M2 Coupe', 'i7 M70', 'i5 M60 xDrive', 'i4 M50',
                    'Z4 M40i', '8 Gran Coupe', 'The 7', '6 Gran Turismo', 'The 5',
                    '4 Gran coupe', '4 Convertible', '2 Gran Coupe', '2 Coupe'
                ]
            ],
            [
                'name' => 'Ford',
                'logo' => [
                    'original_name' => 'ford.png',
                    'new_name' => 'ford.png',
                    'path' => 'uploads/car-makes/ford.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Mustang', 'Taurus', 'Next gen Everest', 'Territory', 'Edge',
                    'Edge ST', 'Expedition', 'Bronco Raptor', 'Bronco', 'Explorer',
                    'Explorer ST', 'Next gen ranger', 'Next gen ranger raptor',
                    'F-150', 'F-150 raptor', 'F-150 tremor', 'Super duty',
                    'Super duty chassis cab', 'Transit range'
                ]
            ],
            [
                'name' => 'Lexus',
                'logo' => [
                    'original_name' => 'lexus.png',
                    'new_name' => 'lexus.png',
                    'path' => 'uploads/car-makes/lexus.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Ux', 'Nx', 'Rx 350', 'Lx 600', 'Is', 'Es', 'Ls', 'Esh', 'NXh',
                    'Rx 350h', 'LSh', 'UXh', 'Rc', 'RX 500H', 'RC F', 'Lc 500', 'Lc Convertible'
                ]
            ],
            [
                'name' => 'Hyundai',
                'logo' => [
                    'original_name' => 'hyundai.png',
                    'new_name' => 'hyundai.png',
                    'path' => 'uploads/car-makes/hyundai.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Creta', 'Venue', 'Azera', 'Santa Fe', 'Stargazer', 'Accent', 'Sonata',
                    'Elantra', 'Kona', 'Tucson', 'Staria', 'Palisade', 'Ioniq'
                ]
            ],
            [
                'name' => 'Volkswagen',
                'logo' => [
                    'original_name' => 'volkswagen.png',
                    'new_name' => 'volkswagen.png',
                    'path' => 'uploads/car-makes/volkswagen.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Golf GTI', 'Golf R', 'T-Roc', 'Tiguan', 'Touareg', 'Teramont', 'Amarok'
                ]
            ],
            [
                'name' => 'Chevrolet',
                'logo' => [
                    'original_name' => 'chevrolet.png',
                    'new_name' => 'chevrolet.png',
                    'path' => 'uploads/car-makes/chevrolet.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Groove', 'Captiva', 'Traverse', 'Blazer', 'Tahoe', 'Suburban',
                    'Silverado HD', 'Silverado LD', 'Camaro', 'Camaro ZL1', 'Corvette',
                    'Corvette E-Ray', 'Corvette Z06', 'Express'
                ]
            ],
            [
                'name' => 'Kia',
                'logo' => [
                    'original_name' => 'kia.png',
                    'new_name' => 'kia.png',
                    'path' => 'uploads/car-makes/kia.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Picanto', 'Pegas', 'K3', 'K5', 'K8', 'Cerato', 'Sonet', 'Seltos',
                    'Sportage', 'Sorento', 'Telluride', 'Carens', 'Carnival', 'EV6', 'EV9'
                ]
            ],
            [
                'name' => 'Audi',
                'logo' => [
                    'original_name' => 'audi.png',
                    'new_name' => 'audi.png',
                    'path' => 'uploads/car-makes/audi.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'E-tron GT quattro', 'Q8 e-tron', 'Q8 Sportback e-tron', 'SQ* Sportback e-tron',
                    'A3 Sedan', 'S3 Sedan', 'S3 Sportback', 'RS 3 Sedan', 'RS Sportback', 'A4 Sedan',
                    'RS 4 Avant', 'A5 Coupe', 'A5 Sportback', 'S5 Coupe', 'S5 Sportback', 'RS 5 Sportback',
                    'A6 Sedan', 'A6 Avant', 'S6 Sedan', 'RS 6 Avant performance', 'A7 Sportback',
                    'S7 Sportback', 'RS 7 Sportback', 'A8 L', 'S8', 'A8', 'Q2', 'Q3', 'Q3 Sportback',
                    'Q5', 'Q5 Sportback', 'SQ5', 'SQ5 Sportback', 'Q7', 'SQ7', 'Q8', 'SQ8', 'RS Q8',
                    'R8 Coupe RWD', 'R8 Spyder RWD'
                ]
            ],
            [
                'name' => 'Land Rover',
                'logo' => [
                    'original_name' => 'land_rover.png',
                    'new_name' => 'land_rover.png',
                    'path' => 'uploads/car-makes/land_rover.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Range Rover', 'Range Rover Sport', 'Range Rover Velar', 'Range Rover Evoque',
                    'Defender 130', 'Defender 110', 'Defender 90', 'Discovery', 'Discovery Sport'
                ]
            ],
            [
                'name' => 'Honda',
                'logo' => [
                    'original_name' => 'honda.png',
                    'new_name' => 'honda.png',
                    'path' => 'uploads/car-makes/honda.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'City', 'Civic Sport', 'Accord 1.5L', 'Civic Type R', 'HR-V', 'ZR-V', 'CR-V', 'Pilot',
                    'Accord E: HEV'
                ]
            ],
            [
                'name' => 'Porsche',
                'logo' => [
                    'original_name' => 'porsche.png',
                    'new_name' => 'porsche.png',
                    'path' => 'uploads/car-makes/porsche.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    '718 Cayman', '718 Boxster', '718 Cayman GT4 RS', '718 Spyder RS', '911 Carrera',
                    '911 Carrera Cabriolet', '911 Targa $ GTS', '911 Turbo', '911 Turbo Cabriolet',
                    '911 GT3 RS', '911 Turbo 50 years', 'Taycan', 'Taycan Cross Turismo',
                    'Panamera', 'Panamera $E-Hybrid executive', 'Macan', 'Macan Electric',
                    'Cayenne', 'Cayenne Coupe'
                ]
            ],
            [
                'name' => 'Jeep',
                'logo' => [
                    'original_name' => 'jeep.png',
                    'new_name' => 'jeep.png',
                    'path' => 'uploads/car-makes/jeep.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Grand Wagoneer', 'Grand Cherokee', 'Wrangler', 'Gladiator', 'Commander',
                    'Meridian', 'Renegade'
                ]
            ],
            [
                'name' => 'GMC',
                'logo' => [
                    'original_name' => 'GMC.png',
                    'new_name' => 'GMC.png',
                    'path' => 'uploads/car-makes/GMC.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Yukon At4', 'Yukon Denali', 'Terrain', 'Terrain SLE', 'Terrain At4', 'Terrain Denali',
                    'Hummer EV Pickup', 'Sierra Heavy Duty', 'Sierra HD Pro SLE', 'Sierra HD Pro SLT',
                    'Sierra HD Denali', 'Canyon AT 4X', 'Sierra LD', 'Sierra LD SLE', 'Sierra LD Elevation',
                    'Sierra LD SLT', 'Sierra LD AT4', 'Sierra LD AT4X', 'Sierra LD Denali', 'Sierra LD Denali Ultimate',
                    'Yukon SLE', 'Yukon SLT', 'Hummer EV SUV'
                ]
            ],
            [
                'name' => 'Jaguar',
                'logo' => [
                    'original_name' => 'jaguar.png',
                    'new_name' => 'jaguar.png',
                    'path' => 'uploads/car-makes/jaguar.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['I-Pace', 'F-Pace', 'E-Pace', 'F-Type']
            ],
            [
                'name' => 'Volvo',
                'logo' => [
                    'original_name' => 'volvo.png',
                    'new_name' => 'volvo.png',
                    'path' => 'uploads/car-makes/volvo.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['S90', 'S60', 'XC90', 'XC60', 'XC40', 'C40', 'EX30']
            ],
            [
                'name' => 'Mazda',
                'logo' => [
                    'original_name' => 'Mazda.png',
                    'new_name' => 'Mazda.png',
                    'path' => 'uploads/car-makes/Mazda.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['A3 Hatchback', 'A3 Sedan', 'A6 Sedan', 'CX-3', 'CX-30', 'CX-5', 'CX-60', 'CX-90', 'MX-5']
            ],
            [
                'name' => 'Cadillac',
                'logo' => [
                    'original_name' => 'cadillac.png',
                    'new_name' => 'cadillac.png',
                    'path' => 'uploads/car-makes/cadillac.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Escalade IQ', 'Escalade 2025', 'Escalade 2024', 'XT6', 'Lyriq', 'Optiq',
                    'XT5', 'XT4', 'Celestiq', 'CT5 V-Series', '2024 CT5', 'CT4 V-Series',
                    'CT4', '2025 CT5', 'Escalade -V', 'CT5 V-Series'
                ]
            ],
            [
                'name' => 'Mitsubishi',
                'logo' => [
                    'original_name' => 'mitsubishi.png',
                    'new_name' => 'mitsubishi.png',
                    'path' => 'uploads/car-makes/mitsubishi.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    '2025 Outlander PHEV', '2024 Outlander', 'Outlander Sport', 'Eclipse Cross',
                    'Mirage', 'Mirage G4'
                ]
            ],
            [
                'name' => 'Tesla',
                'logo' => [
                    'original_name' => 'tesla.png',
                    'new_name' => 'tesla.png',
                    'path' => 'uploads/car-makes/tesla.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Model S', 'Model 3', 'Model X', 'Model Y', 'Cybertruck'
                ]
            ],
            [
                'name' => 'RAM',
                'logo' => [
                    'original_name' => 'RAM.png',
                    'new_name' => 'RAM.png',
                    'path' => 'uploads/car-makes/RAM.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Ram 1500 2024', 'Ram 1500 2025']
            ],
            [
                'name' => 'Dodge',
                'logo' => [
                    'original_name' => 'dodge.png',
                    'new_name' => 'dodge.png',
                    'path' => 'uploads/car-makes/dodge.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Hornet', 'Charger', 'Challenger', 'Durango']
            ],
            [
                'name' => 'Bentley',
                'logo' => [
                    'original_name' => 'bentley.png',
                    'new_name' => 'bentley.png',
                    'path' => 'uploads/car-makes/bentley.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Bentayga Extended Wheelbase', 'Bentayga', 'New Flying Spur', 'Continental GT',
                    'Continental GT Convertible', 'Mulliner', 'Hybrid Range'
                ]
            ],
            [
                'name' => 'Rolls Royce',
                'logo' => [
                    'original_name' => 'rolls_royce.png',
                    'new_name' => 'rolls_royce.png',
                    'path' => 'uploads/car-makes/rolls_royce.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Phantom', 'Phantom Extended', 'Spectre', 'Ghost', 'Ghost Extended',
                    'Cullinan Series II', 'Black Badge'
                ]
            ],
            [
                'name' => 'Aston Martin',
                'logo' => [
                    'original_name' => 'aston_martin.png',
                    'new_name' => 'aston_martin.png',
                    'path' => 'uploads/car-makes/aston_martin.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Vantage', 'DB12', 'Vanquish', 'DBX', 'Valhalla', 'Valkyrie', 'Valour', 'Valiant', 'Amr24'
                ]
            ],
            [
                'name' => 'Infiniti',
                'logo' => [
                    'original_name' => 'infiniti.png',
                    'new_name' => 'infiniti.png',
                    'path' => 'uploads/car-makes/infiniti.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Q50', 'QX50', 'QX55', 'Qx60', 'QX80']
            ],
            [
                'name' => 'Mini',
                'logo' => [
                    'original_name' => 'mini.png',
                    'new_name' => 'mini.png',
                    'path' => 'uploads/car-makes/mini.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Electric Mini cooper', 'Electric Mini Aceman', 'Electric Mini Countryman', 'Mini Cooper', 'Mini Cooper 5 door', 'Mini Countryman', 'Mini convertible']
            ],
            [
                'name' => 'Suzuki',
                'logo' => [
                    'original_name' => 'suzuki.png',
                    'new_name' => 'suzuki.png',
                    'path' => 'uploads/car-makes/suzuki.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Baleno', 'Swift', 'Jimmy', 'Dzire', 'Ertiga', 'Ciaz', 'Eeco', 'Grand Vitara', 'Fronx', 'Jimmy 5 door']
            ],
            [
                'name' => 'MG',
                'logo' => [
                    'original_name' => 'MG.png',
                    'new_name' => 'MG.png',
                    'path' => 'uploads/car-makes/MG.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['MG 7', 'MG 3', 'MG Whale', 'MG HS', 'MG HS PHEV', 'MG One', 'MG RX5', 'MG GT', 'MG RX8 Black edition', 'MG RX8', 'MG ZST', 'MG 5', 'MG ZS EV', 'MG T60', 'MG 4 Electric']
            ],
            [
                'name' => 'Renault',
                'logo' => [
                    'original_name' => 'renault.png',
                    'new_name' => 'renault.png',
                    'path' => 'uploads/car-makes/renault.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Duster', 'Koleos', 'Megane Sedan', 'Arkana', 'Express Van', 'Master', 'Megane R.S.']
            ],
            [
                'name' => 'Peugeot',
                'logo' => [
                    'original_name' => 'peugeot.png',
                    'new_name' => 'peugeot.png',
                    'path' => 'uploads/car-makes/peugeot.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Peugeot 3008', 'Peugeot 3008 electric', 'Peugeot 208', 'Peugeot 2008',
                    'Landtrek', 'Peugeot 408', 'Peugeot 5008', 'Partner', 'Expert', 'Traveller', 'Boxer'
                ]
            ],
            [
                'name' => 'Genesis',
                'logo' => [
                    'original_name' => 'genesis.png',
                    'new_name' => 'genesis.png',
                    'path' => 'uploads/car-makes/genesis.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Electrified G80', 'G70', 'G80', 'G90', 'G70 Shooting Brake', 'GV70', 'GV80',
                    'Electrified GV70', 'GV60', 'GV80 Coupe'
                ]
            ],
            [
                'name' => 'Alfa Romeo',
                'logo' => [
                    'original_name' => 'alfa_romeo.png',
                    'new_name' => 'alfa_romeo.png',
                    'path' => 'uploads/car-makes/alfa_romeo.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Tonale', 'Stelvio', 'Giulia', 'Stelvio Quadrifoglio', 'Giulia Quadrifoglio'
                ]
            ],
            [
                'name' => 'Maserati',
                'logo' => [
                    'original_name' => 'maserati.png',
                    'new_name' => 'maserati.png',
                    'path' => 'uploads/car-makes/maserati.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Grecale', 'Levante', 'GranTurismo', 'GranCabrio', 'MC20', 'MC20 Cielo',
                    'GT2 Stradale', 'Folgore', 'Fuoriserie'
                ]
            ],
            [
                'name' => 'Isuzu',
                'logo' => [
                    'original_name' => 'isuzu.png',
                    'new_name' => 'isuzu.png',
                    'path' => 'uploads/car-makes/isuzu.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Single cabin / Flatbed', '2.	Crew Cab']
            ],
            [
                'name' => 'GAC',
                'logo' => [
                    'original_name' => 'GAC.png',
                    'new_name' => 'GAC.png',
                    'path' => 'uploads/car-makes/GAC.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['GS3 Emzoom', 'Emkoo', 'Empow', 'GS8', 'GA4', 'M8', 'Emkoo Hybrid']
            ],
            [
                'name' => 'GWM',
                'logo' => [
                    'original_name' => 'GWM.png',
                    'new_name' => 'GWM.png',
                    'path' => 'uploads/car-makes/GWM.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Haval jolion', 'Havakl Jolion pro', 'Haval H6', 'Haval H6 Hybrid', 'H6GT', 'Dargo', 'Tank 300', 'Tank 300 hybrid', 'Tank 500', 'Tank 500 HEV', 'Wingle 5', 'Wingle 7', 'Poer']
            ],
            [
                'name' => 'Geely',
                'logo' => [
                    'original_name' => 'Geely.png',
                    'new_name' => 'Geely.png',
                    'path' => 'uploads/car-makes/Geely.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Preface', 'Starray', 'Okavango', 'Tygella', 'Monjaro', 'Geometry c', 'Coolray', 'Emgrand']
            ],
            [
                'name' => 'Jetour',
                'logo' => [
                    'original_name' => 'Jetour.png',
                    'new_name' => 'Jetour.png',
                    'path' => 'uploads/car-makes/Jetour.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['T2', 'Dashing', 'X90 Plus', 'X70 FL', 'X70 Plus']
            ],
            [
                'name' => 'Lamborghini',
                'logo' => [
                    'original_name' => 'lamborghini.png',
                    'new_name' => 'lamborghini.png',
                    'path' => 'uploads/car-makes/lamborghini.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'Temerario', 'Revuelto', 'Urus SE', 'Urus S', 'Urus Perfomate', 'Huracan Sterrato',
                    'Huracan Tecnica', 'Huracan STO', 'Huracan Evo Spyder'
                ]
            ],
            [
                'name' => 'Ferrari',
                'logo' => [
                    'original_name' => 'ferrari.png',
                    'new_name' => 'ferrari.png',
                    'path' => 'uploads/car-makes/ferrari.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => [
                    'SF90 Stradale', 'SF90 Spider', '296 GTB', '296 GTS', 'Ferrari 12Cilindri',
                    'Ferrari 12Cilindri Spider', 'Purosangue', 'Roma', 'Ferrari Roma Spider'
                ]
            ],
            [
                'name' => 'BYD',
                'logo' => [
                    'original_name' => 'BYD.png',
                    'new_name' => 'BYD.png',
                    'path' => 'uploads/car-makes/BYD.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Han', 'Sael', 'Atto 3', 'Song Plus', 'Qin Plus']
            ],
            [
                'name' => 'NIO',
                'logo' => [
                    'original_name' => 'NIO.png',
                    'new_name' => 'NIO.png',
                    'path' => 'uploads/car-makes/NIO.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['ET7', 'ET9', 'EC6', 'ET5T', 'ES6', 'EC7', 'ES8', 'ET5', 'ES7']
            ],
            [
                'name' => 'Li Auto',
                'logo' => [
                    'original_name' => 'li_auto.png',
                    'new_name' => 'li_auto.png',
                    'path' => 'uploads/car-makes/li_auto.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['X9', 'G9', 'G6', 'P7', 'P5', 'G31']
            ],
            [
                'name' => 'Chery',
                'logo' => [
                    'original_name' => 'chery.png',
                    'new_name' => 'chery.png',
                    'path' => 'uploads/car-makes/chery.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Tiggo 4 Pro', 'Tiggo 8 pro Max', 'Tiggo 8 pro Plug in hybrid', 'Tiggo 7 Pro Max']
            ],
            [
                'name' => 'Changan',
                'logo' => [
                    'original_name' => 'changan.png',
                    'new_name' => 'changan.png',
                    'path' => 'uploads/car-makes/changan.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['Alsvin', 'CS35 Plus', 'CS85', 'CS95', 'Eado Plus', 'CS75 Plus']
            ],
            [
                'name' => 'JAC',
                'logo' => [
                    'original_name' => 'JAC.png',
                    'new_name' => 'JAC.png',
                    'path' => 'uploads/car-makes/JAC.png',
                    'size' => 0,
                    'extension' => 'png',
                    'type' => 'image/png',
                ],
                'models' => ['JS8', 'J7 Plus', 'J7', 'JS6', 'JS7', 'JS4', 'JS3', 'JS2', 'T9', 'T8 pro', 'T6', 'Sunray', 'e-J7', 'e-JS4', 'e-JS1']
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        CarVariant::query()->truncate();
        CarModel::query()->truncate();
        CarMake::query()->truncate();

        $i = 0;
        foreach ($carMakes as $brand) {
            $upload = Upload::query()->create([
                'original_name' => $brand['logo']['original_name'],
                'new_name' => $brand['logo']['new_name'],
                'path' => $brand['logo']['path'],
                'size' => $brand['logo']['size'],
                'extension' => $brand['logo']['extension'],
                'type' => $brand['logo']['type'],
            ]);


            $carMake = CarMake::query()->create([
                'name' => $brand['name'],
                'logo' => $upload->id,
                'order' => $i,
                'is_featured' => $i <= 9,
                'official_website' => 'https://www.' . strtolower(str_replace(' ', '', $brand['name'])) . '.com',
            ]);

            foreach ($brand['models'] as $modelName) {
                CarModel::query()->create([
                    'car_make_id' => $carMake->id,
                    'name' => $modelName,
                ]);
            }
            $i++;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
