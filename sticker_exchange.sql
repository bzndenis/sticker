-- Tabel users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    is_admin TINYINT(1) DEFAULT 0,
    last_login DATETIME NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NULL
);

-- Tabel sticker_categories
CREATE TABLE sticker_categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    created_at DATETIME NOT NULL,
    updated_at DATETIME
);

-- Tabel stickers
CREATE TABLE stickers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    number INT NOT NULL,
    image_path VARCHAR(255),
    image_hash VARCHAR(32),
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    FOREIGN KEY (category_id) REFERENCES sticker_categories(id),
    UNIQUE KEY unique_category_number (category_id, number)
);

-- Tabel user_stickers
CREATE TABLE user_stickers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    sticker_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    is_for_trade TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (sticker_id) REFERENCES stickers(id),
    UNIQUE KEY unique_user_sticker (user_id, sticker_id)
);

-- Tabel trades
CREATE TABLE trades (
    id INT PRIMARY KEY AUTO_INCREMENT,
    requester_id INT NOT NULL,
    owner_id INT NOT NULL,
    requested_sticker_id INT NOT NULL,
    offered_sticker_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected', 'cancelled') DEFAULT 'pending',
    created_at DATETIME NOT NULL,
    updated_at DATETIME,
    FOREIGN KEY (requester_id) REFERENCES users(id),
    FOREIGN KEY (owner_id) REFERENCES users(id),
    FOREIGN KEY (requested_sticker_id) REFERENCES stickers(id),
    FOREIGN KEY (offered_sticker_id) REFERENCES stickers(id)
);

-- Tabel chat_messages
CREATE TABLE chat_messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    trade_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL,
    is_delivered TINYINT(1) DEFAULT 1,
    FOREIGN KEY (trade_id) REFERENCES trades(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tabel notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    reference_id INT,
    reference_type VARCHAR(50),
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Indeks untuk optimasi query
CREATE INDEX idx_user_stickers_user ON user_stickers(user_id);
CREATE INDEX idx_user_stickers_sticker ON user_stickers(sticker_id);
CREATE INDEX idx_trades_requester ON trades(requester_id);
CREATE INDEX idx_trades_owner ON trades(owner_id);
CREATE INDEX idx_notifications_user ON notifications(user_id);
CREATE INDEX idx_stickers_category ON stickers(category_id);
CREATE INDEX idx_chat_trade ON chat_messages(trade_id);
CREATE INDEX idx_chat_user ON chat_messages(user_id);

-- Tambahkan index untuk optimasi query chat
ALTER TABLE chat_messages
ADD INDEX idx_trade_user (trade_id, user_id),
ADD INDEX idx_status (is_read, read_at),
ADD INDEX idx_chat_created (created_at); 