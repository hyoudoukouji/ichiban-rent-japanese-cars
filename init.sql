-- First, clear existing data
DELETE FROM saved_cars;
DELETE FROM car_features;
DELETE FROM cars;

-- Reset auto-increment
ALTER TABLE cars AUTO_INCREMENT = 1;
ALTER TABLE car_features AUTO_INCREMENT = 1;
ALTER TABLE saved_cars AUTO_INCREMENT = 1;

-- Insert Performance Cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Toyota Supra MK4', 'Rp 9.890.000', 4.9, 'Performance', '3.0L 2JZ-GTE Twin-Turbo I6', '320 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESupra MK4%3C/text%3E%3C/svg%3E'),
('Nissan GT-R R35', 'Rp 12.500.000', 4.9, 'Performance', '3.8L Twin-Turbo V6', '565 HP', '6-Speed Dual-Clutch', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGT-R R35%3C/text%3E%3C/svg%3E'),
('Honda NSX Type-R', 'Rp 7.890.000', 4.9, 'Performance', '3.0L VTEC V6', '290 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ENSX Type-R%3C/text%3E%3C/svg%3E'),
('Lexus LFA', 'Rp 15.990.000', 4.9, 'Performance', '4.8L V10', '552 HP', '6-Speed Automated Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ELexus LFA%3C/text%3E%3C/svg%3E'),
('Subaru WRX STI', 'Rp 6.890.000', 4.7, 'Performance', '2.5L Turbo Boxer', '310 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EWRX STI%3C/text%3E%3C/svg%3E'),
('Mitsubishi Evolution X', 'Rp 6.590.000', 4.8, 'Performance', '2.0L Turbo I4', '291 HP', 'Twin-Clutch SST', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EEvo X%3C/text%3E%3C/svg%3E'),
('Nissan GT-R R33', 'Rp 8.990.000', 4.8, 'Performance', '2.6L Twin-Turbo I6', '276 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGT-R R33%3C/text%3E%3C/svg%3E'),
('Mazda RX-8 Spirit R', 'Rp 5.990.000', 4.7, 'Performance', '1.3L RENESIS Rotary', '232 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ERX-8 Spirit R%3C/text%3E%3C/svg%3E');

-- Insert Drift Cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Nissan Silvia S15', 'Rp 4.590.000', 4.7, 'Drift', '2.0L SR20DET Turbo', '250 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESilvia S15%3C/text%3E%3C/svg%3E'),
('Toyota AE86 Trueno', 'Rp 8.120.000', 4.8, 'Drift', '1.6L 4A-GE', '130 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EAE86%3C/text%3E%3C/svg%3E'),
('Nissan 180SX', 'Rp 4.290.000', 4.6, 'Drift', '2.0L SR20DET Turbo', '205 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E180SX%3C/text%3E%3C/svg%3E'),
('Mazda RX-7 FD', 'Rp 7.190.000', 4.8, 'Drift', '1.3L Twin-Turbo Rotary', '276 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ERX-7 FD%3C/text%3E%3C/svg%3E'),
('Nissan Silvia S14', 'Rp 4.390.000', 4.7, 'Drift', '2.0L SR20DET Turbo', '220 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ESilvia S14%3C/text%3E%3C/svg%3E'),
('Toyota Chaser JZX100', 'Rp 5.790.000', 4.7, 'Drift', '2.5L 1JZ-GTE Turbo', '280 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EChaser JZX100%3C/text%3E%3C/svg%3E');

-- Insert Classic Cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Toyota 2000GT', 'Rp 25.990.000', 5.0, 'Classic', '2.0L Straight-6', '150 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E2000GT%3C/text%3E%3C/svg%3E'),
('Nissan Skyline GT-R KPGC10', 'Rp 18.990.000', 4.9, 'Classic', '2.0L Straight-6', '160 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EHakosuka%3C/text%3E%3C/svg%3E'),
('Mazda Cosmo Sport', 'Rp 22.990.000', 4.9, 'Classic', '1.0L Twin-Rotor', '130 HP', '4-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ECosmo Sport%3C/text%3E%3C/svg%3E'),
('Honda S800', 'Rp 19.990.000', 4.8, 'Classic', '0.8L I4', '70 HP', '4-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ES800%3C/text%3E%3C/svg%3E'),
('Toyota Celica GT', 'Rp 15.990.000', 4.8, 'Classic', '1.6L 2T-G', '115 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ECelica GT%3C/text%3E%3C/svg%3E'),
('Datsun 240Z', 'Rp 17.990.000', 4.9, 'Classic', '2.4L L24 I6', '151 HP', '4-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E240Z%3C/text%3E%3C/svg%3E');

-- Insert Modern Cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Toyota GR Yaris', 'Rp 8.990.000', 4.8, 'Modern', '1.6L Turbo I3', '268 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGR Yaris%3C/text%3E%3C/svg%3E'),
('Honda Civic Type R FK8', 'Rp 7.990.000', 4.8, 'Modern', '2.0L Turbo I4', '316 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EType R FK8%3C/text%3E%3C/svg%3E'),
('Subaru BRZ', 'Rp 5.990.000', 4.7, 'Modern', '2.4L Boxer', '228 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EBRZ%3C/text%3E%3C/svg%3E'),
('Nissan Z Proto', 'Rp 9.990.000', 4.8, 'Modern', '3.0L Twin-Turbo V6', '400 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EZ Proto%3C/text%3E%3C/svg%3E'),
('Toyota GR86', 'Rp 6.290.000', 4.7, 'Modern', '2.4L Boxer', '228 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EGR86%3C/text%3E%3C/svg%3E');

-- Insert JDM Cars
INSERT INTO cars (name, price, rating, category, engine, power, transmission, image) VALUES
('Mitsubishi 3000GT VR-4', 'Rp 6.990.000', 4.7, 'JDM', '3.0L Twin-Turbo V6', '320 HP', '6-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3E3000GT%3C/text%3E%3C/svg%3E'),
('Toyota Celica GT-Four', 'Rp 5.990.000', 4.7, 'JDM', '2.0L Turbo I4', '252 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3ECelica GT-Four%3C/text%3E%3C/svg%3E'),
('Nissan Pulsar GTI-R', 'Rp 4.990.000', 4.6, 'JDM', '2.0L Turbo I4', '227 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EPulsar GTI-R%3C/text%3E%3C/svg%3E'),
('Honda Integra Type R DC2', 'Rp 5.990.000', 4.8, 'JDM', '1.8L VTEC I4', '200 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EDC2 Type R%3C/text%3E%3C/svg%3E'),
('Toyota MR2 SW20', 'Rp 4.790.000', 4.7, 'JDM', '2.0L Turbo I4', '200 HP', '5-Speed Manual', 'data:image/svg+xml,%3Csvg width=\'300\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'300\' height=\'200\' fill=\'%231a1a1a\'/%3E%3Ctext x=\'150\' y=\'100\' font-family=\'Arial\' font-size=\'20\' fill=\'white\' text-anchor=\'middle\'%3EMR2 SW20%3C/text%3E%3C/svg%3E');

-- Insert features for Performance Cars
INSERT INTO car_features (car_id, feature) VALUES
(1, 'Exhibition Ready'), (1, 'Track Ready'), (1, 'Iconic Status'),
(2, 'Exhibition Ready'), (2, 'Track Ready'), (2, 'Modern Classic'),
(3, 'Exhibition Ready'), (3, 'Track Ready'), (3, 'Rare Find'),
(4, 'Exhibition Ready'), (4, 'Track Ready'), (4, 'Limited Edition'),
(5, 'Rally Ready'), (5, 'Daily Driver'), (5, 'All-Weather'),
(6, 'Rally Ready'), (6, 'Track Ready'), (6, 'Daily Driver'),
(7, 'Track Ready'), (7, 'ATTESA E-TS'), (7, 'Group A Heritage'),
(8, 'Track Ready'), (8, 'Rotary Power'), (8, 'Limited Edition');

-- Insert features for Drift Cars
INSERT INTO car_features (car_id, feature) VALUES
(9, 'Drift Ready'), (9, 'Exhibition Ready'), (9, 'Popular Choice'),
(10, 'Drift Ready'), (10, 'Exhibition Ready'), (10, 'Iconic Status'),
(11, 'Drift Ready'), (11, 'Exhibition Ready'), (11, 'Classic Appeal'),
(12, 'Drift Ready'), (12, 'Track Ready'), (12, 'Iconic Status'),
(13, 'Drift Ready'), (13, 'Exhibition Ready'), (13, 'Popular Choice'),
(14, 'Drift Ready'), (14, 'Luxury Sedan'), (14, '2JZ Power');

-- Insert features for Classic Cars
INSERT INTO car_features (car_id, feature) VALUES
(15, 'Museum Quality'), (15, 'Exhibition Ready'), (15, 'Ultra Rare'),
(16, 'Museum Quality'), (16, 'Exhibition Ready'), (16, 'Legendary Status'),
(17, 'Museum Quality'), (17, 'Exhibition Ready'), (17, 'First Rotary'),
(18, 'Museum Quality'), (18, 'Exhibition Ready'), (18, 'Racing Heritage'),
(19, 'Museum Quality'), (19, 'Exhibition Ready'), (19, 'Racing Heritage'),
(20, 'Museum Quality'), (20, 'Exhibition Ready'), (20, 'Design Icon');

-- Insert features for Modern Cars
INSERT INTO car_features (car_id, feature) VALUES
(21, 'Rally Ready'), (21, 'Daily Driver'), (21, 'Limited Production'),
(22, 'Track Ready'), (22, 'Daily Driver'), (22, 'Record Holder'),
(23, 'Track Ready'), (23, 'Daily Driver'), (23, 'Perfect Balance'),
(24, 'Retro Design'), (24, 'Track Ready'), (24, 'Latest Tech'),
(25, 'Track Ready'), (25, 'Daily Driver'), (25, 'Perfect Balance');

-- Insert features for JDM Cars
INSERT INTO car_features (car_id, feature) VALUES
(26, 'All-Weather'), (26, 'Track Ready'), (26, 'Advanced Tech'),
(27, 'Rally Heritage'), (27, 'All-Weather'), (27, 'Group A Homologation'),
(28, 'Rally Heritage'), (28, 'All-Weather'), (28, 'Rare Find'),
(29, 'Track Ready'), (29, 'VTEC Power'), (29, 'Legendary Status'),
(30, 'Mid-Engine'), (30, 'Track Ready'), (30, 'Snap Oversteer');
