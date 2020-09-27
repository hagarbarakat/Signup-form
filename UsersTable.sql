Create Table Users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(400) NOT NULL,
    phone varchar(20) NOT NULL,
    email varchar(50) NOT NULL UNIQUE,
    verified boolean NOT NULL,
    code VARCHAR(50) DEFAULT NULL
);