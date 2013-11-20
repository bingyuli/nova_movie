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