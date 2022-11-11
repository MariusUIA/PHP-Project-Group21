create database if not exists phpprosjekt;
use phpprosjekt;

CREATE TABLE user (
                      userID int(11) NOT NULL,
                      userName varchar(64) NOT NULL,
                      email varchar(256) NOT NULL,
                      firstName varchar(64) NOT NULL,
                      lastName varchar(64) NOT NULL,
                      pass varchar(300) NOT NULL,
                      birthDate datetime NOT NULL,
                      phone int(11) NOT NULL,
                      isAdmin tinyint(4) DEFAULT 0,
                      study varchar(45) NOT NULL,
                      isStudent tinyint(4) DEFAULT 1,
                      PRIMARY KEY (userID)
);

CREATE TABLE listings (
                      listingID INT NOT NULL,
                      listingTitle VARCHAR(45) NOT NULL,
                      listingDesc VARCHAR(1000) NOT NULL,
                      listingAddress VARCHAR(100) NOT NULL,
                      listingRooms INT NOT NULL,
                      listingType VARCHAR(45) NOT NULL,
                      petAllowed TINYINT NOT NULL DEFAULT 0,
                      hasParking TINYINT NOT NULL DEFAULT 0,
                      hasShed TINYINT NOT NULL DEFAULT 0,
                      isFurnished TINYINT NOT NULL DEFAULT 0,
                      hasAppliances TINYINT NOT NULL DEFAULT 0,
                      hasBalcony TINYINT NOT NULL DEFAULT 0,
                      hasGarden TINYINT NOT NULL DEFAULT 0,
                      wcFriendly TINYINT NOT NULL DEFAULT 0,
                      incElectricity TINYINT NOT NULL DEFAULT 0,
                      incWifi TINYINT NOT NULL DEFAULT 0,
                      canSmoke TINYINT NOT NULL DEFAULT 0,
                      forMen TINYINT NOT NULL DEFAULT 0,
                      forWomen TINYINT NOT NULL DEFAULT 0,
                      PRIMARY KEY (listingID)
);