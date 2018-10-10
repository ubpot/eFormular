-- Datenbank: eFormular

-- Tabelle Folder

CREATE TABLE `Folder` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)

;


-- Tabelle Formdata


CREATE TABLE `Formdata` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`json` LONGTEXT NOT NULL,
	`id_Form` INT(11) NOT NULL DEFAULT '0',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`version` INT(11) NOT NULL DEFAULT '1',
	`prevVersion` INT(11) NULL DEFAULT NULL,
	`nextVersion` INT(11) NULL DEFAULT NULL,
	`editor` VARCHAR(50) NOT NULL DEFAULT '',
	`id_Tray` INT(11) NULL DEFAULT NULL,
	`status` VARCHAR(50) NOT NULL DEFAULT '',
	`id_Folder` INT(11) NULL DEFAULT NULL,
	`block_begin` DATETIME NULL DEFAULT NULL,
	`block_id_User` INT(11) NULL DEFAULT NULL,
	`hinttext` TEXT NULL,
	`timestamp` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `IDX_Folderid` (`id_Folder`),
	INDEX `IDX_Formid` (`id_Form`),
	INDEX `IDX_Trayid` (`id_Tray`),
	INDEX `IDX_prevVersion` (`prevVersion`),
	INDEX `IDX_Formdata_6` (`nextVersion`)
)
;

-- Tabelle Formular


CREATE TABLE `Formular` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`html` LONGTEXT NOT NULL,
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`version` INT(11) NOT NULL DEFAULT '1',
	`prevVersion` INT(11) NULL DEFAULT NULL,
	`nextVersion` INT(11) NULL DEFAULT NULL,
	`editor` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
;

-- Tabelle Formvalues

CREATE TABLE `Formvalues` (
	`id_Element` VARCHAR(255) NOT NULL DEFAULT '',
	`id_Formdata` INT(11) NOT NULL DEFAULT '0',
	`value` TEXT NOT NULL,
	PRIMARY KEY (`id_Element`, `id_Formdata`)
)
;

-- Tabelle Mailtempl

CREATE TABLE `Mailtempl` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT '',
	`params` VARCHAR(255) NOT NULL DEFAULT '',
	`text` TEXT NOT NULL,
	`editor` VARCHAR(50) NULL DEFAULT NULL,
	`timestamp` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`)
)
;

-- Tabelle Searchstring

CREATE TABLE `Searchstring` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sstring` TEXT NOT NULL,
	`title` VARCHAR(200) NULL DEFAULT NULL,
	`editor` VARCHAR(100) NULL DEFAULT NULL,
	`timestamp` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`)
)
;

-- Tabelle Tray

CREATE TABLE `Tray` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL DEFAULT '',
	`editor` VARCHAR(100) NULL DEFAULT NULL,
	`timestamp` TIMESTAMP NOT NULL,
	PRIMARY KEY (`id`)
)
;

-- Tabelle User

CREATE TABLE `User` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(50) NOT NULL DEFAULT '',
	`passwd` VARCHAR(50) NOT NULL DEFAULT '',
	`login` VARCHAR(50) NOT NULL DEFAULT '',
	`page` TEXT NULL,
	`shortname` VARCHAR(50) NOT NULL DEFAULT '',
	`role` ENUM('admin') NULL DEFAULT NULL,
	`timestamp` TIMESTAMP NOT NULL,
	`editor` VARCHAR(100) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
;

-- Tabelle Watchlist

CREATE TABLE `Watchlist` (
	`id_User` INT(11) NOT NULL DEFAULT '0',
	`id_FormData` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id_User`, `id_FormData`)
)
;
