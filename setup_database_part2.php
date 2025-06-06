<?php
require_once 'config/database.php';

try {
    $initial_cars = [
        [
            'name' => 'Toyota Supra MK4',
            'price' => 'Rp 9.890.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.0L 2JZ-GTE Twin-Turbo I6',
            'power' => '320 HP',
            'transmission' => '6-Speed Manual',
            'image' => 'https://i.imgur.com/RR6G1kx.png',
            'features' => ['Exhibition Ready', 'Track Ready', 'Iconic Status']
        ],
        [
            'name' => 'Nissan GT-R R35',
            'price' => 'Rp 12.500.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.8L Twin-Turbo V6',
            'power' => '565 HP',
            'transmission' => '6-Speed Dual-Clutch',
            'image' => 'https://i.imgur.com/dzSuinX.jpeg',
            'features' => ['Exhibition Ready', 'Track Ready', 'Modern Classic']
        ],
        [
            'name' => 'Honda NSX Type-R',
            'price' => 'Rp 11.890.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '3.2L VTEC V6 (NA2)',
            'power' => '290 HP',
            'transmission' => '6-Speed Manual',
            'image' => 'https://i.imgur.com/i9ECUWZ.png',
            'features' => ['Exhibition Ready', 'Track Ready', 'Rare Find', 'Lightweight Special']
        ],
        [
            'name' => 'Mazda RX-7 FD Spirit R',
            'price' => 'Rp 8.190.000',
            'rating' => 4.8,
            'category' => 'Drift',
            'engine' => '1.3L Twin-Turbo Rotary (13B-REW)',
            'power' => '276 HP (official)',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/wQi4KPp.png',
            'features' => ['Drift Ready', 'Track Ready', 'Iconic Status', 'Rotary Power']
        ],
        [
            'name' => 'Toyota AE86 Sprinter Trueno GT-APEX',
            'price' => 'Rp 8.120.000',
            'rating' => 4.8,
            'category' => 'Drift',
            'engine' => '1.6L 4A-GE DOHC 16V',
            'power' => '128 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/0NHaHVS.png',
            'features' => ['Drift King Initial D', 'Exhibition Ready', 'Lightweight Legend', 'Hachi-Roku']
        ],
        [
            'name' => 'Toyota 2000GT',
            'price' => 'Rp 18.500.000',
            'rating' => 4.9,
            'category' => 'Classic',
            'engine' => '2.0L DOHC Inline-6',
            'power' => '150 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/ip4o0IA.png',
            'features' => ['James Bond Car', 'Extremely Rare', 'Japanese Supercar Icon']
        ],
        [
            'name' => 'Nissan Skyline GT-R KPGC10 Hakosuka',
            'price' => 'Rp 13.500.000',
            'rating' => 4.9,
            'category' => 'Performance',
            'engine' => '2.0L DOHC S20 Inline-6',
            'power' => '160 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/2GQbace.png',
            'features' => ['Hakosuka Legend', 'Touring Car Dominator', 'JDM Icon']
        ],
        [
            'name' => 'Datsun 240Z (Fairlady Z S30)',
            'price' => 'Rp 7.500.000',
            'rating' => 4.8,
            'category' => 'Classic',
            'engine' => '2.4L L24 Inline-6',
            'power' => '151 HP',
            'transmission' => '4-Speed Manual',
            'image' => 'https://i.imgur.com/329sfv0.png',
            'features' => ['Timeless Design', 'Affordable Sports Icon', 'Global Success']
        ],
        [
            'name' => 'Mazda Cosmo Sport 110S',
            'price' => 'Rp 11.000.000',
            'rating' => 4.8,
            'category' => 'Classic',
            'engine' => '0.98L Twin-Rotor Wankel (10A)',
            'power' => '110-128 HP',
            'transmission' => '4/5-Speed Manual',
            'image' => 'https://i.imgur.com/cWHwssM.png',
            'features' => ['First Rotary Production', 'Futuristic Styling', 'Rare Gem']
        ],
        [
            'name' => 'Honda S800 Coupe',
            'price' => 'Rp 6.500.000',
            'rating' => 4.7,
            'category' => 'Classic',
            'engine' => '0.8L DOHC Inline-4',
            'power' => '70 HP',
            'transmission' => '4-Speed Manual',
            'image' => 'https://i.imgur.com/yqvbPMf.png',
            'features' => ['High-Revving Engine', 'Motorcycle DNA', 'Lightweight Fun']
        ],
        [
            'name' => 'Toyota Celica Liftback GT (RA28/RA29)',
            'price' => 'Rp 4.800.000',
            'rating' => 4.6,
            'category' => 'Classic',
            'engine' => '2.0L 18R-G DOHC Inline-4',
            'power' => 'Approx 120 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/VvHx8k1.png',
            'features' => ['Japanese Mustang', 'Stylish Liftback', 'Reliable Classic']
        ],
        [
            'name' => 'Mazda RX-7 FB (SA22C GSL-SE)',
            'price' => 'Rp 6.800.000',
            'rating' => 4.7,
            'category' => 'Classic',
            'engine' => '1.3L 13B RE-EGI Rotary',
            'power' => '135 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://i.imgur.com/VSGSrjK.png',
            'features' => ['Pure Rotary Fun', 'Great Handling', '80s Icon']
        ],
        [
            'name' => 'Honda CR-X SiR (EF8 - 2nd Gen)',
            'price' => 'Rp 6.200.000',
            'rating' => 4.7,
            'category' => 'Classic',
            'engine' => '1.6L B16A DOHC VTEC Inline-4',
            'power' => '158 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/Honda_CR-X_SiR_001.jpg/1280px-Honda_CR-X_SiR_001.jpg',
            'features' => ['Nimble Handling', 'VTEC Pocket Rocket', 'Kammback Design']
        ],
        [
            'name' => 'Nissan Silvia K\'s S13 (SR20DET)',
            'price' => 'Rp 7.000.000',
            'rating' => 4.8,
            'category' => 'Drift',
            'engine' => '2.0L SR20DET Turbo I4',
            'power' => '202 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Nissan_Silvia_S13_Ks_001.jpg/1280px-Nissan_Silvia_S13_Ks_001.jpg',
            'features' => ['Drift King', 'Tunable SR20', 'Timeless Style']
        ],
        [
            'name' => 'Toyota Supra MkIII Turbo A (MA70)',
            'price' => 'Rp 8.900.000',
            'rating' => 4.7,
            'category' => 'Performance',
            'engine' => '3.0L 7M-GTEU Turbo I6',
            'power' => '267 HP',
            'transmission' => '5-Speed Manual (R154)',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/e/e7/Toyota_Supra_Turbo_A_front.jpg/1280px-Toyota_Supra_Turbo_A_front.jpg',
            'features' => ['Group A Homologation', 'Limited Edition', '80s Powerhouse']
        ],
        [
            'name' => 'Mitsubishi Starion ESI-R (Widebody)',
            'price' => 'Rp 6.700.000',
            'rating' => 4.6,
            'category' => 'Performance',
            'engine' => '2.6L G54B Turbo I4',
            'power' => '176 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Mitsubishi_Starion_Turbo_EX_001.jpg/1280px-Mitsubishi_Starion_Turbo_EX_001.jpg',
            'features' => ['Widebody Styling', '80s Turbo Power', 'Distinctive Looks']
        ],
        [
            'name' => 'Isuzu 117 Coupé XE',
            'price' => 'Rp 7.300.000',
            'rating' => 4.7,
            'category' => 'Classic',
            'engine' => '1.8L G180W DOHC Inline-4',
            'power' => 'Approx 120 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/1976_Isuzu_117_Coupe_XE_01.jpg/1280px-1976_Isuzu_117_Coupe_XE_01.jpg',
            'features' => ['Giugiaro Design', 'Luxury Coupe', 'Rare Japanese Classic']
        ]
    ];

    // Insert cars and their features
    foreach ($initial_cars as $car_data) {
        $features_for_car = $car_data['features'];

        $stmt_car = $db->prepare("
            INSERT INTO cars (name, price, rating, category, engine, power, transmission, image)
            VALUES (:name, :price, :rating, :category, :engine, :power, :transmission, :image)
        ");

        $stmt_car->bindValue(':name', $car_data['name']);
        $stmt_car->bindValue(':price', $car_data['price']);
        $stmt_car->bindValue(':rating', $car_data['rating']);
        $stmt_car->bindValue(':category', $car_data['category']);
        $stmt_car->bindValue(':engine', $car_data['engine']);
        $stmt_car->bindValue(':power', $car_data['power']);
        $stmt_car->bindValue(':transmission', $car_data['transmission']);
        $stmt_car->bindValue(':image', $car_data['image']);
        $stmt_car->execute();

        $carId = $db->lastInsertRowID();

        if (is_array($features_for_car)) {
            foreach ($features_for_car as $feature_text) {
                $stmt_feature = $db->prepare("
                    INSERT INTO car_features (car_id, feature) VALUES (:car_id, :feature)
                ");
                $stmt_feature->bindValue(':car_id', $carId);
                $stmt_feature->bindValue(':feature', $feature_text);
                $stmt_feature->execute();
            }
        }
    }

    echo "Database setup completed successfully with " . count($initial_cars) . " cars!";

} catch (Exception $e) {
    echo "Setup failed: " . $e->getMessage();
}
?>
