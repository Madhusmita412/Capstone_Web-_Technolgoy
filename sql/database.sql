-- FixIt Smart Complaint Management System Database Schema
-- Created for College Complaint Management Portal

CREATE DATABASE IF NOT EXISTS `complaint_system`;
USE `complaint_system`;

-- Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `roll_number` VARCHAR(20),
  `department` VARCHAR(50),
  `phone` VARCHAR(15),
  `user_type` ENUM('student', 'admin') DEFAULT 'student',
  `status` ENUM('active', 'inactive') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `email_idx` (`email`),
  INDEX `user_type_idx` (`user_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Complaints Table
CREATE TABLE IF NOT EXISTS `complaints` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `priority` ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
  `status` ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending',
  `assigned_to` INT,
  `resolution_notes` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resolved_at` DATETIME,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  INDEX `user_id_idx` (`user_id`),
  INDEX `status_idx` (`status`),
  INDEX `category_idx` (`category`),
  INDEX `priority_idx` (`priority`),
  INDEX `created_at_idx` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(200),
  `message` LONGTEXT NOT NULL,
  `read_status` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `email_idx` (`email`),
  INDEX `created_at_idx` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Admin Activity Log Table
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `admin_id` INT NOT NULL,
  `action` VARCHAR(200),
  `complaint_id` INT,
  `details` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`admin_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`complaint_id`) REFERENCES `complaints`(`id`) ON DELETE SET NULL,
  INDEX `admin_id_idx` (`admin_id`),
  INDEX `created_at_idx` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Sample Admin User (password: admin@123)
INSERT INTO `users` (`name`, `email`, `password`, `user_type`, `department`) VALUES 
('Admin User', 'admin@fixit.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LLa', 'admin', 'Administration');
