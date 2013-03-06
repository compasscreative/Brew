CREATE TABLE gallery_photos
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	gallery_id INTEGER,
	caption TEXT,
	display_order INTEGER
)