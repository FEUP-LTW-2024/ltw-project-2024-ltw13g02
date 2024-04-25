/*******************************************************************************
   Database - Version 0.1
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
  email TEXT NOT NULL,
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
    reviewsDescription TEXT
);

CREATE TABLE IF NOT EXISTS Condition (
    idCondition INTEGER PRIMARY KEY NOT NULL,
    condition TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Category (
    idCategory INTEGER PRIMARY KEY NOT NULL,
    category TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Sizes (
    idSize INTEGER PRIMARY KEY NOT NULL,
    tamanho TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Product (
    idProduct INTEGER PRIMARY KEY NOT NULL,
    prodName TEXT NOT NULL,
    prodDescription TEXT,
    price DOUBLE NOT NULL,
    condition INTEGER REFERENCES Condition (idCondition) NOT NULL,
    category INTEGER REFERENCES Category (idCategory) NOT NULL,
    prodsize INTEGER REFERENCES Sizes (idSize) NOT NULL,
    seller INTEGER REFERENCES User (idUser) NOT NULL,
    buyer INTEGER REFERENCES User(idUser) DEFAULT NULL,
    purchaseDate TEXT DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS Chat (
    idChat INTEGER PRIMARY KEY NOT NULL,
    product INTEGER REFERENCES Product (idProduct) NOT NULL,
    possibleBuyer INTEGER REFERENCES User (idUser) NOT NULL
);

CREATE TABLE IF NOT EXISTS Messages (
    idMessage INTEGER PRIMARY KEY NOT NULL, 
    messageDate TEXT NOT NULL,
    sender INTEGER NOT NULL,
    chat INTEGER REFERENCES Chat (idChat) NOT NULL,
    content TEXT NOT NULL
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
    idPhoto INTEGER PRIMARY KEY NOT NULL , 
    idProduct INTEGER REFERENCES Product (idProduct) NOT NULL,
    photo TEXT NOT NULL
);

/*******************************************************************************
   Populate Tables
********************************************************************************/

INSERT OR REPLACE INTO Country (idCountry, country) VALUES
(1, 'Afghanistan'), (2, 'Albania'), (3, 'Algeria'), (4, 'Andorra'), (5, 'Angola'), 
(6, 'Antigua and Barbuda'), (7, 'Argentina'), (8, 'Armenia'), (9, 'Australia'), (10, 'Austria'), 
(11, 'Azerbaijan'), (12, 'Bahamas'), (13, 'Bahrain'), (14, 'Bangladesh'), (15, 'Barbados'), 
(16, 'Belarus'), (17, 'Belgium'), (18, 'Belize'), (19, 'Benin'), (20, 'Bhutan'), 
(21, 'Bolivia'), (22, 'Bosnia and Herzegovina'), (23, 'Botswana'), (24, 'Brazil'), (25, 'Brunei'), 
(26, 'Bulgaria'), (27, 'Burkina Faso'), (28, 'Burundi'), (29, 'Cabo Verde'), (30, 'Cambodia'), 
(31, 'Cameroon'), (32, 'Canada'), (33, 'Central African Republic'), (34, 'Chad'), (35, 'Chile'), 
(36, 'China'), (37, 'Colombia'), (38, 'Comoros'), (39, 'Congo (Congo-Brazzaville)'), (40, 'Costa Rica'), 
(41, 'Croatia'), (42, 'Cuba'), (43, 'Cyprus'), (44, 'Czechia'), (45, 'Denmark'), 
(46, 'Djibouti'), (47, 'Dominica'), (48, 'Dominican Republic'), (49, 'Ecuador'), (50, 'Egypt'), 
(51, 'El Salvador'), (52, 'Equatorial Guinea'), (53, 'Eritrea'), (54, 'Estonia'), (55, 'Eswatini'), 
(56, 'Ethiopia'), (57, 'Fiji'), (58, 'Finland'), (59, 'France'), (60, 'Gabon'), 
(61, 'Gambia'), (62, 'Georgia'), (63, 'Germany'), (64, 'Ghana'), (65, 'Greece'), 
(66, 'Grenada'), (67, 'Guatemala'), (68, 'Guinea'), (69, 'Guinea-Bissau'), (70, 'Guyana'), 
(71, 'Haiti'), (72, 'Honduras'), (73, 'Hungary'), (74, 'Iceland'), (75, 'India'), 
(76, 'Indonesia'), (77, 'Iran'), (78, 'Iraq'), (79, 'Ireland'), (80, 'Israel'), 
(81, 'Italy'), (82, 'Jamaica'), (83, 'Japan'), (84, 'Jordan'), (85, 'Kazakhstan'), 
(86, 'Kenya'), (87, 'Kiribati'), (88, 'Kosovo'), (89, 'Kuwait'), (90, 'Kyrgyzstan'), 
(91, 'Laos'), (92, 'Latvia'), (93, 'Lebanon'), (94, 'Lesotho'), (95, 'Liberia'), 
(96, 'Libya'), (97, 'Liechtenstein'), (98, 'Lithuania'), (99, 'Luxembourg'), (100, 'Madagascar'), 
(101, 'Malawi'), (102, 'Malaysia'), (103, 'Maldives'), (104, 'Mali'), (105, 'Malta'), 
(106, 'Marshall Islands'), (107, 'Mauritania'), (108, 'Mauritius'), (109, 'Mexico'), (110, 'Micronesia'), 
(111, 'Moldova'), (112, 'Monaco'), (113, 'Mongolia'), (114, 'Montenegro'), (115, 'Morocco'), 
(116, 'Mozambique'), (117, 'Myanmar'), (118, 'Namibia'), (119, 'Nauru'), (120, 'Nepal'), 
(121, 'Netherlands'), (122, 'New Zealand'), (123, 'Nicaragua'), (124, 'Niger'), (125, 'Nigeria'), 
(126, 'North Korea'), (127, 'North Macedonia'), (128, 'Norway'), (129, 'Oman'), (130, 'Pakistan'), 
(131, 'Palau'), (132, 'Palestine'), (133, 'Panama'), (134, 'Papua New Guinea'), (135, 'Paraguay'), 
(136, 'Peru'), (137, 'Philippines'), (138, 'Poland'), (139, 'Portugal'), (140, 'Qatar'), 
(141, 'Romania'), (142, 'Russia'), (143, 'Rwanda'), (144, 'Saint Kitts and Nevis'), (145, 'Saint Lucia'), 
(146, 'Saint Vincent and the Grenadines'), (147, 'Samoa'), (148, 'San Marino'), (149, 'Sao Tome and Principe'), 
(150, 'Saudi Arabia'), (151, 'Senegal'), (152, 'Serbia'), (153, 'Seychelles'), (154, 'Sierra Leone'), 
(155, 'Singapore'), (156, 'Slovakia'), (157, 'Slovenia'), (158, 'Solomon Islands'), (159, 'Somalia'), 
(160, 'South Africa'), (161, 'South Korea'), (162, 'South Sudan'), (163, 'Spain'), (164, 'Sri Lanka'), 
(165, 'Sudan'), (166, 'Suriname'), (167, 'Sweden'), (168, 'Switzerland'), (169, 'Syria'), 
(170, 'Taiwan'), (171, 'Tajikistan'), (172, 'Tanzania'), (173, 'Thailand'), (174, 'Timor-Leste'), 
(175, 'Togo'), (176, 'Tonga'), (177, 'Trinidad and Tobago'), (178, 'Tunisia'), (179, 'Turkey'), 
(180, 'Turkmenistan'), (181, 'Tuvalu'), (182, 'Uganda'), (183, 'Ukraine'), (184, 'United Arab Emirates'), 
(185, 'United Kingdom'), (186, 'United States'), (187, 'Uruguay'), (188, 'Uzbekistan'), (189, 'Vanuatu'), 
(190, 'Vatican City'), (191, 'Venezuela'), (192, 'Vietnam'), (193, 'Yemen'), (194, 'Zambia'), (195, 'Zimbabwe');


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

INSERT INTO Reviews (stars, idUser, reviewsDescription)
VALUES (3, 5, 'Nice service!'),(5, 12, 'Excellent experience.'),
(4, 18, 'Good quality products.'),(2, 7, 'Disappointed with the service.'),
(5, 23, 'Highly recommended!'),(1, 9, 'Terrible experience.'),
(3, 16, 'Average service.'),(4, 3, 'Great value for money.'),
(5, 20, 'Best service ever!'),(2, 1, 'Poor customer service.'),
(4, 22, 'Quick delivery.'),(3, 10, 'Satisfied with the product.'),
(5, 14, 'Amazing quality!'),(1, 4, 'Worst experience ever.'),
(3, 6, 'Fair pricing.'),(4, 8, 'Friendly staff.'),
(2, 17, 'Not up to expectations.'),(5, 19, 'Absolutely fantastic!'),
(4, 2, 'Efficient service.'),(3, 24, 'Could be better.'),
(4, 11, 'Prompt response.'),(2, 21, 'Not satisfied with the product.'),
(5, 15, 'Excellent customer service!'),(3, 13, 'Could improve delivery time.'),
(4, 24, 'Good value for money.'),(1, 6, 'Extremely poor quality.'),
(5, 8, 'Highly impressed!'),(2, 3, 'Product did not meet expectations.'),
(4, 19, 'Satisfactory experience.'),(3, 22, 'Average quality.'),
(5, 2, 'Top-notch service!'),(4, 7, 'Efficient handling of queries.'),
(3, 12, 'Fairly good experience.'),(1, 10, 'Unacceptable service.'),
(5, 17, 'Absolutely delighted!'),(4, 9, 'Friendly and helpful staff.'),
(3, 16, 'Moderate pricing.'),(2, 23, 'Below average quality.'),
(5, 14, 'Impressive performance!'),(4, 1, 'Good communication.'),
(3, 20, 'Could be more responsive.'),(5, 18, 'Outstanding service!'),
(4, 5, 'Professional handling.'),(3, 4, 'Mediocre experience.'),
(1, 24, 'Very dissatisfied.'),(5, 6, 'Excellent value for money!'),
(4, 8, 'Courteous staff.'),(3, 13, 'Slightly disappointed.'),
(2, 19, 'Subpar quality.'),(5, 2, 'Exceptional service!'),
(4, 7, 'Timely delivery.'),(3, 12, 'Satisfactory overall.'),
(1, 10, 'Unsatisfactory service.'),(5, 17, 'Thrilled with the experience!'),
(4, 9, 'Helpful and accommodating.'),(3, 16, 'Reasonable pricing.'),
(2, 23, 'Poor quality products.'),(5, 14, 'Absolutely fantastic!'),
(5, 1, 'Good customer support.'),(3, 20, 'Room for improvement.'),
(5, 18, 'Exceptional performance!'),(4, 5, 'Efficient service delivery.'),
(3, 4, 'Average experience.'),(1, 24, 'Extremely dissatisfied.'),
(5, 6, 'Great value for money!'),(4, 8, 'Friendly and helpful service.'),
(3, 13, 'Somewhat underwhelming.'),(2, 19, 'Below standard quality.');

INSERT INTO Condition (condition)
VALUES ('New with tags'),('New without tags'), ('Very Good'), ('Good'), ('Satisfactory');

INSERT INTO Category (category)
VALUES ('Sports'),('Tecnology'),('Books'), ('Games'), ('Cars'), ('Kids'), ('Animals');   

INSERT INTO Sizes (tamanho)
VALUES ('Homem - XS'), ('Homem - S'), ('Homem - M'), ('Homem - L'), ('Homem - XL'), ('Homem - XXL'), 
('Mulher - XS'), ('Mulher - S'), ('Mulher - M'), ('Mulher - L'), ('Mulher - XL'), ('Mulher - XXL'), 
('Criança - 1 ano'), ('Criança - 2 anos'), ('Criança - 3-4 anos'), ('Criança - 5-6 anos'), ('Criança - 7-8 anos'), ('Criança - 9-10 anos'), ('Criança - 11-12 anos'), ('Criança - 13-14 anos'), ('Criança - 15-16 anos'),
('Tamanho unico');

INSERT INTO Product (prodName, prodDescription, price, condition, category, prodsize, seller)
VALUES ('Computer', 'Asus computer 2003', 40, 3, 2, 22, 6),
('Basketball', 'Brand new basketball', 25, 1, 1, 21, 8),
('iPhone X', 'Used iPhone X in good condition', 300, 4, 2, 12, 12),
('Harry Potter Books', 'Complete set of Harry Potter books', 50, 2, 3, 10, 17),
('PS5 Console', 'Brand new PS5 console with controller', 600, 1, 4, 21, 9),
('Toyota Camry', 'Used Toyota Camry 2018', 15000, 3, 5, 1, 14),
('Nike Running Shoes', 'Brand new Nike running shoes', 80, 1, 1, 6, 20),
('Dell Laptop', 'Refurbished Dell laptop with SSD', 500, 2, 2, 7, 11),
('Cooking Book', 'Best-selling cooking book with recipes', 30, 3, 3, 16, 24),
('Nintendo Switch', 'Nintendo Switch console with Mario Kart', 350, 1, 4, 21, 7),
('Ford Mustang', 'Used Ford Mustang GT 2019', 30000, 3, 5, 4, 18),
('Football Jersey', 'Official team jersey with player name', 60, 1, 1, 4, 15),
('Samsung Galaxy S20', 'Brand new Samsung Galaxy S20', 700, 1, 2, 12, 19),
('Gardening Tools Set', 'Complete set of gardening tools', 100, 2, 6, 20, 8),
('Board Game - Settlers of Catan', 'Classic board game for strategy lovers', 45, 2, 4, 18, 6),
('Sony 4K TV', '55-inch Sony 4K Smart TV', 900, 1, 2, 19, 10),
('Yoga Mat', 'High-quality yoga mat for home workouts', 20, 1, 1, 22, 13),
('Used Desktop PC', 'Older model desktop PC, good for basic tasks', 100, 3, 2, 7, 16),
('Classic Novels Collection', 'Collection of classic novels by famous authors', 40, 2, 3, 10, 21),
('FIFA 21 (PS4)', 'Pre-owned FIFA 21 game for PlayStation 4', 15, 4, 4, 21, 24),
('Bicycle Helmet', 'Safety helmet for cycling enthusiasts', 25, 1, 5, 21, 8),
('Coloring Book for kids', 'Coloring book with various themes for kids', 10, 5, 6, 20, 5),
('Bluetooth Earbuds', 'Wireless earbuds with charging case', 30, 2, 2, 22, 12),
('Camping Tent', 'Compact tent for outdoor camping adventures', 50, 3, 1, 19, 17),
('Used Xbox One', 'Pre-owned Xbox One console with controller', 80, 3, 4, 21, 11),
('DVD Movie Collection', 'Assorted collection of classic movies on DVD', 15, 2, 4, 21, 23);

INSERT INTO ShoppingCart (user, product)
VALUES (1, 10), (1,24), (1,3);

INSERT INTO Favorites (user, product)
VALUES (1, 10), (1,4), (1,24), (1,3), (1,9), (1,17);

INSERT INTO Recent (user, product)
VALUES (1,9), (1,17);

INSERT INTO Photo (idProduct, photo)
VALUES (6,'photo de um Toyota'), (6,'photo de um Toyota 2');