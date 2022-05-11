-- Author: Luis Egui

-- Insert example model row:
insert into Model(brand, model, submodel, gearbox, category, fuelType, seatCount)
values ('Audi', 'S8', '5.2 V10 FSI', 'automatic', 'sedan', 'diesel', 3);

-- View inserted data:
select *
from Model;

-- Insert example Vehicle row:
insert into Vehicle(vin, licensePlate, model, location)
values (123456, '1234-BC', 1, 'europa');

-- View inserted data:
select *
from Vehicle;

-- Insert example Damage row:
insert into Damage(vehicle, user, title, description, evidenceDamage, area, type, isRepaired)
values (123456, 1, 'Audi S8 rozado', 'Hay una raya en la parte lateral', null, 'general', 'minor', false);

-- View inserted data:
select *
from Damage;

-- Insert example User row:
-- Password encrypted with BCrypt.
-- Password: 1234
insert into User(email, password, role)
values (
    'luis@easyrent.com',
    '$2a$12$JZERzQcCfpMaNOXVYtqy2.yTvyvIRlwd/TnygtYHaj20gBDaLW8OK',
    'admin'
  );

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
