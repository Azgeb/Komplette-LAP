CREATE DATABASE onlinekursverwaltung; 

USE onlinekursverwaltung; 

CREATE TABLE `t_internal_user` 
  ( 
     `internal_user_id` INT NOT NULL auto_increment, 
     `is_administrator` VARCHAR(1) NOT NULL, 
     `email`            VARCHAR(255) NOT NULL, 
     `password`         VARCHAR(255) NOT NULL, 
     `firstname`        VARCHAR(255) NOT NULL DEFAULT '', 
     `lastname`         VARCHAR(255) NOT NULL DEFAULT '', 
     `postal_code`      VARCHAR(255) NOT NULL, 
     `city`             VARCHAR(255) NOT NULL, 
     `street`           VARCHAR(255) NOT NULL DEFAULT '', 
     `created_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     PRIMARY KEY (`internal_user_id`), 
     UNIQUE (`email`) 
  ) 
engine = innodb 
DEFAULT charset=utf8 
COLLATE=utf8_unicode_ci; 

CREATE TABLE `t_course` 
  ( 
     `course_id`        INT NOT NULL auto_increment, 
     `name`             VARCHAR(255) NOT NULL, 
     `internal_user_id` INT NOT NULL, 
     PRIMARY KEY (`course_id`) 
  ) 
engine = innodb 
DEFAULT charset=utf8 
COLLATE=utf8_unicode_ci; 

CREATE TABLE `t_user` 
  ( 
     `user_id`     INT NOT NULL auto_increment, 
     `course_id`   INT NOT NULL, 
     `email`       VARCHAR(255) NOT NULL, 
     `password`    VARCHAR(255) NOT NULL, 
     `firstname`   VARCHAR(255) NOT NULL DEFAULT '', 
     `lastname`    VARCHAR(255) NOT NULL DEFAULT '', 
     `postal_code` VARCHAR(255) NOT NULL, 
     `city`        VARCHAR(255) NOT NULL, 
     `street`      VARCHAR(255) NOT NULL DEFAULT '', 
     `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
     PRIMARY KEY (`user_id`), 
     UNIQUE (`email`) 
  ) 
engine = innodb 
DEFAULT charset=utf8 
COLLATE=utf8_unicode_ci; 

CREATE TABLE `t_document` 
  ( 
     `document_id`  INT NOT NULL auto_increment, 
     `course_id`    VARCHAR(255) NOT NULL, 
     `path`         VARCHAR(255) NOT NULL, 
     `display_name` VARCHAR(255) NOT NULL, 
     PRIMARY KEY (`document_id`) 
  ) 
engine = innodb 
DEFAULT charset=utf8 
COLLATE=utf8_unicode_ci; 

INSERT INTO t_user 
            (course_id, 
             email, 
             password, 
             firstname, 
             lastname, 
             postal_code, 
             city, 
             street) 
VALUES      (1, 
             'example@user.com', 
             '$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu', 
             'Test', 
             'Example', 
             '0000', 
             'city', 
             'street'); 

INSERT INTO t_internal_user 
            (internal_user_id, 
             is_administrator, 
             email, 
             password, 
             firstname, 
             lastname, 
             postal_code, 
             city, 
             street) 
VALUES      (1, 
             'y', 
             'admin@intern.com', 
             '$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu', 
             'Admin', 
             'Intern', 
             '0000', 
             'city', 
             'street'); 

INSERT INTO t_internal_user 
            (internal_user_id, 
             is_administrator, 
             email, 
             password, 
             firstname, 
             lastname, 
             postal_code, 
             city, 
             street) 
VALUES      (2, 
             'n', 
             'trainer@intern.com', 
             '$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu', 
             'Trainer', 
             'Intern', 
             '0000', 
             'city', 
             'street'); 

INSERT INTO t_course 
            (course_id, 
             name, 
             internal_user_id) 
VALUES      (1, 
             'Informatik', 
             1); 

INSERT INTO t_course 
            (course_id, 
             name, 
             internal_user_id) 
VALUES      (2, 
             'Mechatronik', 
             1); 

INSERT INTO t_course 
            (course_id, 
             name, 
             internal_user_id) 
VALUES      (3, 
             'Technik', 
             1); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (1, 
             'src/assets/Informatik1.pdf', 
             'Informatik 1'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (1, 
             'src/assets/Informatik2.pdf', 
             'Informatik 2'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (1, 
             'src/assets/Informatik3.pdf', 
             'Informatik 3'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (2, 
             'src/assets/Mechatronik1.pdf', 
             'Mechatronik 1'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (2, 
             'src/assets/Mechatronik2.pdf', 
             'Mechatronik 2'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (2, 
             'src/assets/Mechatronik3.pdf', 
             'Mechatronik 3'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (3, 
             'src/assets/Technik1.pdf', 
             'Technik 1'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (3, 
             'src/assets/Technik2.pdf', 
             'Technik 2'); 

INSERT INTO t_document 
            (course_id, 
             path, 
             display_name) 
VALUES      (3, 
             'src/assets/Technik3.pdf', 
             'Technik 2'); 