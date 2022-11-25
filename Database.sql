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
    listingImgType VARCHAR(10),
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
    listingImgType VARCHAR(10),
    listingID INT NOT NULL,
    listingMainImg TINYINT NOT NULL DEFAULT 0,
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
       ('test2@test.com', 'Petter', 'Olavson', '$2y$10$6WEN2LzNTNDAtaQjiKIZwuS/UfuTsbQMlT1Pat07Sztx4frGMyJvm', '2001-01-01 00:00:00', 098765432, 0, 'Mattematikk', 1),
       ('test3@test.com', 'Lisa', 'Stein', '$2y$10$DjajGxSAzBXcAHH6ODEsG.L60U6663wfqyEkWQiIqiD4VzrRjfeXK', '1999-04-06 00:00:00', 23456774573, 0, 'IT og Informassjonsystemer', 1);

INSERT INTO listings (listingTitle, listingDesc, listingAddress, listingRooms, listingType, listingImgType, listingPrice, listingArea, petAllowed, hasParking, hasShed, isFurnished, hasAppliances, hasBalcony, hasGarden, wcFriendly, incElectricity, incWifi, canSmoke, forMen, forWomen, userID)
VALUES ('Kult hus', 'Dette huset er veldig kult, det har mange fine møbler', 'Fjellvegen 20', 5, 'Hybel', 'jpg', 5000, 20, 1, 1, 0, 1, 1, 0, 0, 1, 1, 1, 0, 1, 1, 1),
       ('Fin hybel', 'Dette huset er veldig kult, det har noen ting her og der', 'Utenforvegen 12', 8, 'Hybel', 'jpg', 5500, 50, 1, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 1, 0, 2),
       ('Beste felleskap', 'Dette huset er veldig kult eller kanskje det ikke er det?', 'Steinstien 8B', 4, 'Bofelleskap', 'jpg', 2000, 10, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 2),
       ('Blå Hybel', 'Dette huset er blått, bare kom og se!', 'Rødlands 2', 8, 'Hybel', 'jpg', 7000, 60, 1, 0, 1, 0, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1),
       ('Altsammen Kollektivet', 'Her bor har vi alt!', 'Lampegata 6C', 6, 'Bofelleskap', 'jpg', 5000, 20, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
       ('Ingenting Boligen', 'Denne boligen har ingenting, så merkelig', 'Skogsplassen 27', 7, 'Hybel', 'jpg', 2750, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2),
       ('EksempelHus 1', 'Tilfeldig generert', 'Addresse 1', 5, 'Hybel', 'jpg', 7632, 12, 0, 1, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 0, 2),
       ('EksempelHus 2', 'Tilfeldig generert', 'Addresse 2', 4, 'Hybel', 'jpg', 4234, 14, 1, 0, 1, 1, 0, 1, 0, 1, 1, 1, 0, 0, 1, 1),
       ('EksempelHus 3', 'Tilfeldig generert', 'Addresse 3', 6, 'Hybel', 'jpg', 9827, 24, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 1, 2),
       ('EksempelHus 4', 'Tilfeldig generert', 'Addresse 4', 7, 'Hybel', 'jpg', 4789, 14, 1, 0, 1, 0, 0, 1, 0, 1, 1, 1, 0, 1, 0, 1),
       ('EksempelHus 5', 'Tilfeldig generert', 'Addresse 5', 9, 'Hybel', 'jpg', 5802, 16, 1, 1, 1, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 2),
       ('EksempelHus 6', 'Tilfeldig generert', 'Addresse 6', 8, 'Hybel', 'jpg', 7312, 10, 1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1),
       ('EksempelKollektiv 1', 'Tilfeldig generert', 'Testvegen 1', 2, 'Bofelleskap', 'jpg', 2341, 8, 1, 0, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1, 0, 1),
       ('EksempelKollektiv 2', 'Tilfeldig generert', 'Testvegen 2', 4, 'Bofelleskap', 'jpg', 8570, 17, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0, 2),
       ('EksempelKollektiv 3', 'Tilfeldig generert', 'Testvegen 3', 7, 'Bofelleskap', 'jpg', 5678, 12, 1, 1, 0, 0, 0, 0, 0, 1, 0, 1, 0, 1, 1, 2),
       ('EksempelKollektiv 4', 'Tilfeldig generert', 'Testvegen 4', 6, 'Bofelleskap', 'jpg', 4567, 13, 0, 1, 1, 1, 1, 0, 1, 1, 0, 1, 1, 1, 1, 1);

INSERT INTO listingimages (listingImgID, listingImgDesc, listingImgType, listingID)
VALUES (1, 'Dette er et bilde', 'jpg', 1);

INSERT INTO messages (messageText, messageTime, recieverID, senderID)
VALUES ('Hei, hvordan går det? Jeg er interessert i den boligen du låner ut', '2022-09-09 12:03:22', 1, 2),
       ('Åja er du det, så kult å høre!', '2022-09-09 12:13:22', 2, 1),
       ('Jepp det er veldig kult, når kan jeg kjøpe den?', '2022-09-09 12:23:22', 1, 2),
       ('Den kan du kjøpe snart, eller noe', '2022-09-09 12:43:22', 2, 1),
       ('Virkelig? Den er tilgjengelig snart?', '2022-09-09 12:53:32', 1, 2),
       ('Hallo hallo hallo!', '2022-09-09 12:13:22', 3, 1),
       ('Hei på deg hvordan går det??', '2022-09-09 12:03:22', 1, 3),
       ('Hus er kult, ditt hus er kult', '2022-09-09 13:23:22', 2, 3);
