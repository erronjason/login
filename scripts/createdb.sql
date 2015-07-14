create table if not exists users(
  id int not null auto_increment,
  primary key(id),
  username varchar(32) not null,
  unique key username(username),
  email varchar(254) not null,
  password varchar(256) not null
)default character set=utf8;
insert into users (username, email, password) values ('Jason', 'jason@example.com', '$2y$10$Ejfrungn2b39F6p05MOf..z1HlqLjj.Khxf4py156.AwUwYm.oa5i'); # password1
insert into users (username, email, password) values ('Nick', 'nick@example.com', '$2y$10$/ZtY9gQleN6rsl2O9ANL5.zVfwk9U7TKuR.SBnGF4wK9v533VUdVS'); # password2
# insert into users (username, email, password, salt) values ('Gabe', 'gabe@example.com', '$2y$10$3SrK3YRqN8B8zp5PQ6LJd.ASpAMtYOWlq/e1wyshHFtUHD8Ypoa4K'); # password3
