CREATE TABLE application (
  application_id SERIAL PRIMARY KEY,
  login VARCHAR(50) NOT NULL,
  password VARCHAR(60) NOT NULL,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  yob INT NOT NULL,
  sex INT NOT NULL,
  num_of_limbs INT NOT NULL,
  biography VARCHAR(300) NULL DEFAULT NULL
);

CREATE TABLE superpower (
  sup_id SERIAL PRIMARY KEY,
  name VARCHAR(30) NOT NULL
);

CREATE TABLE application_superpower (
  id SERIAL PRIMARY KEY,
  application_id INT NOT NULL REFERENCES application (application_id) ON DELETE CASCADE,
  sup_id INT NOT NULL REFERENCES superpower (sup_id) ON DELETE CASCADE
);

INSERT INTO superpower values(1,'бессмертие');
INSERT INTO superpower values(2,'прохождение сквозь стены');
INSERT INTO superpower values(3,'левитация');

// для вывода
select application.name, email, string_agg(superpower.name, ', ') as superpowers from application  join application_superpower on application.application_id =application_superpower.application_id join superpower on application_superpower.sup_id = superpower.sup_id group by application.name, email;