CREATE TABLE `job` (
  `job_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(20)
);

CREATE TABLE `employee` (
  `employee_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100),
  `email` VARCHAR(100),
  `phone` VARCHAR(15),
  `job_id` INT REFERENCES job(`job_id`) ON DELETE CASCADE,
  `salary` NUMERIC(10, 2)
);

CREATE TABLE `currency` (
  `currency_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(50),
  `code` VARCHAR(10)
);

CREATE TABLE `rate` (
  `rate_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `currency_id` INT REFERENCES currency(`currency_id`) ON DELETE CASCADE,
  `rate_date` TIMESTAMP,
  `exchange_rate` NUMERIC(10, 4)
);

CREATE TABLE `operation` (
  `operation_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `employee_id` INT REFERENCES `employee`(`employee_id`) ON DELETE CASCADE,
  `currency_id` INT REFERENCES `currency`(`currency_id`) ON DELETE CASCADE,
  `amount` NUMERIC(10, 2),
  `exchanged_amount` NUMERIC(10, 2),
  `operation_date` TIMESTAMP
);

INSERT INTO `job` (`name`) values ('Менеджер'),('Кассир'),('Охранник'),('Финансовый аналитик');

INSERT INTO `employee` (`name`, `email`, `phone`, `job_id`, `salary`)
VALUES ('Человек Фамилия','test@mail.ru', '89998887563', 1, 5000),
       ('Другой Человек','test@mail.ru', '89998887563', 2, 3000),
       ('Не Человек','test@mail.ru', '89998887563', 3, 4500);

INSERT INTO `currency` (`name`, `code`)
VALUES ('Dollar USA', 'USD'),
       ('EURO', 'EUR');

INSERT INTO `rate` (`currency_id`, `rate_date`, `exchange_rate`)
VALUES (1, current_timestamp, 1.2),
       (2, current_timestamp, 0.9),
       (2, current_timestamp, 1.5);

INSERT INTO `operation` (`employee_id`, `currency_id`,  `amount`, `exchanged_amount`, `operation_date`)
VALUES (2, 1, 1000, 900, current_timestamp),
       (2, 2, 500, 750, current_timestamp),
       (2, 2, 2000, 3000, current_timestamp);