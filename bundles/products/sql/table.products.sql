CREATE TABLE products
(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    title TEXT,
    introduction TEXT,
    description TEXT,
    title_tag TEXT,
    description_tag TEXT,
    display_order INTEGER
)