CREATE TABLE product_photos
(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    caption TEXT,
    display_order INTEGER
)