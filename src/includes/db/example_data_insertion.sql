-- Author: Luis Egui

-- Insert example model row:
insert into Model(brand, model, submodel, gearbox, category, fuelType, seatCount)
values ('Audi', 'S8', '5.2 V10 FSI', 'automatic', 'sedan', 'petrol', '5'),
       ('Citroen', 'AX', 'AX', 'Manual', 'Small-car', 'Diesel', '5'),
       ('Seat', 'Toledo', '1.9 TDI', 'Manual', 'Sedan', 'Diesel', '5'),
       ('Hyundai', 'Trajet', 'Trajet', 'Manual', 'Van', 'Diesel', '7'),
       ('Renault', 'Captur', 'TCe 67 kW (90CV)', 'Manual', 'Suv', 'Diesel', '5'),
       ('Mini', 'One', 'One D 66 kW (90 CV)', 'Manual', 'Small-car', 'Petrol', '4');

-- View inserted data:
select *
from Model;

-- Insert example Vehicle row:
insert into Vehicle(vin, licensePlate, model, location)
values (123456, '1234-BCB', 1, 'Madrid'),
       (123485, '2235-BCB', 3, 'Barcelona'),
       (752455, '7723-JHB', 6, 'Barcelona'),
       (127595, '7235-BCL', 4, 'Barcelona'),
       (197765, '2245-CPF', 5, 'Barcelona'),
       (153755, '2235-WF', 2, 'Barcelona');

-- View inserted data:
select *
from Vehicle;

-- Insert example User row:
-- Password encrypted with BCrypt.
-- Password: 1234
insert into User(email, password, role)
values (
    'luis@easyrent.com',
    '$2a$12$JZERzQcCfpMaNOXVYtqy2.yTvyvIRlwd/TnygtYHaj20gBDaLW8OK',
    'admin'
    ),
    ('elonmusk@easyrent.com',
     '$2y$12$FQ5EeKxNqSfvpgzakpePu..xmQt/GfZ69oDksheoLxkydhZBbRDM2',
     'enterprise'),
    ('peterparker@easyrent.com',
     '$2y$12$E8une4dNkj40R4vCun1DhON9SlCpn088XrQ8A5brzPIFrErZkUlwy',
     'particular');

-- View inserted data:
select *
from user;

-- Insert example Reseve row:
insert into Reserve(vehicle, user, pickupLocation, pickupTime, returnTime)
values (123456, 1, 'Madrid', '2022-03-07 15:00:00', '2022-03-07 20:00:00');

-- View inserted data:
select *
from Reserve;

-- Insert example Message row:
set @INIT := NOW();
insert into Message(id, author, txt, sendTime, idParentMessage) values
(1, 1, 'Bienvenido al foro', @INIT, NULL),
(2, 1, 'Muchas gracias', ADDTIME(@INIT, '0:15:0'), 1),
(3, 1, 'Otro mensaje', ADDTIME(@INIT, '25:15:0'), NULL);

-- Insert example Damage row:
insert into Damage(vehicle, user, title, description, evidenceDamage, area, type, isRepaired)
values (123456, 1, 'Audi S8 rozado', 'Hay una raya en la parte lateral', null, 'general', 'minor', false);

-- View inserted data:
select *
from Damage;

-- Insert example Priority row:
insert into Priority(level, price)
values
    (1, 150.00),
    (2, 250.00);

-- View inserted data;
select *
from Priority;

-- Insert example Advertisement row:
insert into Advertisement (banner, releaseDate, endDate, priority)
values
    (NULL, '2022-04-12 10:00:00', '2022-04-20 23:55:00', 1),
    (NULL, '2022-05-12 02:10:00', '2022-05-12 02:10:00', 1);
