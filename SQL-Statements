CREATE DATABASE LAP;

USE LAP;

CREATE TABLE `t_user` ( 
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `firstname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `lastname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `user_role` INT NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`), UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO t_user
(email, password, firstname, lastname, user_role)
values
('example@example.com','$2y$10$qCgb4MKzbMKAqUU2LOFBQ.wGoAD6yBElFA7V7EPwK.QGCViJjx4mu','Test','Example',0);

CREATE TABLE `t_event` ( 
  `id` INT NOT NULL AUTO_INCREMENT ,
  `heading` VARCHAR(255) NOT NULL ,
  `description` VARCHAR(255) NOT NULL ,
  `event_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO t_event
(heading, description)
values
('LAP','This is an default description for the LAP!!');

INSERT INTO t_event
(heading, description)
values
('!LAP!','!!!!!!!!!!!!!!!!!!!!!!!!!This is an default description for the LAP!!');

CREATE TABLE t_event_user
( user_id INT(11) NOT NULL COMMENT 'PK, FK ref t_user(id)'
, event_id INT(11) NOT NULL COMMENT 'PK, FK ref t_event(id)'
, PRIMARY KEY (user_id, event_id)
);

INSERT INTO t_event_user(user_id, event_id)
values(1,1);
