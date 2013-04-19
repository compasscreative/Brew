CREATE TABLE team_members
(
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    first_name TEXT,
    last_name TEXT,
    title TEXT,
    bio TEXT,
    email TEXT,
    phone TEXT,
    category TEXT,
    display_order INTEGER,
    slug TEXT
)