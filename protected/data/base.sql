/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : alex_erp2

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2014-08-25 12:29:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `clients`
-- ----------------------------
DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `company_name` text,
  `surname` text,
  `personal_code` text,
  `company_code` text,
  `vat_code` text,
  `first_invoice_id` int(11) DEFAULT NULL,
  `last_invoice_id` int(11) DEFAULT NULL,
  `phones` text,
  `phone1` text,
  `phone2` text,
  `emails` text,
  `email1` text,
  `email2` text,
  `remark` text,
  `remark_for_service` text,
  `last_service_id` int(11) DEFAULT NULL,
  `next_service_id` int(11) DEFAULT NULL,
  `last_service_date` int(11) DEFAULT NULL,
  `next_service_date` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `building_nr` varchar(255) DEFAULT NULL,
  `contract_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `last_service_id` (`last_service_id`),
  KEY `next_service_id` (`next_service_id`),
  KEY `first_invoice_id` (`first_invoice_id`),
  KEY `last_invoice_id` (`last_invoice_id`),
  CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`first_invoice_id`) REFERENCES `invoices_out` (`id`),
  CONSTRAINT `clients_ibfk_2` FOREIGN KEY (`last_invoice_id`) REFERENCES `invoices_out` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of clients
-- ----------------------------
INSERT INTO `clients` VALUES ('11', 'Viqtor', '', 'Creed', 'PER789456', '', 'VAT789789', null, null, null, '123456', '321654', null, 'test@test.com', 'mail@mail.com', 'Some info', 'Some info', null, null, null, null, null, '1408958172', '1408958172', '1', null, null, null, 'Lithuania', 'Vilnius', 'Kalvariju g', '15 b', null);
INSERT INTO `clients` VALUES ('12', '', 'Senukai', '', 'PER78463', 'COCODE5646', 'VAT64893', null, null, null, '123456', '321654', null, 'em@ail.com', 'test@test.test', 'Some info', 'Some info', null, null, null, null, '1', '1408958292', '1408958292', '1', null, null, null, 'Lithuania', 'Vilnius', 'Kalvariju g', '89 g', null);

-- ----------------------------
-- Table structure for `invoices_in`
-- ----------------------------
DROP TABLE IF EXISTS `invoices_in`;
CREATE TABLE `invoices_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `invoice_code` text,
  `invoice_date` int(11) DEFAULT NULL,
  `warranty_days` int(11) DEFAULT NULL,
  `warranty_start_date` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `signer_name` text,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `payment_method_id` (`payment_method_id`),
  CONSTRAINT `invoices_in_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  CONSTRAINT `invoices_in_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of invoices_in
-- ----------------------------
INSERT INTO `invoices_in` VALUES ('9', '9', 'Test', null, null, null, null, 'Test', '1408958686', '1408958686', null);

-- ----------------------------
-- Table structure for `invoices_out`
-- ----------------------------
DROP TABLE IF EXISTS `invoices_out`;
CREATE TABLE `invoices_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_code` text,
  `invoice_date` int(11) DEFAULT NULL,
  `warranty_days` int(11) DEFAULT NULL,
  `warranty_start_date` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `signer_name` text,
  `client_id` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `payment_method_id` (`payment_method_id`),
  CONSTRAINT `invoices_out_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `invoices_out_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of invoices_out
-- ----------------------------

-- ----------------------------
-- Table structure for `operations_in`
-- ----------------------------
DROP TABLE IF EXISTS `operations_in`;
CREATE TABLE `operations_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_card_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `stock_qnt_after_op` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `product_card_id` (`product_card_id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `operations_in_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices_in` (`id`),
  CONSTRAINT `operations_in_ibfk_2` FOREIGN KEY (`product_card_id`) REFERENCES `product_cards` (`id`),
  CONSTRAINT `operations_in_ibfk_3` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of operations_in
-- ----------------------------
INSERT INTO `operations_in` VALUES ('1', '2', '9', '1', '1408958686', '2500', '1', '14', '9');

-- ----------------------------
-- Table structure for `operations_out`
-- ----------------------------
DROP TABLE IF EXISTS `operations_out`;
CREATE TABLE `operations_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_card_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `stock_id` int(11) DEFAULT NULL,
  `stock_qnt_after_op` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `product_card_id` (`product_card_id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `operations_out_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices_out` (`id`),
  CONSTRAINT `operations_out_ibfk_2` FOREIGN KEY (`product_card_id`) REFERENCES `product_cards` (`id`),
  CONSTRAINT `operations_out_ibfk_3` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of operations_out
-- ----------------------------

-- ----------------------------
-- Table structure for `operations_srv`
-- ----------------------------
DROP TABLE IF EXISTS `operations_srv`;
CREATE TABLE `operations_srv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `service_process_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `under_warranty` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_process_id` (`service_process_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `operations_srv_ibfk_1` FOREIGN KEY (`service_process_id`) REFERENCES `service_processes` (`id`),
  CONSTRAINT `operations_srv_ibfk_2` FOREIGN KEY (`invoice_id`) REFERENCES `invoices_out` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of operations_srv
-- ----------------------------

-- ----------------------------
-- Table structure for `payment_methods`
-- ----------------------------
DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `remark` text,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_methods
-- ----------------------------

-- ----------------------------
-- Table structure for `positions`
-- ----------------------------
DROP TABLE IF EXISTS `positions`;
CREATE TABLE `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `remark` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of positions
-- ----------------------------
INSERT INTO `positions` VALUES ('1', 'Manager', 'test');
INSERT INTO `positions` VALUES ('2', 'Worker', 'test');

-- ----------------------------
-- Table structure for `product_cards`
-- ----------------------------
DROP TABLE IF EXISTS `product_cards`;
CREATE TABLE `product_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `product_name` text,
  `product_code` text,
  `description` text,
  `default_price` int(11) DEFAULT NULL,
  `units` text,
  `additional_params` text,
  `status` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_cards_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_card_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_cards
-- ----------------------------
INSERT INTO `product_cards` VALUES ('2', '4', 'Intel Core i5', 'PR_385FHK', '2.5 Ghz, 4 core, 5MB cache', '30045', 'units', null, '1', '1405427276', '1406645829', '1');
INSERT INTO `product_cards` VALUES ('3', '6', 'Philips 234 E', 'PRODSKK', 'Monitors', null, 'units', null, '1', '1405426995', '1405426995', '1');
INSERT INTO `product_cards` VALUES ('4', '4', 'Intel Core i7', 'CORDSF87', '20 kilograms of precessors', null, 'kg', null, '1', '1405607100', '1406645425', '1');
INSERT INTO `product_cards` VALUES ('5', '4', 'Elbrus S4', 'PRODSKKSDA', 'TEST', null, 'units', null, '1', '1406129083', '1406188426', '1');
INSERT INTO `product_cards` VALUES ('6', '4', 'TESTITEM', 'TESTITEM', 'TESTITEM', null, 'units', null, null, '1406709759', '1406710252', '1');
INSERT INTO `product_cards` VALUES ('7', '4', 'AMD quad core Xtreme', 'P8SDF546D', 'Fast processor', null, 'units', null, null, '1408704741', '1408704741', '1');
INSERT INTO `product_cards` VALUES ('8', '4', 'Elbrus S2', 'PRD789656', '500 Mhz, 4 Cores, WLIW archeticture', null, 'units', null, null, '1408714741', '1408714741', '1');

-- ----------------------------
-- Table structure for `product_card_categories`
-- ----------------------------
DROP TABLE IF EXISTS `product_card_categories`;
CREATE TABLE `product_card_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `remark` text,
  `status` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_card_categories
-- ----------------------------
INSERT INTO `product_card_categories` VALUES ('4', 'Processors', '', '1', '1404392037', '1405345673', '1');
INSERT INTO `product_card_categories` VALUES ('6', 'Monitors', 'just monitors', '1', '1404719915', '1404719915', '1');

-- ----------------------------
-- Table structure for `product_files`
-- ----------------------------
DROP TABLE IF EXISTS `product_files`;
CREATE TABLE `product_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_card_id` int(11) DEFAULT NULL,
  `filename` text,
  `label` text,
  PRIMARY KEY (`id`),
  KEY `product_card_id` (`product_card_id`),
  CONSTRAINT `product_files_ibfk_1` FOREIGN KEY (`product_card_id`) REFERENCES `product_cards` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_files
-- ----------------------------
INSERT INTO `product_files` VALUES ('1', '4', 'REDiHYZH.png', 'main_page.png');
INSERT INTO `product_files` VALUES ('2', '4', 'yiY7D4Nk.png', 'icon.png');
INSERT INTO `product_files` VALUES ('3', '4', '4AdRd4zi.png', 'example.png');
INSERT INTO `product_files` VALUES ('4', '5', 'SS4tRiQZ.png', 'main_page.png');
INSERT INTO `product_files` VALUES ('6', '2', 'tefE49ED.jpg', 'dmitrij_chitrov.jpg');
INSERT INTO `product_files` VALUES ('7', '2', '9z9GR4yd.jpg', 'dmitrij_chitrov.jpg');

-- ----------------------------
-- Table structure for `product_in_stock`
-- ----------------------------
DROP TABLE IF EXISTS `product_in_stock`;
CREATE TABLE `product_in_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_id` int(11) DEFAULT NULL,
  `product_card_id` int(11) DEFAULT NULL,
  `qnt` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_card_id` (`product_card_id`),
  KEY `stock_id` (`stock_id`),
  CONSTRAINT `product_in_stock_ibfk_1` FOREIGN KEY (`product_card_id`) REFERENCES `product_cards` (`id`),
  CONSTRAINT `product_in_stock_ibfk_2` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_in_stock
-- ----------------------------
INSERT INTO `product_in_stock` VALUES ('1', '1', '2', '14', '1408958686', '1405692681');
INSERT INTO `product_in_stock` VALUES ('2', '1', '3', '25', '1408954725', '1405692681');
INSERT INTO `product_in_stock` VALUES ('3', '1', '4', '30', '1408954725', '1405692681');
INSERT INTO `product_in_stock` VALUES ('4', '1', '6', '24', '1408954725', '1408714101');
INSERT INTO `product_in_stock` VALUES ('5', '1', '5', '10', '1408714786', '1408714786');
INSERT INTO `product_in_stock` VALUES ('6', '1', '8', '6', '1408714786', '1408714786');

-- ----------------------------
-- Table structure for `rights`
-- ----------------------------
DROP TABLE IF EXISTS `rights`;
CREATE TABLE `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `label` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rights
-- ----------------------------
INSERT INTO `rights` VALUES ('1', 'can see products', 'products_see');
INSERT INTO `rights` VALUES ('2', 'can see product categories', 'categories_see');
INSERT INTO `rights` VALUES ('3', 'can edit prodcut categories', 'categories_edit');
INSERT INTO `rights` VALUES ('4', 'can delete product categories', 'categories_delete');
INSERT INTO `rights` VALUES ('5', 'can edit products', 'products_edit');
INSERT INTO `rights` VALUES ('6', 'can delete products', 'products_delete');
INSERT INTO `rights` VALUES ('7', 'can create categories', 'categories_add');
INSERT INTO `rights` VALUES ('8', 'can create products', 'products_add');
INSERT INTO `rights` VALUES ('9', 'access to products section', 'products_section_see');
INSERT INTO `rights` VALUES ('10', 'can see contractors', 'contractors_section_see');
INSERT INTO `rights` VALUES ('11', 'can see employees', 'employees_section_see');
INSERT INTO `rights` VALUES ('13', 'can see clients', 'clients_see');
INSERT INTO `rights` VALUES ('14', 'can edit clients', 'clients_edit');
INSERT INTO `rights` VALUES ('15', 'can delete clients', 'clients_delete');
INSERT INTO `rights` VALUES ('16', 'can add clients', 'clients_add');
INSERT INTO `rights` VALUES ('17', 'can see suppliers', 'suppliers_see');
INSERT INTO `rights` VALUES ('18', 'can edit suppliers', 'suppliers_edit');
INSERT INTO `rights` VALUES ('19', 'can add suppliers', 'suppliers_add');
INSERT INTO `rights` VALUES ('20', 'can delete suppliers', 'suppliers_delete');
INSERT INTO `rights` VALUES ('21', 'can see users', 'users_see');
INSERT INTO `rights` VALUES ('22', 'can add users', 'users_add');
INSERT INTO `rights` VALUES ('23', 'can suspend users', 'users_suspend');
INSERT INTO `rights` VALUES ('24', 'can change users', 'users_edit');
INSERT INTO `rights` VALUES ('25', 'can delete users', 'users_delete');
INSERT INTO `rights` VALUES ('26', 'can sell products', 'sales_add');
INSERT INTO `rights` VALUES ('27', 'can see all outgoing invoices', 'sales_see');
INSERT INTO `rights` VALUES ('28', 'call see all incoming invoices', 'purchases_see');
INSERT INTO `rights` VALUES ('29', 'can buy products', 'purchases_add');
INSERT INTO `rights` VALUES ('30', 'can see services', 'services_see');
INSERT INTO `rights` VALUES ('31', 'can edit serives', 'services_edit');
INSERT INTO `rights` VALUES ('32', 'can add services', 'services_add');
INSERT INTO `rights` VALUES ('33', 'can delete services', 'services_delete');

-- ----------------------------
-- Table structure for `service_problem_types`
-- ----------------------------
DROP TABLE IF EXISTS `service_problem_types`;
CREATE TABLE `service_problem_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` text,
  `description` text,
  `problem_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_problem_types
-- ----------------------------
INSERT INTO `service_problem_types` VALUES ('1', 'Голова застряла в мясорубке', 'Серьезная проблема', 'GOLMIAS846');
INSERT INTO `service_problem_types` VALUES ('2', 'Фильтр избивает человека', 'Страшно и опасно', 'FILTIZB4874D');

-- ----------------------------
-- Table structure for `service_processes`
-- ----------------------------
DROP TABLE IF EXISTS `service_processes`;
CREATE TABLE `service_processes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` text,
  `remark` text,
  `start_date` int(11) DEFAULT NULL,
  `close_date` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `operation_id` int(11) DEFAULT NULL,
  `problem_type_id` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_created_by` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  `priority` text,
  `current_employee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `problem_type_id` (`problem_type_id`),
  KEY `service_processes_ibfk_2` (`operation_id`),
  KEY `user_modified_by` (`user_modified_by`),
  KEY `current_employee_id` (`current_employee_id`),
  KEY `user_created_by` (`user_created_by`),
  KEY `status_id` (`status_id`),
  CONSTRAINT `service_processes_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `service_processes_ibfk_2` FOREIGN KEY (`operation_id`) REFERENCES `operations_out` (`id`),
  CONSTRAINT `service_processes_ibfk_3` FOREIGN KEY (`problem_type_id`) REFERENCES `service_problem_types` (`id`),
  CONSTRAINT `service_processes_ibfk_5` FOREIGN KEY (`user_modified_by`) REFERENCES `users` (`id`),
  CONSTRAINT `service_processes_ibfk_6` FOREIGN KEY (`current_employee_id`) REFERENCES `users` (`id`),
  CONSTRAINT `service_processes_ibfk_7` FOREIGN KEY (`user_created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `service_processes_ibfk_8` FOREIGN KEY (`status_id`) REFERENCES `service_process_statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_processes
-- ----------------------------

-- ----------------------------
-- Table structure for `service_process_statuses`
-- ----------------------------
DROP TABLE IF EXISTS `service_process_statuses`;
CREATE TABLE `service_process_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` text,
  `system_id` text,
  `system` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_process_statuses
-- ----------------------------
INSERT INTO `service_process_statuses` VALUES ('1', 'opened', 'SYS_OPENED', '1', '1');
INSERT INTO `service_process_statuses` VALUES ('2', 'in progress', 'SYS_PROGRESS', '1', '2');
INSERT INTO `service_process_statuses` VALUES ('3', 'closed', 'SYS_CLOSED', '1', '3');

-- ----------------------------
-- Table structure for `service_resolutions`
-- ----------------------------
DROP TABLE IF EXISTS `service_resolutions`;
CREATE TABLE `service_resolutions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_process_id` int(11) DEFAULT NULL,
  `by_employee_id` int(11) DEFAULT NULL,
  `remark_for_employee` text,
  `remark_by_employee` text,
  `process_current_status` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_process_id` (`service_process_id`),
  KEY `by_employee_id` (`by_employee_id`),
  CONSTRAINT `service_resolutions_ibfk_1` FOREIGN KEY (`service_process_id`) REFERENCES `service_processes` (`id`),
  CONSTRAINT `service_resolutions_ibfk_2` FOREIGN KEY (`by_employee_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of service_resolutions
-- ----------------------------

-- ----------------------------
-- Table structure for `stocks`
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `location` text,
  `description` text,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stocks
-- ----------------------------
INSERT INTO `stocks` VALUES ('1', 'Vilnius', 'Vilnius', 'Stock in vilnius', '0', '0', '1');

-- ----------------------------
-- Table structure for `suppliers`
-- ----------------------------
DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` text,
  `company_code` text,
  `vat_code` text,
  `phones` text,
  `phone1` text,
  `phone2` text,
  `emails` text,
  `email1` text,
  `email2` text,
  `remark` text,
  `date_created` int(11) DEFAULT NULL,
  `date_changed` int(11) DEFAULT NULL,
  `user_modified_by` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `building_nr` varchar(255) DEFAULT NULL,
  `contract_number` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of suppliers
-- ----------------------------
INSERT INTO `suppliers` VALUES ('8', 'AMD', 'COCODE8797', 'VAT568854', null, '123456', '632145', null, 'email@mail.com', 'test@test.com', 'Some info', '1408958395', '1408958395', '1', null, null, 'USA', 'New York', 'Some Street', '56', null);
INSERT INTO `suppliers` VALUES ('9', 'Intel', 'COCODE8757', 'VAT568354', null, '123456', '321654', null, 'email@mail.com', 'test@test.com', 'Some info', '1408958465', '1408958465', '1', null, null, 'USA', 'Washington', 'Some street', '89', null);
INSERT INTO `suppliers` VALUES ('10', 'nVidia', 'COCODE8357', 'VAT568324', null, '1123456', '321654', null, 'email@mail.com', 'test@test.com', 'Some info', '1408958540', '1408958540', '1', null, null, 'China', 'Pekin', 'Some street', '56', null);

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
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`city_id`) REFERENCES `user_cities` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'darkoffalex@yandex.ru', 'Valery', 'Gatalsky', '123456', 'test', 'test', null, '1', '1', '1405511917', '1406644184', '1', '4eyKD9En.jpg', '1', '1');
INSERT INTO `users` VALUES ('3', 'test', '81dc9bdb52d04dc20036dbd8313ed055', 'email@test.com', 'Vasia', 'Pupkin', '5468514', 'Test', 'Remark', null, '0', '1', '1405511917', '1406644178', '1', 'HBTbtBrY.jpg', '2', '2');
INSERT INTO `users` VALUES ('4', 'rest', '81dc9bdb52d04dc20036dbd8313ed055', 'darkoffalegz@yandex.ru', 'Pinislav', 'Kuriskin', '5489465', '', '', null, '0', '1', '1405511917', '1406644172', '1', 'HBTbtBrY.jpg', '2', '3');
INSERT INTO `users` VALUES ('5', 'vovan', '81dc9bdb52d04dc20036dbd8313ed055', 'vovan@vovnet.com', 'Vovan', 'Limonov', '54646', 'test', 'test', null, '0', null, '1406117121', '1406644633', '1', 'av_53d7b199d9ac7.jpg', '2', '1');

-- ----------------------------
-- Table structure for `user_cities`
-- ----------------------------
DROP TABLE IF EXISTS `user_cities`;
CREATE TABLE `user_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` text,
  `country` text,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_cities
-- ----------------------------
INSERT INTO `user_cities` VALUES ('1', 'Vilnius', 'Lithuania', null);
INSERT INTO `user_cities` VALUES ('2', 'Kaunas', 'Lithuania', null);
INSERT INTO `user_cities` VALUES ('3', 'Panevezys', 'Lithuania', null);

-- ----------------------------
-- Table structure for `user_rights`
-- ----------------------------
DROP TABLE IF EXISTS `user_rights`;
CREATE TABLE `user_rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `rights_id` int(11) DEFAULT NULL,
  `right_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rights_id` (`rights_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_rights_ibfk_1` FOREIGN KEY (`rights_id`) REFERENCES `rights` (`id`),
  CONSTRAINT `user_rights_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=377 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_rights
-- ----------------------------
INSERT INTO `user_rights` VALUES ('327', '3', '1', '1');
INSERT INTO `user_rights` VALUES ('328', '3', '7', '1');
INSERT INTO `user_rights` VALUES ('329', '3', '2', '1');
INSERT INTO `user_rights` VALUES ('330', '3', '13', '1');
INSERT INTO `user_rights` VALUES ('331', '3', '17', '1');
INSERT INTO `user_rights` VALUES ('332', '3', '28', '1');
INSERT INTO `user_rights` VALUES ('333', '3', '27', '1');
INSERT INTO `user_rights` VALUES ('334', '1', '6', '1');
INSERT INTO `user_rights` VALUES ('335', '1', '5', '1');
INSERT INTO `user_rights` VALUES ('336', '1', '8', '1');
INSERT INTO `user_rights` VALUES ('337', '1', '1', '1');
INSERT INTO `user_rights` VALUES ('338', '1', '4', '1');
INSERT INTO `user_rights` VALUES ('339', '1', '3', '1');
INSERT INTO `user_rights` VALUES ('340', '1', '7', '1');
INSERT INTO `user_rights` VALUES ('341', '1', '2', '1');
INSERT INTO `user_rights` VALUES ('342', '1', '15', '1');
INSERT INTO `user_rights` VALUES ('343', '1', '14', '1');
INSERT INTO `user_rights` VALUES ('344', '1', '16', '1');
INSERT INTO `user_rights` VALUES ('345', '1', '13', '1');
INSERT INTO `user_rights` VALUES ('346', '1', '20', '1');
INSERT INTO `user_rights` VALUES ('347', '1', '18', '1');
INSERT INTO `user_rights` VALUES ('348', '1', '19', '1');
INSERT INTO `user_rights` VALUES ('349', '1', '17', '1');
INSERT INTO `user_rights` VALUES ('350', '1', '29', '1');
INSERT INTO `user_rights` VALUES ('351', '1', '28', '1');
INSERT INTO `user_rights` VALUES ('352', '1', '26', '1');
INSERT INTO `user_rights` VALUES ('353', '1', '27', '1');
INSERT INTO `user_rights` VALUES ('354', '1', '33', '1');
INSERT INTO `user_rights` VALUES ('355', '1', '31', '1');
INSERT INTO `user_rights` VALUES ('356', '1', '32', '1');
INSERT INTO `user_rights` VALUES ('357', '1', '30', '1');
INSERT INTO `user_rights` VALUES ('358', '1', '25', '1');
INSERT INTO `user_rights` VALUES ('359', '1', '24', '1');
INSERT INTO `user_rights` VALUES ('360', '1', '22', '1');
INSERT INTO `user_rights` VALUES ('361', '1', '21', '1');
INSERT INTO `user_rights` VALUES ('362', '5', '1', '1');
INSERT INTO `user_rights` VALUES ('363', '5', '2', '1');
INSERT INTO `user_rights` VALUES ('364', '5', '13', '1');
INSERT INTO `user_rights` VALUES ('365', '5', '17', '1');
INSERT INTO `user_rights` VALUES ('366', '5', '28', '1');
INSERT INTO `user_rights` VALUES ('367', '5', '27', '1');
INSERT INTO `user_rights` VALUES ('368', '5', '21', '1');
