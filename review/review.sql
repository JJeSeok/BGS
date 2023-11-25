CREATE TABLE review(
    num INTEGER AUTO_INCREMENT,
    id VARCHAR(15) NOT NULL,
    userid VARCHAR(15) NOT NULL,
    name VARCHAR(20) NOT NULL,
    story TEXT,
    redate DATETIME,
    PRIMARY KEY(num)
);

