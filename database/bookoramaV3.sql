/* create the database */
drop database if exists books;
create database if not exists books;
use books;

create table customers
( id int unsigned not null auto_increment primary key,
  name char(50) not null,
  address char(100) not null,
  city char(30) not null
);

/* Referential Integrity is defined
ON DELETE CASCADE - If customer is deleted all orders for that customer are deleted*/
create table orders
( id int unsigned not null auto_increment primary key,
  customerid int unsigned not null,
  amount float(6,2),
  date date not null,
  FOREIGN KEY (customerid) REFERENCES customers(id) ON DELETE CASCADE
);

create table books
(  id int unsigned not null auto_increment primary key,
isbn char(13) not null,
   author char(50),
   title char(100),
   price float(4,2),
   UNIQUE KEY unique_isbn (isbn)
);

create table order_items
( id int unsigned not null auto_increment primary key,
  orderid int unsigned not null,
  bookid int unsigned not null,
  quantity tinyint unsigned,
  FOREIGN KEY (orderid) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (bookid) REFERENCES books(id) ON DELETE CASCADE
);
create table book_reviews
(
  id int unsigned not null auto_increment primary key,
  isbn char(13) not null,
   author char(50),
  review text,
   UNIQUE KEY unique_author_review (author)
);

create table external_users
(
id int unsigned not null auto_increment primary key,
    custUser varchar(20),
    custPass varchar(40)
);
/* MySQL sha1() function calculates an SHA-1 160-bit checksum for a string. */
insert into external_users values (NULL,'siteAdminAccount', sha1('CISpass'));

insert into customers values
  (NULL,"Julie Smith", "25 Oak Street", "Airport West"),
  (NULL,"Alan Wong", "1/47 Haines Avenue", "Box Hill"),
  (NULL,"Michelle Arthur", "357 North Road", "Yarraville");

insert into orders values
  (NULL, 3, 69.98, "2017-04-02"),
  (NULL, 1, 49.99, "2016-04-15"),
  (NULL, 2, 74.98, "2015-04-19"),
  (NULL, 3, 24.99, "2014-05-01");

insert into books values
  (NULL,"0-672-31697-8", "Michael Morgan", "Java 2 for Professional Developers", 34.99),
  (NULL,"0-672-31745-1", "Thomas Down", "Installing Debian GNU/Linux", 24.99),
  (NULL,"0-672-31509-2", "Pruitt, et al.", "Teach Yourself GIMP in 24 Hours", 24.99),
  (NULL,"0-672-31769-9", "Thomas Schenk", "Caldera OpenLinux System Administration Unleashed", 49.99);

insert into order_items values
  (NULL,1, 1, 2),
  (NULL,2, 3, 1),
  (NULL,3, 2, 1),
  (NULL,3, 4, 1),
  (NULL,4, 2, 3);

insert into book_reviews values
  (null,"0-672-31697-8","Donnie Bowers", "Morgan's book is clearly written and goes well beyond most of the basic Java books out there.");
