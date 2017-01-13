CREATE TABLE `sprint`
(
  `sprint_id` INT(11) NOT NULL AUTO_INCREMENT,
  `nb_days` INT(11) NOT NULL DEFAULT 0,
  `name` VARCHAR(64) NOT NULL,
  `created_at` DATETIME,
  `updated_at` DATETIME,
  PRIMARY KEY (`sprint_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `sprint_member`
(
  `sprint_member_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sprint_id` INT(11) NOT NULL,
  `nb_days_presence` INT(11),
  `availability` INT(11),
  PRIMARY KEY (`sprint_member_id`),
  KEY `sprint_id` (`sprint_id`),
  CONSTRAINT `sprint_id_fk` FOREIGN KEY (`sprint_id`) REFERENCES `sprint` (`sprint_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
