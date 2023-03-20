CREATE TABLE `application` (
  `application_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `yob` INT NOT NULL,
  `sex` INT NOT NULL,
  `num_of_limbs` INT NOT NULL,
  `biography` VARCHAR(300) NULL DEFAULT NULL,
  PRIMARY KEY (`application_id`)
);

CREATE TABLE `superpower` (
  `sup_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`sup_id`)
);

CREATE TABLE `application_superpower` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `application_id` INT NOT NULL,
  `sup_id` INT NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `application_superpower` ADD FOREIGN KEY (application_id) REFERENCES `application` (`application_id`);
ALTER TABLE `application_superpower` ADD FOREIGN KEY (sup_id) REFERENCES `superpower` (`sup_id`);



// для вывода
select application.name, email,group_concat(superpower.name separator ', ') as superpowers from application  join application_superpower on application.application_id =application_superpower.application_id join superpower on application_superpower.sup_id = superpower.sup_id group by application.name, email;