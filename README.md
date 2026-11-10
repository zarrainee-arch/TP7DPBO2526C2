
# TP7DPBO2526C2

### JANJI

Saya Zahra Qurrota Aini dengan NIM 2510155 mengerjakan soal TP 7 dalam mata kuliah Desain Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

### MUSETRACK

MUSETRACK is a web-based music management system developed using PHP Native and MySQL. This application allows users to manage music artists, genres, and songs through CRUD (Create, Read, Update, Delete) operations.

## Project Description

MUSETRACK provides a simple platform to organize music collections. Users can manage artist information, categorize music genres, and maintain song records with their corresponding artists and genres.

## Features

### Dashboard
- Display total number of artists.
- Display total number of genres.
- Display total number of songs.
- Show recently added songs.

### Artists Management
- Add new artist.
- View artist collection.
- Edit artist information.
- Delete artist.

### Genres Management
- Add new genre.
- View genre collection.
- Edit genre information.
- Delete genre.

### Songs Management
- Add new song.
- View song collection.
- Edit song information.
- Delete song.
- Associate songs with artists and genres.

## Technologies Used

- PHP Native
- MySQL / MariaDB
- PDO (PHP Data Objects)
- HTML
- CSS
- XAMPP

## Database Structure

The application uses three main tables:

1. **artists**
   - id
   - artist_name
   - country
   - debut_year

2. **genres**
   - id
   - genre_name
   - description

3. **songs**
   - id
   - title
   - artist_id
   - genre_id
   - release_year
   - duration

### Database Relationships

- One artist can have multiple songs.
- One genre can have multiple songs.
- The songs table contains foreign keys referencing artists and genres.

## Project Structure

```text
tp7/
├── class/
│   ├── Artist.php
│   ├── Genre.php
│   └── Song.php
├── config/
│   └── db.php
├── database/
│   └── musetrack.sql
├── view/
│   ├── header.php
│   ├── footer.php
│   ├── artists.php
│   ├── edit_artist.php
│   ├── genres.php
│   ├── edit_genre.php
│   ├── songs.php
│   └── edit_song.php
├── index.php
├── style.css
└── README.md
```

## Installation and Setup

1. Install XAMPP.
2. Start Apache and MySQL.
3. Copy the project folder into `htdocs`.
4. Open phpMyAdmin.
5. Create a database named `musetrack`.
6. Import the `database/musetrack.sql` file.
7. Make sure the database configuration in `config/db.php` matches your local MySQL settings.
8. Open the application in your browser:

   http://localhost/tp7/

## Security and Implementation

- Object-Oriented Programming (OOP) is implemented using PHP classes.
- Each entity has its own class.
- Database operations use PDO Prepared Statements.
- Foreign keys maintain relationships between tables.
- HTML output is escaped using htmlspecialchars().

## Author

Developed as a Database and Object-Oriented Programming course practical assignment.

## License

This project is developed for educational purposes.
