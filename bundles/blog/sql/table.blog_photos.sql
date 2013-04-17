CREATE TABLE blog_photos
(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    article_id INTEGER,
    caption TEXT,
    display_order INTEGER
)