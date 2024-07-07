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
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
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
    FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`)
);
