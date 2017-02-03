DROP DATABASE IF EXISTS `boojbooks`;
CREATE DATABASE IF NOT EXISTS `boojbooks`;

USE `boojbooks`;

DROP TABLE IF EXISTS `booklists`;
CREATE TABLE IF NOT EXISTS `booklists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `listname` varchar(100) NOT NULL, 
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
  `author` varchar(1000),
  `description` TEXT, 
  `notes` TEXT, 
  `pagenum` varchar(100), 
  `page_count` varchar(100),
  `infourl` varchar(1000), 
  `imageurl` varchar(1000), 
  `category` varchar(1000), 
  `created_at` datetime DEFAULT NULL,  
  `updated_at` datetime DEFAULT NULL,  
  `expire_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
