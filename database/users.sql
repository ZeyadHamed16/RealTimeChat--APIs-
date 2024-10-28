
--
-- Database: `chat`
--

-- --------------------------------------------------------

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  user_username VARCHAR(50) UNIQUE NOT NULL,
  user_email VARCHAR(50) UNIQUE NOT NULL,
  user_password VARCHAR(255) NOT NULL,
  user_gender ENUM ('Male', 'Female') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);