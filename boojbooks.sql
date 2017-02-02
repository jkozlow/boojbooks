DROP DATABASE IF EXISTS `boojbooks`;
CREATE DATABASE IF NOT EXISTS `boojbooks`;

USE `boojbooks`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,  
  `updated_at` datetime DEFAULT NULL,  
  `expire_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `booklists`;
CREATE TABLE IF NOT EXISTS `booklists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `listname` varchar(100) NOT NULL, 
  `created_at` datetime DEFAULT NULL,  
  `updated_at` datetime DEFAULT NULL,   
  `expire_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `external_id` varchar(100) NOT NULL,
  `booklist_id` int not null default '0',
  `name` varchar(1000), 
  `author` varchar(100),
  `description` varchar(4000), 
  `infourl` varchar(1000), 
  `imageurl` varchar(1000), 
  `created_at` datetime DEFAULT NULL,  
  `updated_at` datetime DEFAULT NULL,  
  `expire_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;