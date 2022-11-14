create database if not exists phpprosjekt;
use phpprosjekt;

DROP TABLE IF EXISTS listingimages;
DROP TABLE IF EXISTS listings;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    userID int(11) NOT NULL AUTO_INCREMENT,
    email varchar(256) NOT NULL,
    firstName varchar(64) NOT NULL,
    lastName varchar(64) NOT NULL,
    pass varchar(300) NOT NULL,
    birthDate datetime NOT NULL,
    phone int(11) NOT NULL,
    isAdmin tinyint(1) DEFAULT 0,
    study varchar(45) NOT NULL,
    isStudent tinyint(1) DEFAULT 1,
    PRIMARY KEY (userID)
);


CREATE TABLE listings (
    listingID INT NOT NULL AUTO_INCREMENT,
    listingTitle VARCHAR(45) NOT NULL,
    listingDesc VARCHAR(1000) NOT NULL,
    listingAddress VARCHAR(100) NOT NULL,
    listingRooms INT NOT NULL,
    listingType VARCHAR(45) NOT NULL,
    listingPrice INT NOT NULL,
    listingArea INT NOT NULL,
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
    userID INT NOT NULL,
    PRIMARY KEY (listingID),
    FOREIGN KEY (userID) references user(userID) ON DELETE CASCADE
);


CREATE TABLE listingImages (
    listingImgID INT NOT NULL AUTO_INCREMENT,
    listingImgDesc VARCHAR(64),
    listingID INT NOT NULL,
    PRIMARY KEY (listingImgID),
    FOREIGN KEY (listingID) references Listings(listingID) ON DELETE CASCADE
);


CREATE TABLE messages (
    messageID INT NOT NULL AUTO_INCREMENT,
    messageText VARCHAR(500) NOT NULL,
    messageTime DATETIME NOT NULL,
    recieverID INT NOT NULL,
    senderID INT NOT NULL,
    PRIMARY KEY (messageID),
    FOREIGN KEY (recieverID) references user(userID) ON DELETE CASCADE,
    FOREIGN KEY (senderID) references user(userID) ON DELETE CASCADE
);

INSERT INTO user (email, firstName, lastName, pass, birthDate, phone, isAdmin, study, isStudent)
VALUES ('test@test.com', 'Ola', 'Pettersen', '$2y$10$9RrqR0Y37OMmiwEjJxLCoOfZHY2XaAWZVCn92Pla2qSLe11fZQgNi', '2001-11-11 00:00:00', 123456789, 1, 'IT and Informassjonsystemer', 0),
       ('test2@test.com', 'Petter', 'Olavson', '$2y$10$jUBZOi/EIr5EqDJ8L7WEEeY1nzAr3zcjziiiCNKPcvXDzc62Q2jci', '2001-01-01 00:00:00', 098765432, 0, 'Mattematikk', 1),
       ('test3@test.com', 'Lisa', 'Stein', '$2y$10$DjajGxSAzBXcAHH6ODEsG.L60U6663wfqyEkWQiIqiD4VzrRjfeXK', '1999-04-06 00:00:00', 23456774573, 0, 'IT og Informassjonsystemer', 1);

INSERT INTO listings (listingTitle, listingDesc, listingAddress, listingRooms, listingType, listingPrice, listingArea, petAllowed, hasParking, hasShed, isFurnished, hasAppliances, hasBalcony, hasGarden, wcFriendly, incElectricity, incWifi, canSmoke, forMen, forWomen, userID)
VALUES ('Kult hus', 'Dette huset er veldig kult, det har mange fine møbler', 'Fjellvegen 20', 5, 'Hybel', 5000, 20, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 0, 1, 1, 1);


INSERT INTO messages (messageText, messageTime, recieverID, senderID)
VALUES ('Hei, hvordan går det? Jeg er interessert i den boligen du låner ut', '2022-09-09 12:43:22', 1, 2),
       ('Åja er du det, så kult å høre!', '2022-09-09 12:33:22', 2, 1),
       ('Hallo hallo hallo!', '2022-09-09 12:13:22', 3, 1),
       ('Hei på deg hvordan går det??', '2022-09-09 12:03:22', 1, 3),
       ('Hus er kult, ditt hus er kult', '2022-09-09 13:23:22', 2, 3);
