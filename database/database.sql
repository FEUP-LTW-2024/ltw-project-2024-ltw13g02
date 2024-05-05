/*******************************************************************************
   Database - Version 0.3
********************************************************************************/

DROP TABLE IF EXISTS Country;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS UserAdmin;
DROP TABLE IF EXISTS Reviews;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Sizes;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Chat;
DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS Favorites;
DROP TABLE IF EXISTS Recent;
DROP TABLE IF EXISTS Shipping;
DROP TABLE IF EXISTS Photo;

/*******************************************************************************
   Create Tables
********************************************************************************/

CREATE TABLE IF NOT EXISTS Country (
    idCountry INTEGER PRIMARY KEY NOT NULL , 
    country TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS User (
  idUser VARCHAR PRIMARY KEY UNIQUE NOT NULL,
  firstName VARCHAR NOT NULL,
  lastName VARCHAR NOT NULL,
  phone INTEGER CHECK (phone >= 200000000 AND phone <= 999999999) NOT NULL,
  email TEXT UNIQUE NOT NULL,
  userPassword VARCHAR NOT NULL,
  stars INTEGER DEFAULT "0",
  photo TEXT DEFAULT "Sem FF",
  idCountry TEXT REFERENCES Country (idCountry) ON DELETE SET NULL,
  city TEXT NOT NULL,
  userAddress TEXT NOT NULL,
  zipCode TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS UserAdmin (
    idUser INTEGER REFERENCES User (idUser) ON DELETE CASCADE PRIMARY KEY NOT NULL 
);

CREATE TABLE IF NOT EXISTS Reviews (
    idReviews INTEGER PRIMARY KEY NOT NULL ,
    stars INTEGER,
    idUser INTEGER REFERENCES User (idUser) NOT NULL,
    reviewsDescription TEXT,
    idUserFrom INTEGER REFERENCES User (idUser) NOT NULL,
    created_at DATETIME
);

CREATE TABLE IF NOT EXISTS Condition (
    idCondition INTEGER PRIMARY KEY NOT NULL,
    condition TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Category (
    idCategory INTEGER PRIMARY KEY NOT NULL,
    category TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Characteristic (
    idCharacteristic INTEGER PRIMARY KEY NOT NULL,
    characteristic TEXT NOT NULL,
    idType INTEGER REFERENCES TypesInCategory (idType) NOT NULL
);

CREATE TABLE IF NOT EXISTS TypesInCategory (
    idType INTEGER PRIMARY KEY NOT NULL,
    type_name TEXT NOT NULL,
    category INTEGER REFERENCES Category (idCategory) NOT NULL
);

CREATE TABLE IF NOT EXISTS Product (
    idProduct INTEGER PRIMARY KEY NOT NULL,
    prodName TEXT NOT NULL,
    prodDescription TEXT,
    price DOUBLE NOT NULL,
    condition INTEGER REFERENCES Condition (idCondition) NOT NULL,
    characteristic1 INTEGER REFERENCES Characteristic (idCharacteristic) NOT NULL,
    characteristic2 INTEGER REFERENCES Characteristic (idCharacteristic),
    characteristic3 INTEGER REFERENCES Characteristic (idCharacteristic),
    seller INTEGER REFERENCES User (idUser) NOT NULL,
    buyer INTEGER REFERENCES User(idUser) DEFAULT NULL,
    purchaseDate DATETIME DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS Chat (
    idChat INTEGER PRIMARY KEY NOT NULL,
    product INTEGER REFERENCES Product (idProduct) NOT NULL,
    possibleBuyer INTEGER REFERENCES User (idUser) NOT NULL
);

CREATE TABLE IF NOT EXISTS Messages (
    idMessage INTEGER PRIMARY KEY NOT NULL, 
    messageDate DATETIME NOT NULL,
    sender INTEGER NOT NULL,
    chat INTEGER REFERENCES Chat (idChat) NOT NULL,
    content TEXT NOT NULL,
    seen BOOLEAN NOT NULL
);

CREATE TABLE IF NOT EXISTS ShoppingCart (
    user INTEGER REFERENCES User (idUser) NOT NULL,
    product INTEGER REFERENCES Product (idProduct) NOT NULL,
    PRIMARY KEY(product, user)
);

CREATE TABLE IF NOT EXISTS Favorites (
    user INTEGER REFERENCES User (idUser) NOT NULL,
    product INTEGER REFERENCES Product (idProduct) NOT NULL,
    PRIMARY KEY(product, user)
);

CREATE TABLE IF NOT EXISTS Recent (
    user INTEGER REFERENCES User (idUser) NOT NULL,
    product INTEGER REFERENCES Product (idProduct) NOT NULL,
    PRIMARY KEY(product, user)
);

CREATE TABLE IF NOT EXISTS Shipping (
    product INTEGER REFERENCES Product (idProduct) NOT NULL PRIMARY KEY,
    buyer INTEGER REFERENCES User (idUser) NOT NULL,
    seller INTEGER REFERENCES User (idUser) NOT NULL,
    purchaseDate TEXT REFERENCES Product (purchaseDate) NOT NULL
);

CREATE TABLE IF NOT EXISTS Photo (
    idPhoto INTEGER PRIMARY KEY NOT NULL, 
    idProduct INTEGER REFERENCES Product (idProduct) NOT NULL,
    photo TEXT NOT NULL
);

/*******************************************************************************
   Populate Tables
********************************************************************************/

INSERT OR REPLACE INTO Country(country)
VALUES ('Afghanistan'), ('Albania'),
('Algeria'),('Andorra'),('Angola'),('Antigua and Barbuda'),('Argentina'),
('Armenia'),('Australia'),('Austria'),('Azerbaijan'),('Bahamas'),('Bahrain'),
('Bangladesh'),('Barbados'),('Belarus'),('Belgium'),('Belize'),('Benin'),('Bhutan'),
('Bolivia'),('Bosnia and Herzegovina'),('Botswana'),('Brazil'),('Brunei'),
('Bulgaria'),('Burkina Faso'),('Burundi'),('Cabo Verde'),('Cambodia'),('Cameroon'),
('Canada'),('Central African Republic'),('Chad'),('Chile'),('China'),
('Colombia'),('Comoros'),('Congo (Congo-Brazzaville)'),
('Costa Rica'),('Croatia'),('Cuba'),('Cyprus'),('Czechia'),('Denmark'),
('Djibouti'),('Dominica'),('Dominican Republic'),('Ecuador'),('Egypt'),('El Salvador'),
('Equatorial Guinea'),('Eritrea'),('Estonia'),('Eswatini'),('Ethiopia'),('Fiji'),
('Finland'),('France'),('Gabon'),('Gambia'),('Georgia'),('Germany'),
('Ghana'),('Greece'),('Grenada'),('Guatemala'),('Guinea'),('Guinea-Bissau'),
('Guyana'),('Haiti'),('Honduras'),('Hungary'),('Iceland'),('India'),
('Indonesia'),('Iran'),('Iraq'),('Ireland'),('Israel'),('Italy'),('Jamaica'),('Japan'),
('Jordan'),('Kazakhstan'),('Kenya'),('Kiribati'),('Kosovo'),('Kuwait'),
('Kyrgyzstan'),('Laos'),('Latvia'),('Lebanon'),('Lesotho'),('Liberia'),('Libya'),('Liechtenstein'),('Lithuania'),
('Luxembourg'),('Madagascar'),('Malawi'),('Malaysia'),('Maldives'),('Mali'),('Malta'),
('Marshall Islands'),('Mauritania'),('Mauritius'),('Mexico'),('Micronesia'),
('Moldova'),('Monaco'),('Mongolia'),('Montenegro'),('Morocco'),('Mozambique'),
('Myanmar'),('Namibia'),('Nauru'),('Nepal'),('Netherlands'),('New Zealand'),
('Nicaragua'),('Niger'),('Nigeria'),('North Korea'),('North Macedonia'),
('Norway'),('Oman'),('Pakistan'),('Palau'),('Palestine'),('Panama'),
('Papua New Guinea'),('Paraguay'),('Peru'),('Philippines'),('Poland'),('Portugal'),
('Qatar'),('Romania'),('Russia'),('Rwanda'),('Saint Kitts and Nevis'),
('Saint Lucia'),('Saint Vincent and the Grenadines'),('Samoa'),('San Marino'),('Sao Tome and Principe'),
('Saudi Arabia'),('Senegal'),('Serbia'),('Seychelles'),('Sierra Leone'),('Singapore'),
('Slovakia'),('Slovenia'),('Solomon Islands'),('Somalia'),('South Africa'),('South Korea'),
('South Sudan'),('Spain'),('Sri Lanka'),('Sudan'),('Suriname'),('Sweden'),
('Switzerland'),('Syria'),('Taiwan'),('Tajikistan'),('Tanzania'),('Thailand'),
('Timor-Leste'),('Togo'),('Tonga'),('Trinidad and Tobago'),('Tunisia'),('Turkey'),
('Turkmenistan'),('Tuvalu'),('Uganda'),('Ukraine'),('United Arab Emirates'),
('United Kingdom'),('United States'),('Uruguay'),('Uzbekistan'),('Vanuatu'),('Vatican City'),
('Venezuela'),('Vietnam'),('Yemen'),('Zambia'),('Zimbabwe');

INSERT OR REPLACE INTO User(idUser, firstName, lastName, phone, email, userPassword, photo, idCountry, city, userAddress, zipCode)
VALUES ('6637ab278105554a8', 'Leonor', 'Couto', 987654321 , 'leonoremail@fake.com','$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'leonorPhoto.jpeg', 139, 'Porto', 'Rua de camões', '2000-100'),
('6637ab278105b4ffd', 'Filipa', 'Fidalgo', 975318642, 'filipaemail@fake.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'filipaTest.png', 17, 'Gante', 'Rua da exAlbania', '1000'),
('6637ab2781073badf', 'Pedro', 'Marta', 963852741, 'pedroemail@fake.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'randomImage.jpg', 63, 'Düsseldorf', 'avenida da libete', '23458-872');
INSERT OR REPLACE INTO User(idUser, firstName, lastName, phone, email, userPassword, idCountry, city, userAddress, zipCode)
VALUES ('6637ab278105e5186', 'Admin', 'Admin', 999599999, 'admin@admin.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 139, 'Porto', 'Rua dos Admins', '9995-999'),
('6637ab278105f11e7', 'Alice', 'Johnson', 987654300, 'myemail@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 186, 'Los Angeles', '789 Oak St', '90001'),
('6637ab278106035f2', 'Bob', 'Williams', 915415926, 'sellingstuff@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 32, 'Toronto', '567 Maple St', 'M1C 1A1'),
('6637ab2781061cc71', 'Charlie', 'Brown', 953589793, 'charlie.brown@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 9, 'Sydney', '1010 Pine St', '2000'),
('6637ab2781062227b', 'David', 'Garcia', 925384664, 'davidGarcia@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 57, 'Madrid', '456 Cedar St', '28001'),
('6637ab2781063adfe', 'Emily', 'Martinez', 987376304, 'emilySunshine@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 59, 'Paris', '321 Birch St', '75001'),
('6637ab2781064502e', 'Frank', 'Lopez', 987894305, 'frank.678@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 81, 'Rome', '654 Walnut St', '00184'),
('6637ab2781065f790', 'Grace', 'Rodriguez', 987659086, 'grace.rodriguez@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 17, 'Berlin', '987 Elm St', '10115'),
('6637ab27810663ad6', 'Henry', 'Gonzalez', 982345877, 'Tranquil@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 83, 'Tokyo', '123 Maple St', '100-0001'),
('6637ab2781067f502', 'Isabella', 'Hernandez', 987654308, 'isabella.hernandez@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6.', 24, 'Sao Paulo', '789 Oak St', '04505-010'),
('6637ab27810684d71', 'Jack', 'Smith', 985674309, 'jack.smith@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6/', 185, 'Manchester', '456 Cedar St', 'M1 1AB'),
('6637ab278106966a3', 'Liam', 'Jones', 934567432, 'liamjones@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 36, 'Beijing', '1010 Pine St', '100000'),
('6637ab278106acd6f', 'Mia', 'Davis', 987904311, 'MysticalMia@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 142, 'Moscow', '567 Maple St', '101000'),
('6637ab278106b995f', 'Noah', 'Miller', 945504312, 'noah.miller@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 130, 'Seoul', '789 Oak St', '04563'),
('6637ab278106c2d2a', 'Olivia', 'Wilson', 958209749, 'olivia.wilson@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 75, 'Mumbai', '123 Maple St', '400001'),
('6637ab278106d3662', 'Peter', 'Taylor', 987654314, 'peter.taylor@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 109, 'Mexico City', '456 Cedar St', '01000'),
('6637ab278106ef82a', 'Quinn', 'Anderson', 927387435, 'quinn.anderson209@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 32, 'Vancouver', '1010 Pine St', 'V6B 1S4'),
('6637ab278106fe5df', 'Ryan', 'Thomas', 976563167, 'banana@emails.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 186, 'Chicago', '567 Maple St', '60601'),
('6637ab27810709782', 'Sophia', 'White', 912345673, 'sophia.white@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 9, 'Melbourne', '789 Oak St', '3000'),
('6637ab27810711fc0', 'Taylor', 'Brown', 987654318, 'taylor.brown.thatIsMe@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 185, 'London', '123 Maple St', 'WC2N 5DU'),
('6637ab278107255cc', 'William', 'Lee', 962304319, 'william.lee@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 83, 'Osaka', '456 Cedar St', '550-0012');

INSERT OR REPLACE INTO UserAdmin(idUser)
VALUES(1),(2),(3),(4);

INSERT INTO Reviews (stars, idUser, reviewsDescription, idUserFrom, created_at)
VALUES (3, '6637ab278105f11e7', 'Nice service!', '6637ab278105b4ffd', '2024-04-04 02:00:00'),
(5, '6637ab27810663ad6', 'Excellent experience.', '6637ab2781073badf', '2024-04-04 02:00:00'),
(4, '6637ab278106c2d2a', 'Good quality products.', '6637ab2781073badf', '2024-04-04 02:00:00'),
(2, '6637ab2781061cc71', 'Disappointed with the service.', '6637ab2781062227b', '2024-04-04 02:00:00'),
(5, '6637ab27810711fc0', 'Highly recommended!', '6637ab2781062227b', '2024-04-04 02:00:00'),
(1, '6637ab2781063adfe', 'Terrible experience.', '6637ab2781061cc71', '2024-04-04 02:00:00'),
(3, '6637ab278106acd6f', 'Average service.', '6637ab2781061cc71', '2024-04-04 02:00:00'),
(4, '6637ab2781073badf', 'Great value for money.', '6637ab278106035f2', '2024-04-04 02:00:00'),
(5, '6637ab278106ef82a', 'Best service ever!', '6637ab278106035f2', '2024-04-04 02:00:00'),
(2, '6637ab278105554a8', 'Poor customer service.', '6637ab27810711fc0', '2024-04-04 02:00:00'),
(4, '6637ab27810709782', 'Quick delivery.', '6637ab27810711fc0', '2024-04-04 02:00:00'),
(3, '6637ab2781064502e', 'Satisfied with the product.', '6637ab278106fe5df', '2024-04-04 02:00:00'),
(5, '6637ab27810684d71', 'Amazing quality!', '6637ab278106ef82a', '2024-04-04 02:00:00'),
(1, '6637ab278105e5186', 'Worst experience ever.', '6637ab278106fe5df', '2024-04-04 02:00:00'),
(3, '6637ab278106035f2', 'Fair pricing.', '6637ab278106c2d2a', '2024-04-04 02:00:00'),
(4, '6637ab2781062227b', 'Friendly staff.', '6637ab278106acd6f', '2024-04-04 02:00:00'),
(2, '6637ab278106b995f', 'Not up to expectations.', '6637ab27810663ad6', '2024-04-04 02:00:00'),
(5, '6637ab278106d3662', 'Absolutely fantastic!', '6637ab27810711fc0', '2024-04-04 02:00:00'),
(4, '6637ab278105b4ffd', 'Efficient service.', '6637ab27810684d71', '2024-04-04 02:00:00'),
(3, '6637ab278107255cc', 'Could be better.', '6637ab2781065f790', '2024-04-04 02:00:00'),
(4, '6637ab2781065f790', 'Prompt response.', '6637ab278106d3662', '2024-04-04 02:00:00'),
(2, '6637ab278106fe5df', 'Not satisfied with the product.', '6637ab278106acd6f', '2024-04-04 02:00:00'),
(5, '6637ab278106966a3', 'Excellent customer service!', '6637ab278105f11e7', '2024-04-04 02:00:00'),
(3, '6637ab2781067f502', 'Could improve delivery time.', '6637ab2781062227b', '2024-04-04 02:00:00'),
(4, '6637ab278107255cc', 'Good value for money.', '6637ab2781063adfe', '2024-04-04 02:00:00'),
(1, '6637ab278106035f2', 'Extremely poor quality.', '6637ab2781061cc71', '2024-04-04 02:00:00'),
(5, '6637ab2781062227b', 'Highly impressed!', '6637ab278106035f2', '2024-04-04 02:00:00'),
(2, '6637ab2781073badf', 'Product did not meet expectations.', '6637ab278105f11e7', '2024-04-04 02:00:00'),
(4, '6637ab278106d3662', 'Satisfactory experience.', '6637ab278105e5186', '2024-04-04 02:00:00'),
(3, '6637ab27810709782', 'Average quality.', '6637ab2781073badf', '2024-04-04 02:00:00'),
(5, '6637ab278105b4ffd', 'Top-notch service!', '6637ab278105b4ffd', '2024-04-04 02:00:00'),
(4, '6637ab2781061cc71', 'Efficient handling of queries.','6637ab278105554a8', '2024-04-04 02:00:00'),
(3, '6637ab27810663ad6', 'Fairly good experience.', '6637ab278105f11e7', '2024-04-04 02:00:00'),
(1, '6637ab2781064502e', 'Unacceptable service.', '6637ab278105e5186', '2024-04-04 02:00:00'),
(5, '6637ab278106b995f', 'Absolutely delighted!', '6637ab2781061cc71', '2024-04-04 02:00:00'),
(4, '6637ab2781063adfe', 'Friendly and helpful staff.', '6637ab278106966a3', '2024-04-04 02:00:00'),
(3, '6637ab278106acd6f', 'Moderate pricing.', '6637ab27810709782', '2024-04-04 02:00:00'),
(2, '6637ab27810711fc0', 'Below average quality.', '6637ab278106acd6f', '2024-04-04 02:00:00'),
(5, '6637ab27810684d71', 'Impressive performance!', '6637ab27810711fc0', '2024-04-04 02:00:00'),
(4, '6637ab278105554a8', 'Good communication.', '6637ab278106b995f', '2024-04-04 02:00:00'),
(3, '6637ab278106ef82a', 'Could be more responsive.', '6637ab278106c2d2a', '2024-04-04 02:00:00'),
(5, '6637ab278106c2d2a', 'Outstanding service!', '6637ab2781067f502', '2024-04-04 02:00:00'),
(4, '6637ab278105f11e7', 'Professional handling.', '6637ab278106b995f', '2024-04-04 02:00:00'),
(3, '6637ab278105e5186', 'Mediocre experience.', '6637ab27810684d71', '2024-04-04 02:00:00'),
(1, '6637ab278107255cc', 'Very dissatisfied.', '6637ab278106966a3', '2024-04-04 02:00:00'),
(5, '6637ab278106035f2', 'Excellent value for money!', '6637ab278106acd6f', '2024-04-04 02:00:00'),
(4, '6637ab2781062227b', 'Courteous staff.', '6637ab278106c2d2a', '2024-04-04 02:00:00'),
(3, '6637ab2781067f502', 'Slightly disappointed.', '6637ab278106d3662', '2024-04-04 02:00:00'),
(2, '6637ab278106d3662', 'Subpar quality.', '6637ab278106ef82a', '2024-04-04 02:00:00'),
(5, '6637ab278105b4ffd', 'Exceptional service!', '6637ab278106966a3', '2024-04-04 02:00:00'),
(4, '6637ab2781061cc71', 'Timely delivery.', '6637ab27810711fc0', '2024-04-04 02:00:00'),
(3, '6637ab27810663ad6', 'Satisfactory overall.', '6637ab27810709782', '2024-04-04 02:00:00'),
(1, '6637ab2781064502e', 'Unsatisfactory service.', '6637ab2781064502e', '2024-04-04 02:00:00'),
(5, '6637ab278106b995f', 'Thrilled with the experience!', '6637ab2781065f790', '2024-04-04 02:00:00'),
(4, '6637ab2781063adfe', 'Helpful and accommodating.', '6637ab2781064502e', '2024-04-04 02:00:00'),
(3, '6637ab278106acd6f', 'Reasonable pricing.', '6637ab2781062227b', '2024-04-04 02:00:00'),
(2, '6637ab27810711fc0', 'Poor quality products.', '6637ab2781061cc71', '2024-04-04 02:00:00'),
(5, '6637ab27810684d71', 'Absolutely fantastic!', '6637ab278106035f2', '2024-04-04 02:00:00'),
(5, '6637ab278105554a8', 'Good customer support.', '6637ab278105f11e7', '2024-04-04 02:00:00'),
(3, '6637ab278106ef82a', 'Room for improvement.', '6637ab278105e5186', '2024-04-04 02:00:00'),
(5, '6637ab278106c2d2a', 'Exceptional performance!', '6637ab2781073badf', '2024-04-04 02:00:00'),
(4, '6637ab278105f11e7', 'Efficient service delivery.','6637ab278105554a8', '2024-04-04 02:00:00'),
(3, '6637ab278105e5186', 'Average experience.', '6637ab278105f11e7', '2024-04-04 02:00:00'),
(1, '6637ab278107255cc', 'Extremely dissatisfied.', '6637ab2781062227b', '2024-04-04 02:00:00'),
(5, '6637ab278106035f2', 'Great value for money!', '6637ab2781063adfe', '2024-04-04 02:00:00'),
(4, '6637ab2781062227b', 'Friendly and helpful service.', '6637ab2781064502e', '2024-04-04 02:00:00'),
(3, '6637ab2781067f502', 'Somewhat underwhelming.', '6637ab2781065f790', '2024-04-04 02:00:00'),
(2, '6637ab278106d3662', 'Below standard quality.', '6637ab278105b4ffd', '2024-04-04 02:00:00');

INSERT INTO Condition (condition)
VALUES ('New with tags'),('New without tags'), ('Very Good'), ('Good'), ('Satisfactory');

INSERT INTO Category (category)
VALUES ('Sports'), ('Tecnology'), ('Books'), ('Games'), ('Cars'), ('Kids'), ('Animals'), ('Clothes'), ('Others'), ('Shoes');   

INSERT INTO TypesInCategory (type_name, category)
VALUES ('Type of Sport', 1), 
('Type of equipments', 2),
('Genre', 3),
('Devices', 4),
('kms', 5),
('Type of fuel', 5),
('Kid''s Size', 6),
('Clothes', 7),
('Toys', 7),
('Food', 7),
('Type of clothes', 8),
('Clothes'' Genre', 8),
('Clothes'' Size', 8),
('Type of shoes', 10),
('Shoes'' Size', 10),
('Other', 9);

INSERT INTO Characteristic (characteristic, idType) 
VALUES ('Football', 1), ('Basketball', 1), ('American Football', 1), 
('Baseball', 1), ('Tennis', 1), ('Golf', 1), ('Rugby', 1), ('Cricket', 1), 
('Hockey', 1), ('Volleyball', 1), ('Table Tennis', 1), ('Badminton', 1), 
('Swimming', 1), ('Athletics', 1), ('Gymnastics', 1), ('Boxing', 1), ('Wrestling', 1), 
('Martial Arts', 1), ('Cycling', 1), ('Skiing', 1), ('Snowboarding', 1), 
('Surfing', 1), ('Skateboarding', 1), ('Rowing', 1), ('Sailing', 1), 
('Fencing', 1), ('Archery', 1), ('Equestrian', 1), ('Triathlon', 1), ('Other', 1),
('Computers & Laptops', 2), ('Mobile Devices', 2), ('Audio & Entertainment', 2), 
('Cameras & Photography', 2), ('Home Electronics', 2), ('Gaming', 2), 
('Software & Applications', 2), ('Accessories & Peripherals', 2), 
('Networking & Internet', 2), ('Components & Parts', 2), 
('Fiction', 3), ('Non-Fiction', 3), ('Poetry', 3), ('Drama', 3), 
('Child books', 3), ('Graphic Novels/Comics', 3), ('Reference', 3), 
('Religious/Spiritual', 3), ('Cooking/Food', 3), ('Art/Photography', 3), 
('Music', 3), ('Sports', 3), ('Science Fiction/Fantasy', 3), 
('Romance', 3), ('Mystery/Thriller', 3), ('Historical Fiction', 3), 
('Horror', 3), ('Humor', 3), ('Business/Finance', 3), 
('Self-Help/Personal Development', 3), ('Political/Current Events', 3), 
('Nature/Environment', 3), ('Philosophy', 3), ('Technology/Computers', 3), 
('Travel', 3), ('Health/Fitness', 3), ('Parenting/Family', 3), 
('Education/Teaching', 3), ('LGBTQ+', 3), ('Cultural Studies', 3), 
('Board Games', 4), ('Card Games', 4), ('Video Games', 4),
('Puzzle Games', 4), ('Party Games', 4), ('Educational Games', 4),
('Music/Rhythm Games', 4), ('Virtual Reality Games', 4),
('PS4', 4), ('PS5', 4), ('Xbox', 4),  ('Nintendo Switch', 4), 
('Nintendo 3DS', 4), ('Nintendo 2DS', 4), ('Nintendo Wii', 4),
('0-5000 kms',5), ('5000-10000 kms',5), ('10000-100000 kms',5), ('200000-300000 kms',5), ('300000 + kms',5),
('Diesel', 6), ('Electric', 6), ('Hybrid', 6), ('Gasoline/Petrol', 6),
('Hydrogen Fuel Cell', 6), ('Natural Gas (CNG)', 6), ('Plug-In Hybrid', 6),
('Biofuel', 6), ('Flex-Fuel', 6), ('Propane/Liquefied Petroleum Gas (LPG)', 6),
('1 ano', 7), ('2 anos', 7), ('3-4 anos', 7), 
('5-6 anos', 7), ('7-8 anos', 7), ('9-10 anos', 7), 
('11-12 anos', 7), ('13-14 anos', 7), ('15-16 anos', 7),
('One Size', 7),
('Skirts', 11), ('Sweaters', 11), ('Jeans', 11), ('T-shirts', 11), ('Jackets', 11), ('Dresses', 11), ('Polo Shirts', 11), ('Shirts', 11), ('Suit', 11), ('Shorts', 11),
('Homem', 12), ('Mulher', 12),
('XS', 13), ('S', 13), ('M', 13), ('L', 13), ('XL', 13), ('XXL', 13), 
('One Size', 13),
('Sneakers',14), ('Boots',14), ('Sandals',14), ('Loafers',14), ('Oxfords',14), 
('Brogues',14), ('Derby shoes',14), ('Espadrilles',14), ('Moccasins',14), 
('Ballet flats',14), ('High heels',14), ('Wedges',14), ('Platform shoes',14), 
('Athletic shoes',14), ('Hiking boots',14), ('Chelsea boots',14), ('Dress shoes',14), 
('Slippers',14), ('Clogs',14), ('Boat shoes',14),
('16',15), ('16.5',15), ('17',15), ('17.5',15), ('18',15), ('18.5',15), ('19',15), 
('19.5',15), ('20',15), ('20.5',15), ('21',15), ('21.5',15), ('22',15), ('22.5',15), 
('23',15), ('23.5',15), ('24',15), ('24.5',15), ('25',15), ('25.5',15), ('26',15), 
('26.5',15), ('27',15), ('27.5',15), ('28',15), ('28.5',15), ('29',15), ('29.5',15), 
('30',15), ('30.5',15), ('31',15), ('31.5',15), ('32',15), ('32.5',15), ('33',15), 
('33.5',15), ('34',15), ('34.5',15), ('35',15), ('35.5',15), ('36',15), ('36.5',15), 
('37',15), ('37.5',15), ('38',15), ('38.5',15), ('39',15), ('39.5',15), ('40',15), 
('40.5',15), ('41',15), ('41.5',15), ('42',15), ('42.5',15), ('43',15), ('43.5',15), 
('44',15), ('44.5',15), ('45',15), ('45.5',15), ('46',15),
('Others', 16);


INSERT INTO Product (prodName, prodDescription, price, condition, characteristic1, characteristic2, characteristic3, seller)
VALUES ('Computer', 'Asus computer 2003', 40, 3, 31, NULL, NULL, '6637ab278105554a8'),
('Basketball', 'Brand new basketball', 25, 1, 2, NULL, NULL, '6637ab2781062227b'),
('iPhone X', 'Used iPhone X in good condition', 300, 4, 32, NULL, NULL, '6637ab27810663ad6'),
('Harry Potter Books', 'Complete set of Harry Potter books', 50, 2, 41, NULL, NULL, '6637ab278106b995f'),
('PS5 Console', 'Brand new PS5 console with controller', 600, 1, 36, NULL, NULL, '6637ab2781063adfe'),
('Toyota Camry', 'Used Toyota Camry 2018 electric', 15000, 3, 87, 91, NULL, '6637ab27810684d71'),
('Nike Running Shoes', 'Brand new Nike running shoes', 80, 1, 143, 203, NULL, '6637ab278106ef82a'),
('Dell Laptop', 'Refurbished Dell laptop with SSD', 500, 2, 31, NULL, NULL, '6637ab278106ef82a'),
('Cooking Book', 'Best-selling cooking book with recipes', 30, 3, 66, NULL, NULL, '6637ab278107255cc'),
('Nintendo Switch', 'Nintendo Switch console with Mario Kart', 350, 1, 36, NULL, NULL, '6637ab2781061cc71'),
('Ford Mustang', 'Used Ford Mustang GT 2019', 30000, 3, 88, 91, NULL, '6637ab278106c2d2a'),
('Football Jersey', 'Official team jersey with player name', 60, 1, 1, NULL, NULL, '6637ab278106966a3'),
('Samsung Galaxy S20', 'Brand new Samsung Galaxy S20', 700, 1, 32, NULL, NULL, '6637ab278106d3662'),
('Gardening Tools Set', 'Complete set of gardening tools', 100, 2, 211, NULL, NULL, '6637ab2781062227b'),
('Board Game - Settlers of Catan', 'Classic board game for strategy lovers', 45, 2, 71, NULL, NULL, '6637ab278106035f2'),
('Sony 4K TV', '55-inch Sony 4K Smart TV', 900, 1, 35, NULL, NULL, '6637ab2781064502e'),
('Yoga Mat', 'High-quality yoga mat for home workouts', 20, 1, 30, NULL, NULL, '6637ab2781067f502'),
('Used Desktop PC', 'Older model desktop PC, good for basic tasks', 100, 3, 31, NULL, NULL, '6637ab278106acd6f'),
('Classic Novels Collection', 'Collection of classic novels by famous authors', 40, 2, 41, NULL, NULL, '6637ab278106fe5df'),
('FIFA 21 (PS4)', 'Pre-owned FIFA 21 game for PlayStation 4', 15, 4, 79, NULL, NULL, '6637ab278107255cc'),
('Bicycle Helmet', 'Safety helmet for cycling enthusiasts', 25, 1, 19, NULL, NULL, '6637ab2781062227b'),
('Coloring Book for kids', 'Coloring book with various themes for kids', 10, 5, 45, NULL, NULL, '6637ab278105f11e7'),
('Bluetooth Earbuds', 'Wireless earbuds with charging case', 30, 2, 33, NULL, NULL, '6637ab27810663ad6'),
('Camping Tent', 'Compact tent for outdoor camping adventures', 50, 3, 211, NULL, NULL, '6637ab278106b995f'),
('Used Xbox One', 'Pre-owned Xbox One console with controller', 80, 3, 81, NULL, NULL, '6637ab278106ef82a'),
('DVD Movie Collection', 'Assorted collection of classic movies on DVD', 15, 2, 33, NULL, NULL, '6637ab27810711fc0');


INSERT INTO ShoppingCart (user, product)
VALUES ('6637ab278105554a8', 10), ('6637ab278105554a8',24), ('6637ab278105554a8',3);

INSERT INTO Favorites (user, product)
VALUES ('6637ab278105554a8', 10), ('6637ab278105554a8',4), ('6637ab278105554a8',24), ('6637ab278105554a8',3), ('6637ab278105554a8',9), ('6637ab278105554a8',17);

INSERT INTO Recent (user, product)
VALUES ('6637ab278105554a8',9), ('6637ab278105554a8',17);

INSERT INTO Photo(idProduct, photo)
VALUES (1, 'asus_computer.jpg'),
(2, 'basketball.jpeg'),
(3, 'iphoneX1.jpg'),
(3, 'iphoneX2.jpg'),
(3, 'iphoneX3.jpg'),
(4, 'harry_potter_books.jpg'),
(5, 'ps5.jpg'),
(6, 'toyota.jpg'),
(7, 'nike1.jpg'),
(7, 'nike2.jpeg'),
(8, 'dell.jpg'),
(9, 'cookbook.jpg'),
(10, 'nintendo.jpg'),
(11, 'fordMustang.jpeg'),
(12,'jersey.jpeg'),
(13, 'samsung.jpeg'),
(14, 'tool.webp'),
(15, 'catan.jpeg'),
(16, 'sonyTV.jpeg'),
(17, 'yogamat.jpeg'),
(18, 'desktopPc.jpeg'),
(19, 'classicalNovels.jpg'),
(20, 'fifa.jpeg'),
(21, 'helmet.jpeg'),
(22, 'colorbook.jpeg'),
(23, 'earbuds.jpeg'),
(24, 'tent.jpeg'),
(25, 'xbox.jpeg'),
(26, 'dvdmoviecollection.jpg');

INSERT INTO Messages (idMessage, messageDate, sender, chat, content, seen)
VALUES (1, '2024-04-05 11:00:00', '6637ab278105b4ffd', 1, 'Hi! I''m interested in your product!', false);

INSERT INTO Chat (idChat, product, possibleBuyer)
VALUES (1, 1, '6637ab278105b4ffd');