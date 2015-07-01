CREATE TABLE users(
  id int NOT NULL auto_increment,
  PRIMARY KEY (id),
  username varchar(32) NOT NULL,
  UNIQUE KEY username(username),
  password char(64)
);
