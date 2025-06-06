    <?php
require_once 'config/database.php'; 

try {
    // Create tables if they don't exist
    $db->exec("
        CREATE TABLE IF NOT EXISTS cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            price TEXT NOT NULL,
            rating REAL NOT NULL,
            category TEXT NOT NULL,
            engine TEXT NOT NULL,
            power TEXT NOT NULL,
            transmission TEXT NOT NULL,
            image TEXT NOT NULL, 
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL UNIQUE,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS car_features (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            car_id INTEGER NOT NULL,
            feature TEXT NOT NULL,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
        )
    ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS saved_cars (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL, 
            car_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
            -- FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE 
        )
    ");

    // Clear existing data
    $db->exec("DELETE FROM saved_cars");
    $db->exec("DELETE FROM car_features");
    $db->exec("DELETE FROM cars");
    // Reset autoincrement counters for SQLite
    $db->exec("DELETE FROM sqlite_sequence WHERE name='cars'");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='car_features'");
    $db->exec("DELETE FROM sqlite_sequence WHERE name='saved_cars'");


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
            'category' => 'Ultra Classic',
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
            'category' => 'Racing Legend Classic',
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
            'category' => 'Sports Classic',
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
            'category' => 'Rotary Classic',
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
            'category' => 'Small Sports Classic',
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
            'category' => 'Pony Car Classic',
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
            'category' => 'Sports Classic',
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
            'category' => 'Hot Hatch Classic',
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
            'category' => 'Drift Classic',
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
            'category' => 'Performance Classic',
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
            'category' => 'Turbo Classic',
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
            'category' => 'Elegant Classic',
            'engine' => '1.8L G180W DOHC Inline-4',
            'power' => 'Approx 120 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a7/1976_Isuzu_117_Coupe_XE_01.jpg/1280px-1976_Isuzu_117_Coupe_XE_01.jpg',
            'features' => ['Giugiaro Design', 'Luxury Coupe', 'Rare Japanese Classic']
        ],
        [
            'name' => 'Honda Prelude Si 4WS (3rd Gen BA4/BA5)',
            'price' => 'Rp 5.800.000',
            'rating' => 4.7,
            'category' => 'Tech Classic',
            'engine' => '2.0L B20A DOHC Inline-4',
            'power' => '135-145 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2b/1988_Honda_Prelude_Si_4WS_rear.jpg/1280px-1988_Honda_Prelude_Si_4WS_rear.jpg',
            'features' => ['Innovative 4WS', 'Sleek Design', 'Fun to Drive']
        ],
        [
            'name' => 'Nissan Pulsar GTI-R (RNN14)',
            'price' => 'Rp 8.500.000',
            'rating' => 4.8,
            'category' => 'Rally Classic',
            'engine' => '2.0L SR20DET Turbo I4',
            'power' => '227 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/9f/Nissan_Pulsar_GTi-R_001.jpg/1280px-Nissan_Pulsar_GTi-R_001.jpg',
            'features' => ['Baby Godzilla', 'Rally Homologation', 'AWD Turbo']
        ],
        [
            'name' => 'Autozam AZ-1',
            'price' => 'Rp 9.000.000',
            'rating' => 4.7,
            'category' => 'Kei Supercar Classic',
            'engine' => '657cc F6A Turbo Inline-3',
            'power' => '63 HP',
            'transmission' => '5-Speed Manual',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/99/Autozam_AZ-1_001.jpg/1280px-Autozam_AZ-1_001.jpg',
            'features' => ['Gullwing Doors', 'Mid-Engine Kei', 'Exotic Microcar']
        ]
    ];

    $all_cars = $initial_cars;

    // Insert cars and their features
    $db->exec('BEGIN TRANSACTION');

    $stmt_car = $db->prepare("
        INSERT INTO cars (name, price, rating, category, engine, power, transmission, image)
        VALUES (:name, :price, :rating, :category, :engine, :power, :transmission, :image)
    ");

    $stmt_feature = $db->prepare("
        INSERT INTO car_features (car_id, feature) VALUES (:car_id, :feature)
    ");

    foreach ($all_cars as $car_data) {

        $features_for_car = $car_data['features'];

        $car_insert_data = [
            'name' => $car_data['name'],
            'price' => $car_data['price'],
            'rating' => $car_data['rating'],
            'category' => $car_data['category'],
            'engine' => $car_data['engine'],
            'power' => $car_data['power'],
            'transmission' => $car_data['transmission'],
            'image' => $car_data['image']
        ];

        foreach ($car_insert_data as $key => $value) {
            $stmt_car->bindValue(':' . $key, $value);
        }

        $stmt_car->execute();
        $carId = $db->lastInsertRowID();

        if (is_array($features_for_car)) {
            foreach ($features_for_car as $feature_text) {
                $stmt_feature->bindParam(':car_id', $carId);
                $stmt_feature->bindParam(':feature', $feature_text);
                $stmt_feature->execute();
            }
        }
    }

    $db->exec('COMMIT');
    echo "Database setup completed successfully with " . count($all_cars) . " cars!";

} catch(PDOException $e) {
    if ($db->inTransaction()) {
        $db->rollBack();
    }
    echo "Setup failed: " . $e->getMessage();
} catch(Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
    }
    echo "An unexpected error occurred: " . $e->getMessage();
}
?>
