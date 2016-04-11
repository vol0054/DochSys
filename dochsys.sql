-- Adminer 4.2.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `dochazka`;
CREATE TABLE `dochazka` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pracovnik` int(11) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `prichod` datetime DEFAULT NULL,
  `odchod` datetime DEFAULT NULL,
  `obed_start` datetime DEFAULT NULL,
  `obed_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D1F921EA26B56DC` (`id_pracovnik`),
  CONSTRAINT `FK_D1F921EA26B56DC` FOREIGN KEY (`id_pracovnik`) REFERENCES `pracovnik` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `dovolena`;
CREATE TABLE `dovolena` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pracovnik` int(11) DEFAULT NULL,
  `od` date NOT NULL,
  `do` date NOT NULL,
  `schvalena` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_744315F3A26B56DC` (`id_pracovnik`),
  CONSTRAINT `dovolena_ibfk_1` FOREIGN KEY (`id_pracovnik`) REFERENCES `pracovnik` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `nemocenska`;
CREATE TABLE `nemocenska` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pracovnik` int(11) DEFAULT NULL,
  `od` date NOT NULL,
  `do` date NOT NULL,
  `schvalena` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E200216AA26B56DC` (`id_pracovnik`),
  CONSTRAINT `FK_E200216AA26B56DC` FOREIGN KEY (`id_pracovnik`) REFERENCES `pracovnik` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `pozice`;
CREATE TABLE `pozice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) NOT NULL,
  `popis` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `pracovnik`;
CREATE TABLE `pracovnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `os_cislo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jmeno` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prijmeni` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ulice` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `čislo_pop` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `psc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mesto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_pozice` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pozice` (`id_pozice`),
  CONSTRAINT `pracovnik_ibfk_1` FOREIGN KEY (`id_pozice`) REFERENCES `pozice` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2016-04-11 22:28:24
