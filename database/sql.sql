create database Alssafarah ;
use Alssafarah;
create table admins
(
	id int primary key auto_increment,
	name varchar(150) not null,
	email varchar(250) not null unique,
	password varchar(500) not null
);
create table teachers
(
	id int primary key auto_increment,
	name varchar(150) not null,
	email varchar(250) not null unique,
	phone varchar(50),
	password varchar(500) not null,
	Alhalka_Number  varchar(5) not null unique,
    admin_id int not null ,
    foreign key (admin_id) references admins(id)
);

create table parents
(
	id int primary key auto_increment,
	name varchar(150) not null,
	phone varchar(50) not null unique,
	password varchar(500) not null,
	admin_id int not null ,
    foreign key (admin_id) references admins(id)
);
create table students
(
	id int primary key auto_increment,
	name varchar(150) not null,
    ssn varchar(50) not null unique,
	parent_phone varchar(50) not null,
	new_sura_start_name varchar(50) ,
    new_sura_start_number varchar(5) ,
	new_sura_end_name varchar(50) ,
	new_sura_end_number varchar(5) ,
    revision_sura_start_name varchar(50),
    revision_sura_start_number varchar(5) ,
    revision_sura_end_name varchar(50) ,
    revision_sura_end_number varchar(5),
    behavior varchar(250),
    attend bool default false,
    parent_id int ,
	admin_id int not null ,
    teacher_id int ,
	foreign key (teacher_id) references teachers(id) ,
    foreign key (admin_id) references admins(id),
    foreign key (parent_id) references parents(id) 
);
select * from admins;
select * from parents;
select * from students;
select * from teachers;
#ALTER TABLE parents AUTO_INCREMENT = 1;




