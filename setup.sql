CREATE DATABASE giveaways;

CREATE TABLE `giveaways`.`giveaway` (`g_id` BIGINT NOT NULL AUTO_INCREMENT , `g_name` TEXT NOT NULL , `g_description` TEXT NOT NULL , `g_participants` TEXT NOT NULL , `g_prize` TEXT NOT NULL , `g_winner` TEXT NOT NULL , `g_timeleft` TEXT NOT NULL , `g_host` TEXT NOT NULL , `g_webhook` TEXT NOT NULL , `g_webhook_url` TEXT NOT NULL , `g_channel_id` TEXT NOT NULL , `g_public` TEXT NOT NULL , `g_status` TEXT NULL , PRIMARY KEY (`g_id`)) ENGINE = InnoDB; 

CREATE TABLE `giveaways`.`users` (`id` BIGINT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `email` TEXT NOT NULL , `status` TEXT NOT NULL , `giveaway` TEXT NOT NULL , `conf` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB; 