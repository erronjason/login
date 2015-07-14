create table if not exists users(
  id int not null auto_increment,
  primary key(id),
  username varchar(32) not null,
  unique key username(username),
  email varchar(254),
  password char(256)
)default character set=utf8;
insert into users (username, email, password, salt) values ('Jason', 'ejsayre@example.com', 'pass');
insert into users (username, email, password, salt) values ('Nick', 'nick@example.com', 'password1234');
# insert into users (username, email, password, salt) values ('Gabe', 'gabe@example.com', 'pass321');
