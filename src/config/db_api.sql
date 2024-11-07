CREATE DATABASE api_db;

USE api_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(100) NOT NULL,
);

CREATE TABLE rating {
    rating FLOAT,
    FOREIGN KEY (id_users) REFERENCES users(id),  
    FOREIGN KEY (id_movies) REFERENCES movies(id)
}