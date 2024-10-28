
--
-- Database: `chat`
--

-- --------------------------------------------------------

CREATE TABLE messages (
  message_id INT AUTO_INCREMENT PRIMARY KEY,
  message_sender VARCHAR(50) NOT NULL,
  message_receiver VARCHAR(50) NOT NULL,
  message text NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);