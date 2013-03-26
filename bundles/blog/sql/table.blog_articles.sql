CREATE TABLE blog_articles
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	category_id INTEGER,
	title TEXT,
	body TEXT,
	status TEXT,
	published_date TEXT
)