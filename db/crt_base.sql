create database if not exists planning character set utf8 collate utf8_unicode_ci;
use planning;

grant all privileges on planning.* to 'planning_user'@'localhost' identified by 'secret';     