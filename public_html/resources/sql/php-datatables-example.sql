/*
 Navicat MySQL Data Transfer

 Source Server         : Local Machine
 Source Server Version : 50144
 Source Host           : localhost
 Source Database       : php-datatables

 Target Server Version : 50144
 File Encoding         : utf-8

 Date: 06/24/2011 14:35:18 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'aaarrrggh', 'Paul', 'Hammond'), ('2', 'jeff', 'Jeff', 'Lloyd'), ('3', 'christoph', 'Chris', 'Byatte'), ('4', 'mr_x', 'Richard', 'Stewart'), ('5', 'clowny', 'Andrew', 'Phillips'), ('6', 'moses', 'Sam', 'Smith'), ('7', 'sammy', 'Samantha', 'Smith'), ('8', 'blackout', 'Michael', 'Biggins'), ('9', 'redman', 'Peter', 'Ashdown'), ('10', 'micky', 'Michael', 'Anderson'), ('11', 'homer', 'Homer', 'Simpson');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
