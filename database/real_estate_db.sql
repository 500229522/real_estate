

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `address_line1` varchar(45) DEFAULT NULL,
  `address_line2` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `agency_name` varchar(45) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_id` (`user_id`),
  CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;


CREATE TABLE `property_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

INSERT INTO `property_types`(`id`,`type`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (1,'Town House','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `property_types`(`id`,`type`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (2,'Condo','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `property_types`(`id`,`type`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (3,'Commercial','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `property_types`(`id`,`type`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (4,'Individual Villa','','2023-11-20 00:00:00',NULL,NULL);


CREATE TABLE `amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amenity` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `deleted_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (1,'Swimming Pool','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (2,'Free Wi-fi','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (3,'Balcony','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (4,'Garden','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (5,'Furnished','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (6,'Parking','','2023-11-20 00:00:00',NULL,NULL);

INSERT INTO `amenities`(`id`,`amenity`,`description`,`created_date`,`updated_date`,`deleted_date`) VALUES (7,'Gym','','2023-11-20 00:00:00',NULL,NULL);
