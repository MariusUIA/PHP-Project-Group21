create database if not exists Database21;
use Database21;

CREATE TABLE Users (
                       userID INT NOT NULL auto_increment unique,
                       firstName VARCHAR(64),
                       lastName VARCHAR(64),
                       email VARCHAR(64) NOT NULL,
                       phoneNumber INT,
                       birthDate DATE NOT NULL,
                       PRIMARY KEY (userID)
);