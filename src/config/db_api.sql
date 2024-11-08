CREATE DATABASE api;

USE api_db;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL
);

CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(100) NOT NULL
);

CREATE TABLE rating (
    id SERIAL PRIMARY KEY,
    rating FLOAT,
	id_users INT,
	id_movies INT,
    FOREIGN KEY (id_users) REFERENCES users(id),  
    FOREIGN KEY (id_movies) REFERENCES movies(id)
);