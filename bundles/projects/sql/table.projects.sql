CREATE TABLE projects
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	title TEXT,
	introduction TEXT,
	description TEXT,
	awards TEXT,
	show_lo_award INTEGER,
	completed_date TEXT
)