#data for initial feed the application

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE employees;
TRUNCATE TABLE departments;
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO departments(id, name, bonus_type, bonus_value)
VALUES (1, 'HR', 'fixed', 10000),
       (2, 'Customer Service', 'percentage', 10),
       (3, 'Engineering', 'fixed', 20000)
;

insert into employees(id, department_id, first_name, last_name, base_salary, hired_at)
VALUES (1, 1, 'Adam', 'Kowalski', 100000, '2006-06-25'),
       (2, 1, 'Daria', 'Nowacka', 120000, '2017-12-24'),
       (3, 1, 'Jerzy', 'Nowicki', 150000, '2014-11-23'),
       (4, 1, 'Nina', 'Owczarek', 90000, '2008-10-22'),
       (5, 1, 'Kamila', 'Bednarczyk', 130000, '2016-09-21'),
       (6, 2, 'Ania', 'Nowak', 110000, '2016-06-20'),
       (7, 2, 'Weronika', 'Szymańska', 120000, '2016-11-19'),
       (8, 2, 'Wiktor', 'Przybylski', 70000, '2020-12-10'),
       (9, 2, 'Wiktoria', 'Mucha', 100000, '2021-01-11'),
       (10, 3, 'Patryk', 'Kaźmierczak', 117000, '2016-02-12'),
       (11, 3, 'Kamil', 'Chmielewski', 169000, '2014-01-02'),
       (12, 3, 'Jerzy', 'Baranowski', 555, '1994-08-13'),
       (13, 3, 'Mateusz', 'Malinowski', 100000, '2020-09-07'),
       (14, 3, 'Zofia', 'Walczak', 300000, '2018-05-21'),
       (15, 3, 'Andżelika', 'Kamińska', 110000, '2015-11-01'),
       (16, 3, 'Mateusz', 'Mucha', 120000, '2013-07-04'),
       (17, 3, 'Zofia', 'Nowicka', 90000, '2019-02-03'),
       (18, 3, 'Natalia', 'Matusiak', 100000, '2020-03-01'),
       (19, 3, 'Jan', 'Rutkowski', 133000, '2021-05-21'),
       (20, 3, 'Oliwia', 'Dobrowolska', 143000, '2019-07-31')
;