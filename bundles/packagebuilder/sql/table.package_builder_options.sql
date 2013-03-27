CREATE TABLE package_builder_options
(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    section TEXT,
    small_price_1 INTEGER,
    small_price_2 INTEGER,
    small_description TEXT,
    medium_price_1 INTEGER,
    medium_price_2 INTEGER,
    medium_description TEXT,
    large_price_1 INTEGER,
    large_price_2 INTEGER,
    large_description TEXT,
    display_order INTEGER
)