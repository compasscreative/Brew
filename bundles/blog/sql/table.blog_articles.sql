CREATE TABLE blog_articles
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	category_id INTEGER,
    type TEXT,
	title TEXT,
	body TEXT,
	status TEXT,
	published_date TEXT
)