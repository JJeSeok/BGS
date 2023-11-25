CREATE TABLE member(
    num INTEGER NOT NULL AUTO_INCREMENT,
    id VARCHAR(15) NOT NULL,
    pass VARCHAR(15) NOT NULL,
    name VARCHAR(20) NOT NULL,
    email VARCHAR(80),
    regist_day VARCHAR(20),
    level INTEGER,
    phnum INTEGER,
    PRIMARY KEY(num),
    UNIQUE(id)
);