DROP TABLE IF EXISTS user;

CREATE TABLE user (
  id int Not NULL AUTO_INCREMENT,
  name MEDIUMTEXT Not NULL,  
  email varchar(255) not NULL,
  password MEDIUMTEXT not NULL,  
  start_date timestamp not NULL,
  expr_date timestamp not NULL,
  payment MEDIUMTEXT Default NULL,
  expired bit Default 0,  -- derived
  deleted bit default 0, -- newly added, indicates if this use has been removed from system  
  PRIMARY KEY (id),
  unique (email)
);

DROP TABLE IF EXISTS movie;
CREATE TABLE movie(
  id int Not NULL AUTO_INCREMENT,
  name MEDIUMTEXT Not NULL,
  year mediumint NOT NULL,
  director MEDIUMTEXT not NULL,
  picture MEDIUMTEXT not NULL,
  rating  MEDIUMTEXT not NULL,
  introduction TEXT,
  language MEDIUMTEXT not NULL,
  ave_star mediumint default 0,   -- derived
  studio MEDIUMTEXT not NULL,
  -- since genre is a multi-value attr, we have a table for it.
  count int Default 0,
  duration smallint not NULL,
  deleted bit default 0,  -- newly added, indicates if this movie has been removed from system 
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS administrator;

CREATE TABLE administrator(
  id int Not NULL AUTO_INCREMENT,
  name MEDIUMTEXT Not NULL,
  email varchar(255) not NULL,
  password MEDIUMTEXT  not NULL,
  PRIMARY KEY (id),
  unique (email)
);

DROP TABLE IF EXISTS actor;

CREATE TABLE actor(
  id int Not NULL AUTO_INCREMENT,
  name MEDIUMTEXT Not NULL,
  gender MEDIUMTEXT  Not NULL,
  deleted bit default 0, -- newly added, indicates if this actor has been removed from system 
  PRIMARY KEY (id)
); 

DROP TABLE IF EXISTS watched;
CREATE TABLE watched(
  id int Not NULL AUTO_INCREMENT,
  user_id int Not NULL,
  movie_id int  Not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (movie_id) REFERENCES movie(id)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

DROP TABLE IF EXISTS interested;
CREATE TABLE interested(
  id int Not NULL AUTO_INCREMENT,
  user_id int Not NULL,
  movie_id int  Not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (movie_id) REFERENCES movie(id)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

DROP TABLE IF EXISTS review;
CREATE TABLE review(
  id int Not NULL AUTO_INCREMENT,
  user_id int Not NULL,
  movie_id int  Not NULL,
  star int,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (movie_id) REFERENCES movie(id)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

DROP TABLE IF EXISTS comment;
CREATE TABLE comment(
  id int Not NULL AUTO_INCREMENT,
  user_id int Not NULL,
  movie_id int  Not NULL,
  comment TEXT,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (movie_id) REFERENCES movie(id)
ON DELETE CASCADE ON UPDATE CASCADE
); 

DROP TABLE IF EXISTS nova_movie.cast;
CREATE TABLE nova_movie.cast(
  id int Not NULL AUTO_INCREMENT,
  movie_id int  Not NULL,
  actor_id int Not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (actor_id) REFERENCES actor(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (movie_id) REFERENCES movie(id)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

DROP TABLE IF EXISTS genre;
CREATE TABLE genre(
  id int Not NULL AUTO_INCREMENT,
  movie_id int  Not NULL,
  type MEDIUMTEXT Not NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (movie_id) REFERENCES movie(id)
    ON DELETE CASCADE ON UPDATE CASCADE
); 

-- insertion for user table
insert into user(name,email,password,expr_date) values('Jessica', 'j@g','thisispassword','2013-12-09 00:00:01');

insert into user(name,email,password,expr_date) 
values('Mike', 'm@g', 'thisispassword', '2014-12-09 00:00:01');

insert into user(name,email,password,expr_date) values('apple','a@g','thisispassword','2013-12-08 00:00:01');

insert into user(name,email,password,expr_date) values('Rachel','r@g','thisispassword','2012-12-09 00:00:01');

-- insertion for movie table
insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Thor: The Dark World',2013,'Alan Taylor','this is pic location','PG-13','this is introduction','English','Walt Disney','90');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Gravity',2013,'Alfonso Cuaron','this is pic location','PG-13','this is introduction','English','Warner Bro.','91');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Carrie',2013,'Kimberly Peirce','this is pic location','R','this is introduction','English','MGM.','100');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Jackass Presents: Bad Grandpa',2013,'Jeff Tremaine','this is pic location','R','this is introduction','English','Paramount Pictures','91');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Prisoners',2013,'Denis Villeneuve','this is pic location','R','this is introduction','English','Warner Bro.','153');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Blue Is the Warmest Color',2013,'Abdekkatif Kechiche','this is pic location','NC-17','this is introduction','French','Wild Bunch','179');

insert into movie (name,year,director,picture,rating,introduction,language,studio,duration) values 
('Moonrise Kingdom',2012,'Wes Anderson','this is pic location','PG-13','this is introduction','English','Focus Feature.','94');

-- insertion for actor table

insert into actor (name,gender) values ('Chris Hemsworth','male'); -- thor
insert into actor (name,gender) values ('Natalie Portman', 'female'); -- thor
insert into actor (name,gender) values ('Tom Hiddleston', 'male'); -- thor

insert into actor (name,gender) values ('Sandra Bullock','female'); -- gravity
insert into actor (name,gender) values ('George Clooney','male'); -- gravity
insert into actor (name,gender) values ('Ed Harris','male'); -- gravity

insert into actor (name,gender) values ('Bruce Willis','male'); -- moonrise
insert into actor (name,gender) values ('Edward Norton','male'); -- moonrise

insert into actor (name,gender) values ('Lea Seydoux','female');  -- blue
insert into actor (name,gender) values ('Adele Exarchopoulos','female'); -- blue

insert into actor (name,gender) values ('Hugh Jackman','male'); -- prisoners
insert into actor (name,gender) values ('Viola Davis','male'); -- prisoners

insert into actor (name,gender) values ('Jackson Nicoll','male'); -- jackass

insert into actor (name,gender) values ('Julianne Moore','female'); -- carrie

-- insertion for administrator table
insert into administrator (name,email,password) values ('admin1','ad1@g','123');

insert into administrator (name,email,password) values ('admin2','ad2@g','123');

insert into administrator (name,email,password) values ('qicao','qicao@gmail','666');

