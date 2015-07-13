create table users(
  id int not null auto_increment,
  primary key(id),
  username varchar(32) not null,
  unique key username(username),
  email varchar(254),
  password char(64),
  salt char(64)
);
insert into users (username, email, password, salt) values ('Jason', 'ejsayre@example.com', 'pass', 'salt');
insert into users (username, email, password, salt) values ('Nick', 'nick@example.com', 'password1234', 'salt');
# insert into users (username, email, password, salt) values ('Gabe', 'gabe@example.com', 'pass321', 'salt');
