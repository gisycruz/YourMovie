create database if not exists yourMovie;
#drop database yourmovie;
use yourmovie ;

#drop table role;
CREATE TABLE if not exists ROLE(
id_role TINYINT UNSIGNED AUTO_INCREMENT NOT NULL,
priority VARCHAR(30),
CONSTRAINT pk_id_rol PRIMARY KEY (id_role)
)ENGINE=INNODB;

INSERT INTO role (priority) VALUES ('Administrator');
INSERT INTO role (priority) VALUES ('Customer');

#drop table user;
create table if not exists user(
user_id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
username VARCHAR(50) not null unique,
password VARCHAR(50) not null,
role TINYINT UNSIGNED NOT NULL,
firstName VARCHAR(50) not null,
lastName VARCHAR(50) not null,
dni  VARCHAR(9) not null,
birthDate DATE not null,
constraint pk_iduser PRIMARY kEY(user_id) ,
constraint fk_role foreign key (role) references role(id_role)
)ENGINE=INNODB; 

INSERT INTO user (username,password ,role,firstName,lastName,dni,birthdate) VALUES ('giselamarcelacruz@gmail.com',1234,1,"Gisela","Cruz","31958347","1985-11-19");
INSERT INTO user (username,password ,role,firstName,lastName,dni,birthdate) VALUES ('abotlucasmdq@gmail.com',5678,1,"Lucas","Abot","32876569","1993-05-25");


#drop table cinema;
create table if not exists cinema(
id_cinema BIGINT UNSIGNED not null auto_increment ,
name  VARCHAR(30) not null unique,
address VARCHAR(30) not null unique,
constraint pk_idcinema PRIMARY KEY(id_cinema) 
)ENGINE=INNODB;

#drop table room;
create table if not exists room(
id_room BIGINT UNSIGNED not null auto_increment ,
name VARCHAR(30) not null unique,
capacity BIGINT UNSIGNED not null ,
ticketvalue DECIMAL(10, 2) DEFAULT 0 not null, 
idcinema BIGINT UNSIGNED not null,
constraint pk_room primary key(id_room),
constraint fk_idcinema foreign key (idcinema) references cinema(id_cinema) on update CASCADE
)ENGINE=INNODB;

#drop table genre;
create table if not exists genre(
id_genre BIGINT UNSIGNED not null,
genrename VARCHAR(30) not null unique,
constraint unique(id_genre),
constraint pk_idgenre primary key(id_genre)
)ENGINE=INNODB;

#drop table movie;
create table if not exists movie(
id_movie BIGINT UNSIGNED not null,
title VARCHAR(50) not null ,
language TINYTEXT not null,
url_image LONGBLOB not null ,
duration VARCHAR(10) ,
overview VARCHAR(1500),
idgenre BIGINT UNSIGNED not null,
constraint pk_idmovie primary key(id_movie),
CONSTRAINT fk_idgenre FOREIGN KEY (idgenre) references genre(id_genre) 
)ENGINE=INNODB; 

#drop table screening;
create table if not exists screening(
id_screening BIGINT UNSIGNED not null auto_increment,
idroom BIGINT UNSIGNED not null,
idmovie BIGINT UNSIGNED not null ,
date_screening DATE not null,
hour_screening TIME not null,
constraint pk_idscreenig PRIMARY KEY (id_screening),
constraint fk_idmovie foreign key (idmovie) references movie(id_movie) on update CASCADE,
constraint fk_idroom foreign key (idroom) references room(id_room) on update CASCADE
)ENGINE=INNODB;

drop table shopping;

create table if not exists shopping(
id_shopping BIGINT UNSIGNED not null auto_increment,
iduser  BIGINT UNSIGNED not null,   
idscreening  BIGINT UNSIGNED not null,
dateShopping DATETIME not null,
countrticket SMALLINT UNSIGNED NOT NULL,
priceRoom   DECIMAL(10, 2) DEFAULT 0 not null,
total DECIMAL(10, 2) DEFAULT 0 not null,
constraint pk_idshopping PRIMARY KEY (id_shopping),
constraint fk_iduser foreign key (iduser) references user(user_id) on update CASCADE,
constraint fk_idscreening foreign key (idscreening) references screening(id_screening) on update CASCADE
)ENGINE=INNODB;

INSERT INTO shopping (iduser,idscreening , dateShopping,countrticket,priceRoom ,total) VALUE (1,3,"2000-12-34",2,200,400);

DROP TABLE TICKET;
create table if not exists ticket(
id_ticket BIGINT UNSIGNED not null auto_increment, 
idshopping BIGINT UNSIGNED not null ,
seat BIGINT UNSIGNED not null ,
numberTicket VARCHAR(255) NOT NULL unique,
qr VARCHAR(255) NOT NULL ,
constraint pk_idticket PRIMARY KEY (id_ticket),
constraint fk_idshopping foreign key (idshopping) references shopping(id_shopping) on update CASCADE
)ENGINE=INNODB;

DELIMITER $$
create procedure deleteCinema(idcinemas int)
BEGIN
declare idroom int default 0;
select id_room into idroom from room where idcinema = idcinemas;
if(idroom <> 0) then
SIGNAL sqlstate '11111' SET MESSAGE_TEXT = 'Result consisted of more than one row', MYSQL_ERRNO = 9999;
else 
delete from cinema where id_cinema = idcinemas;
end if;
END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS deleteRoom;

DELIMITER $$
create procedure deleteRoom(idrooms int)
begin
declare idscreening int default 0;
select id_screening into idscreening from screening where idroom = idrooms;
if(idscreening <> 0) then
SIGNAL sqlstate '11111' SET MESSAGE_TEXT = 'Result consisted of more than one row', MYSQL_ERRNO = 9999;
else 
delete from room where id_room = idrooms;
end if;
END $$
DELIMITER ;
