-- Create database
CREATE DATABASE IF NOT EXISTS `login`;

-- Use the database
USE `login`;

-- Table: users (for user authentication)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
);

-- Table: cars
CREATE TABLE IF NOT EXISTS `cars` (
    `car_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `make` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `model` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `year` INT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `mileage` INT,
    `color` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    `image_url` VARCHAR(255)
);

-- Table: car_bookings
CREATE TABLE IF NOT EXISTS `car_bookings` (
    `booking_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `car_id` INT NOT NULL,
    `booking_date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    INDEX (`user_id`),
    INDEX (`car_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`car_id`) REFERENCES `cars`(`car_id`)
);


-- Table: hotels
CREATE TABLE IF NOT EXISTS `hotels` (
    `hotel_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `location` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
    `image_url` VARCHAR(255)
);


-- Table: hotel_bookings
CREATE TABLE IF NOT EXISTS `hotel_bookings` (
    `booking_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `hotel_id` INT NOT NULL,
    `booking_date` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    INDEX (`user_id`),
    INDEX (`hotel_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`hotel_id`) REFERENCES `hotels`(`hotel_id`)
);

CREATE TABLE IF NOT EXISTS `rentals` (
    `rental_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(100) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10,2) NOT NULL,
    `image_url` VARCHAR(255),
    `available_from` DATE,
    `bedrooms` INT,
    `bathrooms` INT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table: rental_bookings
CREATE TABLE IF NOT EXISTS `rental_bookings` (
    `booking_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `rental_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `total_price` DECIMAL(10,2) NOT NULL,
    `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`rental_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);


CREATE TABLE IF NOT EXISTS `car_rentals` (
    `rental_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(100) NOT NULL,
    `location` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10,2) NOT NULL,
    `image_url` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table: car_rental_bookings
CREATE TABLE IF NOT EXISTS `car_rentals_bookings` (
    `booking_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `rental_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`rental_id`) REFERENCES `car_rentals`(`rental_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);


-- Inserting Suzuki Ertiga 2023
INSERT INTO cars (make, model, year, price, mileage, description, image_url)
VALUES ('Suzuki', 'Ertiga', 2023, 25000.00, 15000, 'A spacious and comfortable MPV.', 'https://imgd.aeplcdn.com/1056x594/n/c6es93a_157212...');

-- Inserting Toyota Camry 2019
INSERT INTO cars (make, model, year, price, mileage, description, image_url)
VALUES ('Toyota', 'Camry', 2019, 25000.00, 20000, 'A reliable and comfortable sedan.', 'https://imgd.aeplcdn.com/664x374/n/cw/ec/110233/ca...');

-- Inserting Honda Civic 2018
INSERT INTO cars (make, model, year, price, mileage, description, image_url)
VALUES ('Honda', 'Civic', 2018, 22000.00, 15000, 'A fuel-efficient compact car.', 'https://imgd.aeplcdn.com/664x374/n/cw/ec/27074/civ...');

-- Inserting Ford Mustang 2020
INSERT INTO cars (make, model, year, price, mileage, description, image_url)
VALUES ('Ford', 'Mustang', 2020, 35000.00, 10000, 'A classic American muscle car.', 'https://imgd.aeplcdn.com/664x374/cw/ec/23766/Ford-...');

-- Inserting Chevrolet Malibu 2017
INSERT INTO cars (make, model, year, price, mileage, description, image_url)
VALUES ('Chevrolet', 'Malibu', 2017, 18000.00, 30000, 'A spacious and stylish sedan.', 'https://imgd.aeplcdn.com/642x336/ec/ec_amp/258.jpg...');


-- car_rentals insert
INSERT INTO car_rentals (title, location, description, price, image_url)
VALUES
    ('Maruti Suzuki Swift', 'Delhi', 'A popular hatchback known for its fuel efficiency ...', 5000.00, 'https://imgd.aeplcdn.com/664x374/cw/ec/26742/Marut...'),
    ('Hyundai i20', 'Mumbai', 'A stylish and comfortable hatchback with advanced ...', 5500.00, 'https://imgd.aeplcdn.com/664x374/n/cw/ec/150603/i2...'),
    ('Tata Nexon', 'Bangalore', 'An SUV offering a blend of power and safety featur...', 8000.00, 'https://imgd.aeplcdn.com/370x208/n/cw/ec/141867/ne...');


INSERT INTO hotels (name, location, price, description, image_url)
VALUES
    ('Hotel Paradise', 'New York', 150.00, 'A luxurious hotel in New York', 'https://imgcy.trivago.com/c_limit,d_dummy.jpeg,f_a...'),
    ('Sea View Hotel', 'Miami', 200.00, 'A beautiful sea view hotel in Miami', 'https://cf.bstatic.com/xdata/images/hotel/max1024x...'),
    ('Mountain Retreat', 'Denver', 180.00, 'A serene mountain retreat in Denver', 'https://intrinsicwellness.ca/wp-content/uploads/lo...'),
    ('City Central', 'Los Angeles', 120.00, 'A centrally located hotel in Los Angeles', 'https://www.mingtiandi.com/wp-content/uploads/2014...'),
    ('Lakeside Inn', 'Chicago', 140.00, 'A cozy inn by the lake in Chicago', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:AN...');


INSERT INTO rentals (title, location, description, price , image_url, available_from, bedrooms, bathrooms)
VALUES
    ('Beachfront Villa', 'Goa', 'Beautiful villa with direct beach access and stunning views.', 600.00, 'https://dynamic-media-cdn.tripadvisor.com/media/ph...', '2024-07-15', 4, 3),
    ('Mountain Chalet', 'Manali', 'Cozy chalet nestled in the Himalayas, perfect for ...', 350.00, 'https://seoimgak.mmtcdn.com/blog/sites/default/fil...', '2024-08-01', 2, 2),
    ('Urban Loft', 'Mumbai', 'Modern loft in the bustling city center, ideal for...', 200.00, 'https://studiomatarchitects.com/wp-content/uploads...', '2024-07-20', 1, 1),
    ('Riverside Cottage', 'Rishikesh', 'Peaceful cottage by the river, great for yoga retr...', 250.00, 'https://www.holidify.com/images/cmsuploads/compres...', '2024-07-25', 3, 2),
    ('Luxury Resort', 'Jaipur', 'Opulent resort in the Pink City, offering royal ac...', 500.00, 'https://media-cdn.tripadvisor.com/media/photo-s/1a...', '2024-08-10', 5, 4),
    ('Country House', 'Pune', 'Quaint country house surrounded by lush greenery, ...', 180.00, 'https://content.jdmagicbox.com/comp/pune/c8/020pxx...', '2024-07-30', 2, 1);
