-- Loriz Bakery: database schema
--
-- Reconstructed from the application's SQL queries. The original database was
-- hosted on a plan that has since expired, so this file was rebuilt from the
-- INSERT/SELECT/JOIN statements in the PHP source. Table and column names match
-- the code exactly. Column data types and the foreign key relationships are
-- inferred from how each field is used and are a best effort reconstruction
-- rather than a dump of the original.
--
-- Engine: InnoDB, charset utf8mb4.

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------------
-- Staff accounts for the inventory dashboard (lb_login.php, dashboard_sidebar.php)
-- ---------------------------------------------------------------------------
CREATE TABLE lb_users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL UNIQUE,
    user_pass   VARCHAR(255) NOT NULL,          -- currently stored as plain text; see TODO
    first_name  VARCHAR(100),
    last_name   VARCHAR(100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Product catalogue (menu.php, view_product.php, add_product.php)
-- ---------------------------------------------------------------------------
CREATE TABLE lb_products (
    product_id   INT AUTO_INCREMENT PRIMARY KEY,
    name         VARCHAR(255) NOT NULL,
    price        DECIMAL(10,2) NOT NULL,
    description  TEXT,
    category     VARCHAR(50),                   -- 'Loaves', 'Buns', 'Snacks'
    image_url    VARCHAR(255),
    availability VARCHAR(50) DEFAULT 'In Stock',
    quantity     INT DEFAULT 0,
    bb_date      DATE                           -- best-before date
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- Note: delete_product.php references a column `id` on this table, while every
-- other query uses `product_id`. That mismatch is a known bug (see TODO.md),
-- so the primary key here is product_id to match the rest of the app.

-- ---------------------------------------------------------------------------
-- Guest cart line items, keyed by the session cart id (cart.php, menu.php)
-- ---------------------------------------------------------------------------
CREATE TABLE lb_cart_items (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    cart_id     VARCHAR(255) NOT NULL,          -- from uniqid('cart_', true)
    product_id  INT NOT NULL,
    variant     VARCHAR(50),
    quantity    INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_cart_product
        FOREIGN KEY (product_id) REFERENCES lb_products (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Placed orders (place_order.php)
-- ---------------------------------------------------------------------------
CREATE TABLE lb_orders (
    order_id       INT NOT NULL PRIMARY KEY,    -- generated in PHP via random_int(), not auto-increment
    customer_name  VARCHAR(255) NOT NULL,
    email          VARCHAR(255),
    phone_number   VARCHAR(20),
    payment_method VARCHAR(50),
    total_amount   DECIMAL(10,2) NOT NULL,
    pickup_date    DATE,
    created_at     DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- Line items for each order, with the price captured at purchase time
-- ---------------------------------------------------------------------------
CREATE TABLE lb_order_items (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    order_id    INT NOT NULL,
    product_id  INT NOT NULL,
    quantity    INT NOT NULL,
    variant     VARCHAR(50),
    price       DECIMAL(10,2) NOT NULL,         -- unit price at time of order
    CONSTRAINT fk_orderitem_order
        FOREIGN KEY (order_id) REFERENCES lb_orders (order_id),
    CONSTRAINT fk_orderitem_product
        FOREIGN KEY (product_id) REFERENCES lb_products (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
