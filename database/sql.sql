create database Alssafarah ;
use Alssafarah;
create table teachers
(
	id int primary key auto_increment,
	name varchar(150) not null,
	email varchar(250) not null unique,
	phone varchar(50),
	password varchar(500) not null
);

create table parents
(
	id int primary key auto_increment,
	name varchar(150) not null,
	email varchar(250) ,
	phone varchar(50) not null unique,
	password varchar(500) not null
);
create table students
(
	id int primary key auto_increment,
	name varchar(150) not null,
	phone varchar(50) not null,
    parent_id int not null,
    foreign key (parent_id) references parents(id) 
);

create table teachers_stuents_evaluations
(
	teacher_id int not null,
    student_id int not null,
    new_sura_start_name varchar(50) not null,
    new_sura_start_number varchar(5) not null,
	news_ura_end_name varchar(50) not null,
	new_sura_end_number varchar(5) not null,
    previous_sura_star_name varchar(50) not null,
    previous_sura_start_number varchar(5) not null,
    previous_sura_end_name varchar(50) not null,
    previous_sura_end_number varchar(5) not null,
    behavior varchar(250),
    attend bool default false,
	foreign key (teacher_id) references teachers(id) ,
	foreign key (student_id) references students(id) 
);


