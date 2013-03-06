CREATE TABLE leads
(
	id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	submitted_date TEXT,
	ip_address TEXT,
	name TEXT,
	email TEXT,
	phone TEXT,
	address TEXT,
	interest TEXT,
	budget TEXT,
	message TEXT,
	referral TEXT,
	url TEXT
)