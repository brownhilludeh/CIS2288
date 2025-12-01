DROP USER IF EXISTS 'web_only_user'@'localhost';
 /* Next line creates a ‘non-root’ user in MySQL
   This user will have select, insert, update, delete privileges
   We will use this user in our activity
 */
CREATE USER 'web_only_user'@'localhost' IDENTIFIED BY 'web_secret_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON books . * TO 'web_only_user'@'localhost';

/*For changes to take effect immediately flush the privileges*/
flush privileges;

/*grant select, insert, update, delete on books.* to 'web_only_user'@'localhost' identified by 'web_secret_password';*/

