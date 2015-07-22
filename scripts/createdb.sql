create table if not exists users(
  id int not null auto_increment,
  primary key(id),
  username varchar(32) not null,
  unique key username(username),
  email varchar(254) not null,
  password varchar(256) not null
)default character set=utf8;
