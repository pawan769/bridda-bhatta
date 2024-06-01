-- Create the database
-- CREATE DATABASE e_governance;

-- Use the database
USE e_governance;

-- Create the register_info table
CREATE TABLE register_info (
    cit_id INT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone_no VARCHAR(15),
    email VARCHAR(255) UNIQUE NOT NULL,
    DOB DATE,
    gender CHAR(1)
);

-- Create the login_info table
CREATE TABLE login_info (
    cit_id INT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (cit_id) REFERENCES register_info(cit_id)
);

-- Create the image_info table
CREATE TABLE image_info (
    id INT PRIMARY KEY AUTO_INCREMENT,
    img_name VARCHAR(255),
    cit_image BLOB,
    cit_id INT,
    FOREIGN KEY (cit_id) REFERENCES register_info(cit_id)
);

-- Create the account_info table
CREATE TABLE account_info (
    cit_id INT PRIMARY KEY,
    Amount DECIMAL(10, 2),
    arrival_date DATE,
    withdraw_date DATE,
    FOREIGN KEY (cit_id) REFERENCES register_info(cit_id)
);
