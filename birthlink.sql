create database birthlink;

use birthlink;
create table user (
	uID int auto_increment not null,
    fName varchar(50) not null,
    lName varchar(50) not null,
    nic varchar(11) not null,
    contactNo varchar(10) not null,
    email varchar(50) not null,
    address varchar(255) not null,
    `password` varchar(20) not null,
    `type` varchar(20) not null,
    `token` int,
	primary key (uID)
);
insert into user(fName,lName,nic,contactNo,email,address,`password`,`type`) values 
("Ashen","Kavinda","200307200526","0774231741","kavindahemarathna321@gmail.com","Kalegana","1234","mother");

use birthlink;
create table mother (
	uID int not null,
    birthDay date not null,
    primary key (uID),
    foreign key (uID) references `user`(uID)
);
insert into mother values
(1,"1971-08-12");

use birthlink;
create table pregnancy (
	pID int auto_increment not null,
    uID int not null,
    `date` date not null,
    primary key (pID),
    foreign key (uID) references `user`(uID) 
);
use birthlink;
insert into pregnancy(uID,`date`) values
(1,"2002-10-15");

use birthlink;
create table baby (
	bID int auto_increment not null,
    pID int not null,
    bDay date not null,
    birthNumber int,
    gender varchar(10) not null,
    primary key (bID),
    foreign key (pID) references pregnancy(pID)
);
use birthlink;
insert into baby(pID,bDay,birthNumber,gender)
values (1,"2003-03-12",12321,"male");


use birthlink;
create table disease (
	dID int auto_increment not null,
    `name` varchar(100) not null,
    `discription` text not null,
    primary key (dID) 
);
use birthlink;
-- Insert dummy data into the disease table
INSERT INTO disease (`name`, `discription`) VALUES
('Diabetes', 'A chronic condition that affects the body\'s ability to process blood sugar.'),
('Hypertension', 'A condition in which the force of the blood against the artery walls is too high.'),
('Asthma', 'A respiratory condition marked by spasms in the bronchi of the lungs, causing difficulty in breathing.'),
('Anemia', 'A condition in which there is a deficiency of red cells or hemoglobin in the blood.'),
('Heart Disease', 'Any disorder that affects the heart\'s ability to function normally.');


use birthlink;
create table notePreg(
	slID int auto_increment not null,
	pID int not null,
    dID int not null,
	`date` date not null,
    primary key (slID),
    foreign key (dID) references disease(dID),
    foreign key (pID) references pregnancy(pID)
);
use birthlink;
-- Insert dummy data into the notePreg table for one pID
INSERT INTO notePreg (pID, dID, `date`) VALUES
(1, 1, '2024-09-01'),
(1, 2, '2024-09-02'),
(1, 3, '2024-09-03'),
(1, 4, '2024-09-04'),
(1, 5, '2024-09-05');

create table noteBaby(
	slID int auto_increment not null,
    bID int not null,
    dID int not null,
    `date` date not null,
    primary key (slID),
    foreign key (bID) references baby(bID),
    foreign key (dID) references disease(dID)
);
use birthlink;
-- Insert dummy data into the notePreg table for one pID
INSERT INTO noteBaby (bID, dID, `date`) VALUES
(1, 1, '2024-09-01'),
(1, 2, '2024-09-02'),
(1, 3, '2024-09-03'),
(1, 4, '2024-09-04'),
(1, 5, '2024-09-05');
