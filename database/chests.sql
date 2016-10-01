/*
Navicat MySQL Data Transfer

Source Server         : asd
Source Server Version : 100110
Source Host           : localhost:3306
Source Database       : webcraft

Target Server Type    : MYSQL
Target Server Version : 100110
File Encoding         : 65001

Date: 2016-10-01 15:40:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chests
-- ----------------------------
DROP TABLE IF EXISTS `chests`;
CREATE TABLE `chests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` int(11) NOT NULL,
  `inventory` text COLLATE utf8_unicode_ci NOT NULL,
  `opened` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `body` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for community_market
-- ----------------------------
DROP TABLE IF EXISTS `community_market`;
CREATE TABLE `community_market` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(8,4) NOT NULL,
  `piece` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `meta` int(11) NOT NULL,
  `durability` int(11) NOT NULL,
  `max_durability` int(11) NOT NULL,
  `skills` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for friends
-- ----------------------------
DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `friendstime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for group_commands
-- ----------------------------
DROP TABLE IF EXISTS `group_commands`;
CREATE TABLE `group_commands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `command` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for group_features
-- ----------------------------
DROP TABLE IF EXISTS `group_features`;
CREATE TABLE `group_features` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `body` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for iconomy
-- ----------------------------
DROP TABLE IF EXISTS `iconomy`;
CREATE TABLE `iconomy` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `balance` double(64,2) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for last_payments
-- ----------------------------
DROP TABLE IF EXISTS `last_payments`;
CREATE TABLE `last_payments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for likeable
-- ----------------------------
DROP TABLE IF EXISTS `likeable`;
CREATE TABLE `likeable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `likeable_id` int(11) NOT NULL,
  `likeable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for notifications
-- ----------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notifiable_id` int(10) unsigned NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_id_notifiable_type_index` (`notifiable_id`,`notifiable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(8,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for stats3_arrows
-- ----------------------------
DROP TABLE IF EXISTS `stats3_arrows`;
CREATE TABLE `stats3_arrows` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_arrows_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_beds_entered
-- ----------------------------
DROP TABLE IF EXISTS `stats3_beds_entered`;
CREATE TABLE `stats3_beds_entered` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_beds_entered_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_blocks_broken
-- ----------------------------
DROP TABLE IF EXISTS `stats3_blocks_broken`;
CREATE TABLE `stats3_blocks_broken` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_blocks_broken_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_blocks_placed
-- ----------------------------
DROP TABLE IF EXISTS `stats3_blocks_placed`;
CREATE TABLE `stats3_blocks_placed` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_blocks_placed_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_buckets_emptied
-- ----------------------------
DROP TABLE IF EXISTS `stats3_buckets_emptied`;
CREATE TABLE `stats3_buckets_emptied` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_buckets_emptied_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_buckets_filled
-- ----------------------------
DROP TABLE IF EXISTS `stats3_buckets_filled`;
CREATE TABLE `stats3_buckets_filled` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_buckets_filled_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_commands_done
-- ----------------------------
DROP TABLE IF EXISTS `stats3_commands_done`;
CREATE TABLE `stats3_commands_done` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_commands_done_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_damage_taken
-- ----------------------------
DROP TABLE IF EXISTS `stats3_damage_taken`;
CREATE TABLE `stats3_damage_taken` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `cause` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_damage_taken_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_death
-- ----------------------------
DROP TABLE IF EXISTS `stats3_death`;
CREATE TABLE `stats3_death` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `cause` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_death_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_eggs_thrown
-- ----------------------------
DROP TABLE IF EXISTS `stats3_eggs_thrown`;
CREATE TABLE `stats3_eggs_thrown` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_eggs_thrown_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_fish_caught
-- ----------------------------
DROP TABLE IF EXISTS `stats3_fish_caught`;
CREATE TABLE `stats3_fish_caught` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_fish_caught_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_items_crafted
-- ----------------------------
DROP TABLE IF EXISTS `stats3_items_crafted`;
CREATE TABLE `stats3_items_crafted` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_items_crafted_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_items_dropped
-- ----------------------------
DROP TABLE IF EXISTS `stats3_items_dropped`;
CREATE TABLE `stats3_items_dropped` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_items_dropped_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_items_picked_up
-- ----------------------------
DROP TABLE IF EXISTS `stats3_items_picked_up`;
CREATE TABLE `stats3_items_picked_up` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_items_picked_up_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_joins
-- ----------------------------
DROP TABLE IF EXISTS `stats3_joins`;
CREATE TABLE `stats3_joins` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_joins_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_kill
-- ----------------------------
DROP TABLE IF EXISTS `stats3_kill`;
CREATE TABLE `stats3_kill` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `weapon` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `entityType` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_kill_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_last_join
-- ----------------------------
DROP TABLE IF EXISTS `stats3_last_join`;
CREATE TABLE `stats3_last_join` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_last_join_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_last_seen
-- ----------------------------
DROP TABLE IF EXISTS `stats3_last_seen`;
CREATE TABLE `stats3_last_seen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_last_seen_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_locks
-- ----------------------------
DROP TABLE IF EXISTS `stats3_locks`;
CREATE TABLE `stats3_locks` (
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`uuid`),
  CONSTRAINT `stats3_locks_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_money
-- ----------------------------
DROP TABLE IF EXISTS `stats3_money`;
CREATE TABLE `stats3_money` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_money_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_move
-- ----------------------------
DROP TABLE IF EXISTS `stats3_move`;
CREATE TABLE `stats3_move` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_move_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_omnomnom
-- ----------------------------
DROP TABLE IF EXISTS `stats3_omnomnom`;
CREATE TABLE `stats3_omnomnom` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_omnomnom_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_players
-- ----------------------------
DROP TABLE IF EXISTS `stats3_players`;
CREATE TABLE `stats3_players` (
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `name` varchar(255) COLLATE latin1_general_cs NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_playtime
-- ----------------------------
DROP TABLE IF EXISTS `stats3_playtime`;
CREATE TABLE `stats3_playtime` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_playtime_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_pvp
-- ----------------------------
DROP TABLE IF EXISTS `stats3_pvp`;
CREATE TABLE `stats3_pvp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `weapon` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `victim` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_pvp_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_pvp_streak
-- ----------------------------
DROP TABLE IF EXISTS `stats3_pvp_streak`;
CREATE TABLE `stats3_pvp_streak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_pvp_streak_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_pvp_top_streak
-- ----------------------------
DROP TABLE IF EXISTS `stats3_pvp_top_streak`;
CREATE TABLE `stats3_pvp_top_streak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_pvp_top_streak_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_shears
-- ----------------------------
DROP TABLE IF EXISTS `stats3_shears`;
CREATE TABLE `stats3_shears` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_shears_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_teleports
-- ----------------------------
DROP TABLE IF EXISTS `stats3_teleports`;
CREATE TABLE `stats3_teleports` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_teleports_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_times_changed_world
-- ----------------------------
DROP TABLE IF EXISTS `stats3_times_changed_world`;
CREATE TABLE `stats3_times_changed_world` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_times_changed_world_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_times_kicked
-- ----------------------------
DROP TABLE IF EXISTS `stats3_times_kicked`;
CREATE TABLE `stats3_times_kicked` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_times_kicked_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_tools_broken
-- ----------------------------
DROP TABLE IF EXISTS `stats3_tools_broken`;
CREATE TABLE `stats3_tools_broken` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  `name` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_tools_broken_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_trades
-- ----------------------------
DROP TABLE IF EXISTS `stats3_trades`;
CREATE TABLE `stats3_trades` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_trades_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_words_said
-- ----------------------------
DROP TABLE IF EXISTS `stats3_words_said`;
CREATE TABLE `stats3_words_said` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_words_said_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for stats3_xp_gained
-- ----------------------------
DROP TABLE IF EXISTS `stats3_xp_gained`;
CREATE TABLE `stats3_xp_gained` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE latin1_general_cs NOT NULL,
  `value` double NOT NULL,
  `world` varchar(255) COLLATE latin1_general_cs DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uuid` (`uuid`),
  CONSTRAINT `stats3_xp_gained_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `stats3_players` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_cs;

-- ----------------------------
-- Table structure for statuses
-- ----------------------------
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE `statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wall_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(8,4) NOT NULL,
  `ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `lastlogin` bigint(20) NOT NULL,
  `x` double NOT NULL DEFAULT '0',
  `y` double NOT NULL DEFAULT '0',
  `z` double NOT NULL DEFAULT '0',
  `world` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `realname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `isLogged` smallint(6) NOT NULL,
  `isVerified` smallint(6) NOT NULL,
  `isAdmin` smallint(6) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
