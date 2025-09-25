-- SK Officials Table Structure
-- Add this to your existing pms_db database

CREATE TABLE `sk_officials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert default SK Officials data
INSERT INTO `sk_officials` (`position`, `name`, `contact`, `email`, `age`, `address`, `start_date`, `status`) VALUES
('chairman', 'Juan Dela Cruz', '0917-123-4567', 'chairman@sk.gov.ph', 25, 'Barangay Hall, Main Street', '2024-01-15', 'active'),
('secretary', 'Maria Santos', '0918-234-5678', 'secretary@sk.gov.ph', 23, 'Phase 1, Block 2, Lot 5', '2024-01-15', 'active'),
('treasurer', 'Pedro Garcia', '0919-345-6789', 'treasurer@sk.gov.ph', 24, 'Purok 3, Sitio Maligaya', '2024-01-15', 'active'),
('kagawad1', 'Anna Reyes', '0920-456-7890', 'anna@sk.gov.ph', 22, 'Phase 2, Block 1, Lot 10', '2024-01-15', 'active'),
('kagawad2', 'Carlos Lopez', '0921-567-8901', 'carlos@sk.gov.ph', 26, 'Purok 1, Sitio Bagong Silang', '2024-01-15', 'active'),
('kagawad3', 'Sofia Martinez', '0922-678-9012', 'sofia@sk.gov.ph', 21, 'Phase 3, Block 5, Lot 8', '2024-01-15', 'active'),
('kagawad4', 'Miguel Torres', '0923-789-0123', 'miguel@sk.gov.ph', 27, 'Purok 2, Sitio San Roque', '2024-01-15', 'active');
