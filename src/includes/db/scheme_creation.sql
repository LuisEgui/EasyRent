-- Author: Luis Egui

-- Create the database/schema
create database if not exists easyrent_db 
    character set utf8mb4 
    collate utf8mb4_0900_ai_ci;

-- Select the created database to be used 
use easyrent_db;

-- Create a common user, before this statement make sure
-- you have logged in with an admin user (root):
create user if not exists 'user'@'localhost' 
    identified by '1234';
grant all privileges on `easyrent_db`.* TO 'user'@'localhost';

-- Aux: show active users in the db:
-- select user from mysql.user;
