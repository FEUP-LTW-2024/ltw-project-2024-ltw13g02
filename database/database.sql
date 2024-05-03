/*******************************************************************************
   Database - Version 0.2
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
  idUser INTEGER PRIMARY KEY NOT NULL ,
  firstName VARCHAR NOT NULL,
  lastName VARCHAR NOT NULL,
  phone INTEGER CHECK (phone >= 200000000 AND phone <= 999999999) NOT NULL,
  email TEXT UNIQUE NOT NULL,
  userPassword VARCHAR NOT NULL,
  stars INTEGER DEFAULT "0",
  photo TEXT DEFAULT "Sem foto",
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

INSERT OR REPLACE INTO User(firstName, lastName, phone, email, userPassword, photo, idCountry, city, userAddress, zipCode)
VALUES ('Leonor', 'Couto', 987654321 , 'leonoremail@fake.com','$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'leonorPhoto.jpeg', 139, 'Porto', 'Rua de camões', '2000-100'),
('Filipa', 'Fidalgo', 975318642, 'filipaemail@fake.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'filipaTest.png', 17, 'Gante', 'Rua da exAlbania', '1000'),
('Pedro', 'Marta', 963852741, 'pedroemail@fake.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 'randomImage.jpg', 63, 'Düsseldorf', 'avenida da libete', '23458-872');
INSERT OR REPLACE INTO User(firstName, lastName, phone, email, userPassword, idCountry, city, userAddress, zipCode)
VALUES ('Admin', 'Admin', 999599999, 'admin@admin.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 139, 'Porto', 'Rua dos Admins', '9995-999'),
('Alice', 'Johnson', 987654300, 'myemail@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 186, 'Los Angeles', '789 Oak St', '90001'),
('Bob', 'Williams', 915415926, 'sellingstuff@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 32, 'Toronto', '567 Maple St', 'M1C 1A1'),
('Charlie', 'Brown', 953589793, 'charlie.brown@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 9, 'Sydney', '1010 Pine St', '2000'),
('David', 'Garcia', 925384664, 'davidGarcia@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 57, 'Madrid', '456 Cedar St', '28001'),
('Emily', 'Martinez', 987376304, 'emilySunshine@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 59, 'Paris', '321 Birch St', '75001'),
('Frank', 'Lopez', 987894305, 'frank.678@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 81, 'Rome', '654 Walnut St', '00184'),
('Grace', 'Rodriguez', 987659086, 'grace.rodriguez@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 17, 'Berlin', '987 Elm St', '10115'),
('Henry', 'Gonzalez', 982345877, 'Tranquil@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 83, 'Tokyo', '123 Maple St', '100-0001'),
('Isabella', 'Hernandez', 987654308, 'isabella.hernandez@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6.', 24, 'Sao Paulo', '789 Oak St', '04505-010'),
('Jack', 'Smith', 985674309, 'jack.smith@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6/', 185, 'Manchester', '456 Cedar St', 'M1 1AB'),
('Liam', 'Jones', 934567432, 'liamjones@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 36, 'Beijing', '1010 Pine St', '100000'),
('Mia', 'Davis', 987904311, 'MysticalMia@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 142, 'Moscow', '567 Maple St', '101000'),
('Noah', 'Miller', 945504312, 'noah.miller@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 130, 'Seoul', '789 Oak St', '04563'),
('Olivia', 'Wilson', 958209749, 'olivia.wilson@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 75, 'Mumbai', '123 Maple St', '400001'),
('Peter', 'Taylor', 987654314, 'peter.taylor@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 109, 'Mexico City', '456 Cedar St', '01000'),
('Quinn', 'Anderson', 927387435, 'quinn.anderson209@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 32, 'Vancouver', '1010 Pine St', 'V6B 1S4'),
('Ryan', 'Thomas', 976563167, 'banana@emails.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 186, 'Chicago', '567 Maple St', '60601'),
('Sophia', 'White', 912345673, 'sophia.white@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 9, 'Melbourne', '789 Oak St', '3000'),
('Taylor', 'Brown', 987654318, 'taylor.brown.thatIsMe@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 185, 'London', '123 Maple St', 'WC2N 5DU'),
('William', 'Lee', 962304319, 'william.lee@email.com', '$2y$10$6sucVUYDP6gbJh54fspvnucUuzsUbRcDQPE.qNvoW4GG1J8IRi6T6', 83, 'Osaka', '456 Cedar St', '550-0012');

INSERT OR REPLACE INTO UserAdmin(idUser)
VALUES(1),(2),(3),(4);

INSERT INTO Reviews (stars, idUser, reviewsDescription, idUserFrom, created_at)
VALUES (3, 5, 'Nice service!', 2, '2024-04-04 02:00:00'),
(5, 12, 'Excellent experience.', 3, '2024-04-04 02:00:00'),
(4, 18, 'Good quality products.', 3, '2024-04-04 02:00:00'),
(2, 7, 'Disappointed with the service.', 8, '2024-04-04 02:00:00'),
(5, 23, 'Highly recommended!', 8, '2024-04-04 02:00:00'),
(1, 9, 'Terrible experience.', 7, '2024-04-04 02:00:00'),
(3, 16, 'Average service.', 7, '2024-04-04 02:00:00'),
(4, 3, 'Great value for money.', 6, '2024-04-04 02:00:00'),
(5, 20, 'Best service ever!', 6, '2024-04-04 02:00:00'),
(2, 1, 'Poor customer service.', 23, '2024-04-04 02:00:00'),
(4, 22, 'Quick delivery.', 22, '2024-04-04 02:00:00'),
(3, 10, 'Satisfied with the product.', 21, '2024-04-04 02:00:00'),
(5, 14, 'Amazing quality!', 20, '2024-04-04 02:00:00'),
(1, 4, 'Worst experience ever.', 21, '2024-04-04 02:00:00'),
(3, 6, 'Fair pricing.', 18, '2024-04-04 02:00:00'),
(4, 8, 'Friendly staff.', 16, '2024-04-04 02:00:00'),
(2, 17, 'Not up to expectations.', 12, '2024-04-04 02:00:00'),
(5, 19, 'Absolutely fantastic!', 23, '2024-04-04 02:00:00'),
(4, 2, 'Efficient service.', 14, '2024-04-04 02:00:00'),
(3, 24, 'Could be better.', 11, '2024-04-04 02:00:00'),
(4, 11, 'Prompt response.', 19, '2024-04-04 02:00:00'),
(2, 21, 'Not satisfied with the product.', 16, '2024-04-04 02:00:00'),
(5, 15, 'Excellent customer service!', 5, '2024-04-04 02:00:00'),
(3, 13, 'Could improve delivery time.', 8, '2024-04-04 02:00:00'),
(4, 24, 'Good value for money.', 9, '2024-04-04 02:00:00'),
(1, 6, 'Extremely poor quality.', 7, '2024-04-04 02:00:00'),
(5, 8, 'Highly impressed!', 6, '2024-04-04 02:00:00'),
(2, 3, 'Product did not meet expectations.', 5, '2024-04-04 02:00:00'),
(4, 19, 'Satisfactory experience.', 4, '2024-04-04 02:00:00'),
(3, 22, 'Average quality.', 3, '2024-04-04 02:00:00'),
(5, 2, 'Top-notch service!', 2, '2024-04-04 02:00:00'),
(4, 7, 'Efficient handling of queries.', 1, '2024-04-04 02:00:00'),
(3, 12, 'Fairly good experience.', 5, '2024-04-04 02:00:00'),
(1, 10, 'Unacceptable service.', 4, '2024-04-04 02:00:00'),
(5, 17, 'Absolutely delighted!', 7, '2024-04-04 02:00:00'),
(4, 9, 'Friendly and helpful staff.', 15, '2024-04-04 02:00:00'),
(3, 16, 'Moderate pricing.', 22, '2024-04-04 02:00:00'),
(2, 23, 'Below average quality.', 16, '2024-04-04 02:00:00'),
(5, 14, 'Impressive performance!', 23, '2024-04-04 02:00:00'),
(4, 1, 'Good communication.', 17, '2024-04-04 02:00:00'),
(3, 20, 'Could be more responsive.', 18, '2024-04-04 02:00:00'),
(5, 18, 'Outstanding service!', 13, '2024-04-04 02:00:00'),
(4, 5, 'Professional handling.', 17, '2024-04-04 02:00:00'),
(3, 4, 'Mediocre experience.', 14, '2024-04-04 02:00:00'),
(1, 24, 'Very dissatisfied.', 15, '2024-04-04 02:00:00'),
(5, 6, 'Excellent value for money!', 16, '2024-04-04 02:00:00'),
(4, 8, 'Courteous staff.', 18, '2024-04-04 02:00:00'),
(3, 13, 'Slightly disappointed.', 19, '2024-04-04 02:00:00'),
(2, 19, 'Subpar quality.', 20, '2024-04-04 02:00:00'),
(5, 2, 'Exceptional service!', 15, '2024-04-04 02:00:00'),
(4, 7, 'Timely delivery.', 23, '2024-04-04 02:00:00'),
(3, 12, 'Satisfactory overall.', 22, '2024-04-04 02:00:00'),
(1, 10, 'Unsatisfactory service.', 10, '2024-04-04 02:00:00'),
(5, 17, 'Thrilled with the experience!', 11, '2024-04-04 02:00:00'),
(4, 9, 'Helpful and accommodating.', 10, '2024-04-04 02:00:00'),
(3, 16, 'Reasonable pricing.', 8, '2024-04-04 02:00:00'),
(2, 23, 'Poor quality products.', 7, '2024-04-04 02:00:00'),
(5, 14, 'Absolutely fantastic!', 6, '2024-04-04 02:00:00'),
(5, 1, 'Good customer support.', 5, '2024-04-04 02:00:00'),
(3, 20, 'Room for improvement.', 4, '2024-04-04 02:00:00'),
(5, 18, 'Exceptional performance!', 3, '2024-04-04 02:00:00'),
(4, 5, 'Efficient service delivery.', 1, '2024-04-04 02:00:00'),
(3, 4, 'Average experience.', 5, '2024-04-04 02:00:00'),
(1, 24, 'Extremely dissatisfied.', 8, '2024-04-04 02:00:00'),
(5, 6, 'Great value for money!', 9, '2024-04-04 02:00:00'),
(4, 8, 'Friendly and helpful service.', 10, '2024-04-04 02:00:00'),
(3, 13, 'Somewhat underwhelming.', 11, '2024-04-04 02:00:00'),
(2, 19, 'Below standard quality.', 2, '2024-04-04 02:00:00');

INSERT INTO Condition (condition)
VALUES ('New with tags'),('New without tags'), ('Very Good'), ('Good'), ('Satisfactory');

INSERT INTO Category (category)
VALUES ('Sports'), ('Tecnology'), ('Books'), ('Games'), ('Cars'), ('Kids'), ('Animals'), ('Clothes'), ('Others'), ('Shoes');   

INSERT INTO Characteristic (characteristic, category) 
VALUES 
('Football', 1), ('Basketball', 1), ('American Football', 1), 
('Baseball', 1), ('Tennis', 1), ('Golf', 1), ('Rugby', 1), ('Cricket', 1), 
('Hockey', 1), ('Volleyball', 1), ('Table Tennis', 1), ('Badminton', 1), 
('Swimming', 1), ('Athletics', 1), ('Gymnastics', 1), ('Boxing', 1), ('Wrestling', 1), 
('Martial Arts', 1), ('Cycling', 1), ('Skiing', 1), ('Snowboarding', 1), 
('Surfing', 1), ('Skateboarding', 1), ('Rowing', 1), ('Sailing', 1), 
('Fencing', 1), ('Archery', 1), ('Equestrian', 1), ('Triathlon', 1),
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
('Diesel', 5), ('Electric', 5), ('Hybrid', 5), ('Gasoline/Petrol', 5),
('Hydrogen Fuel Cell', 5), ('Natural Gas (CNG)', 5), ('Plug-In Hybrid', 5),
('Biofuel', 5), ('Flex-Fuel', 5), ('Propane/Liquefied Petroleum Gas (LPG)', 5),
('Criança - 1 ano', 6), ('Criança - 2 anos', 6), ('Criança - 3-4 anos', 6), 
('Criança - 5-6 anos', 6), ('Criança - 7-8 anos', 6), ('Criança - 9-10 anos', 6), 
('Criança - 11-12 anos', 6), ('Criança - 13-14 anos', 6), ('Criança - 15-16 anos', 6),
('Tamanho unico', 6),
('Food', 7), ('Toys', 7), ('Clothes', 7), ('Others',7),
('Homem - XS', 8), ('Homem - S', 8), ('Homem - M', 8), ('Homem - L', 8), ('Homem - XL', 8), ('Homem - XXL', 8), 
('Mulher - XS', 8), ('Mulher - S', 8), ('Mulher - M', 8), ('Mulher - L', 8), ('Mulher - XL', 8), ('Mulher - XXL', 8), 
('Tamanho unico', 8), ('Other', 1), ('Other', 9),
('Sneakers',10), ('Boots',10), ('Sandals',10), ('Loafers',10), ('Oxfords',10), 
('Brogues',10), ('Derby shoes',10), ('Espadrilles',10), ('Moccasins',10), 
('Ballet flats',10), ('High heels',10), ('Wedges',10), ('Platform shoes',10), 
('Athletic shoes',10), ('Hiking boots',10), ('Chelsea boots',10), ('Dress shoes',10), 
('Slippers',10), ('Clogs',10), ('Boat shoes',10),
('16',10), ('16.5',10), ('17',10), ('17.5',10), ('18',10), ('18.5',10), ('19',10), 
('19.5',10), ('20',10), ('20.5',10), ('21',10), ('21.5',10), ('22',10), ('22.5',10), 
('23',10), ('23.5',10), ('24',10), ('24.5',10), ('25',10), ('25.5',10), ('26',10), 
('26.5',10), ('27',10), ('27.5',10), ('28',10), ('28.5',10), ('29',10), ('29.5',10), 
('30',10), ('30.5',10), ('31',10), ('31.5',10), ('32',10), ('32.5',10), ('33',10), 
('33.5',10), ('34',10), ('34.5',10), ('35',10), ('35.5',10), ('36',10), ('36.5',10), 
('37',10), ('37.5',10), ('38',10), ('38.5',10), ('39',10), ('39.5',10), ('40',10), 
('40.5',10), ('41',10), ('41.5',10), ('42',10), ('42.5',10), ('43',10), ('43.5',10), 
('44',10), ('44.5',10), ('45',10), ('45.5',10), ('46',10),
('0-5000 kms',5), ('5000-10000 kms',5), ('10000-100000 kms',5), ('200000-300000 kms',5), ('300000 + kms',5);


INSERT INTO Product (prodName, prodDescription, price, condition, characteristic1, characteristic2, seller)
VALUES ('Computer', 'Asus computer 2003', 40, 3, 30, NULL, 1),
('Basketball', 'Brand new basketball', 25, 1, 2, NULL, 8),
('iPhone X', 'Used iPhone X in good condition', 300, 4, 31, NULL, 12),
('Harry Potter Books', 'Complete set of Harry Potter books', 50, 2, 40, NULL, 17),
('PS5 Console', 'Brand new PS5 console with controller', 600, 1, 79, NULL, 9),
('Toyota Camry', 'Used Toyota Camry 2018 electric', 15000, 3, 86, 329, 14),
('Nike Running Shoes', 'Brand new Nike running shoes', 80, 1, 245, 309, 20),
('Dell Laptop', 'Refurbished Dell laptop with SSD', 500, 2, 30, NULL, 11),
('Cooking Book', 'Best-selling cooking book with recipes', 30, 3, 65, NULL, 24),
('Nintendo Switch', 'Nintendo Switch console with Mario Kart', 350, 1, 81, NULL, 7),
('Ford Mustang', 'Used Ford Mustang GT 2019', 30000, 3, 88, 328, 18),
('Football Jersey', 'Official team jersey with player name', 60, 1, 1, NULL, 15),
('Samsung Galaxy S20', 'Brand new Samsung Galaxy S20', 700, 1, 31, NULL, 19),
('Gardening Tools Set', 'Complete set of gardening tools', 100, 2, 123, NULL, 8),
('Board Game - Settlers of Catan', 'Classic board game for strategy lovers', 45, 2, 70, NULL, 6),
('Sony 4K TV', '55-inch Sony 4K Smart TV', 900, 1, 34, NULL, 10),
('Yoga Mat', 'High-quality yoga mat for home workouts', 20, 1, 122, NULL, 13),
('Used Desktop PC', 'Older model desktop PC, good for basic tasks', 100, 3, 30, NULL, 16),
('Classic Novels Collection', 'Collection of classic novels by famous authors', 40, 2, 40, NULL, 21),
('FIFA 21 (PS4)', 'Pre-owned FIFA 21 game for PlayStation 4', 15, 4, 78, NULL, 24),
('Bicycle Helmet', 'Safety helmet for cycling enthusiasts', 25, 1, 19, NULL, 8),
('Coloring Book for kids', 'Coloring book with various themes for kids', 10, 5, 44, NULL, 5),
('Bluetooth Earbuds', 'Wireless earbuds with charging case', 30, 2, 32, NULL, 12),
('Camping Tent', 'Compact tent for outdoor camping adventures', 50, 3, 122, NULL, 17),
('Used Xbox One', 'Pre-owned Xbox One console with controller', 80, 3, 80, NULL, 11),
('DVD Movie Collection', 'Assorted collection of classic movies on DVD', 15, 2, 32, NULL, 23);


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
(10, 'nintendo.jpg');


INSERT INTO ShoppingCart (user, product)
VALUES (1, 10), (1,24), (1,3);

INSERT INTO Favorites (user, product)
VALUES (1, 10), (1,4), (1,24), (1,3), (1,9), (1,17);

INSERT INTO Recent (user, product)
VALUES (1,9), (1,17);

INSERT INTO Photo (idProduct, photo)
VALUES (6,'photo de um Toyota'), (6,'photo de um Toyota 2');

INSERT INTO Messages (idMessage, messageDate, sender, chat, content, seen)
VALUES (1, '2024-04-05 11:00:00', 2, 1, 'Hi! I''m interested in your product!', false);

INSERT INTO Chat (idChat, product, possibleBuyer)
VALUES (1, 1, 2);