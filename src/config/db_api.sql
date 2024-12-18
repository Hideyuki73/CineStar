CREATE DATABASE api;

USE api;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nickname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(100) NOT NULL
);

CREATE TABLE movies (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(100) NOT NULL,
    rating FLOAT NOT NULL,
    id_users INT NOT NULL, 
    FOREIGN KEY (id_users) REFERENCES users (id)
);
