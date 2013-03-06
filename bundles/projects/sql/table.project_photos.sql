CREATE TABLE project_photos
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	project_id INTEGER,
	section TEXT,
	caption TEXT,
	display_order INTEGER
)