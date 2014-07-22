/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50535
Source Host           : localhost:3306
Source Database       : alex_erp2

Target Server Type    : MYSQL
Target Server Version : 50535
File Encoding         : 65001

Date: 2014-07-22 18:07:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `email` text,
  `name` text,
  `surname` text,
  `phone` text,
  `address` text,
  `remark` text,
  `additional_params` text,
  `role` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  `avatar` text,
  `position_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`),
  KEY `city_id` (`city_id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `user_cities` (`id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'darkoffalex@yandex.ru', 'Valery', 'Gatalsky', '123456', '', '', null, '1', '1', '1405511917', '1405944551', '1', '4eyKD9En.jpg', '1', '1');
INSERT INTO `users` VALUES ('3', 'test', '81dc9bdb52d04dc20036dbd8313ed055', 'email@test.com', 'Vasia', 'Pupkin', '5468514', 'Test', 'Remark', null, '0', '1', '1405511917', '1405931601', '1', 'HBTbtBrY.jpg', '2', '2');
INSERT INTO `users` VALUES ('4', 'rest', '81dc9bdb52d04dc20036dbd8313ed055', 'darkoffalex@yandex.ru', 'Pinislav', 'Kuriskin', '5489465', null, null, null, '0', '1', '1405511917', '1405511917', '1', 'HBTbtBrY.jpg', '2', '3');
