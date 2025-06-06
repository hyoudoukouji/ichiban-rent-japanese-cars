-- First, clear existing data
DELETE FROM saved_cars;
DELETE FROM car_features;
DELETE FROM cars;

-- Reset auto-increment
ALTER TABLE cars AUTO_INCREMENT = 1;
ALTER TABLE car_features AUTO_INCREMENT = 1;
ALTER TABLE saved_cars AUTO_INCREMENT = 1;

-- Insert cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Toyota Supra MK4', 'Rp 9.890.000', 4.9, 'Performance', '3.0L 2JZ-GTE Twin-Turbo I6', '320 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESupra MK4%3C/text%3E%3C/svg%3E'),
('Nissan GT-R R35', 'Rp 12.500.000', 4.9, 'Performance', '3.8L Twin-Turbo V6', '565 HP', '6-Speed Dual-Clutch', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGT-R R35%3C/text%3E%3C/svg%3E'),
('Honda NSX Type-R', 'Rp 7.890.000', 4.9, 'Performance', '3.0L VTEC V6', '290 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ENSX Type-R%3C/text%3E%3C/svg%3E');

-- Insert features for each car
INSERT INTO car_features (car_id, feature) VALUES
(1, 'Exhibition Ready'),
(1, 'Track Ready'),
(1, 'Iconic Status'),
(2, 'Exhibition Ready'),
(2, 'Track Ready'),
(2, 'Modern Classic'),
(3, 'Exhibition Ready'),
(3, 'Track Ready'),
(3, 'Rare Find');

-- Continue with more cars...
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Nissan Silvia S15', 'Rp 4.590.000', 4.7, 'Drift', '2.0L SR20DET Turbo', '250 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESilvia S15%3C/text%3E%3C/svg%3E'),
('Toyota AE86 Trueno', 'Rp 8.120.000', 4.8, 'Drift', '1.6L 4A-GE', '130 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EAE86%3C/text%3E%3C/svg%3E');

-- Insert features for these cars
INSERT INTO car_features (car_id, feature) VALUES
(4, 'Drift Ready'),
(4, 'Exhibition Ready'),
(4, 'Popular Choice'),
(5, 'Drift Ready'),
(5, 'Exhibition Ready'),
(5, 'Iconic Status');

-- And so on for all 30 cars...
