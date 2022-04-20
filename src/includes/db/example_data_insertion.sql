-- Author: Luis Egui

-- Insert example model row:
insert into Model(make, model, submodel, gearbox, category)
values ('Audi', 'S8', '5.2 V10 FSI', 'automatic', 'sedan');

-- View inserted data:
select *
from Model;

-- Insert example Vehicle row:
insert into Vehicle(vin, licensePlate, model, fuelType, seatCount)
values (123456, 'X-XX-1234', 1, 'petrol', '5');

-- View inserted data:
select *
from Vehicle;

-- Insert example Damage row:
insert into Damage(vehicle, area, type, isRepaired)
values (123456, 'general', 'minor', true);

-- View inserted data:
select *
from Damage;

-- Insert example EvidenceDamage row:
insert into EvidenceDamage(damage, image)
values (1, 1);

-- View inserted data:
select *
from EvidenceDamage;

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
insert into Message(id, author, message, sendTime, idParentMessage) values
(1, 1, 'Bienvenido al foro', @INIT, NULL),
(2, 2, 'Muchas gracias', ADDTIME(@INIT, '0:15:0'), 1),
(3, 2, 'Otro mensaje', ADDTIME(@INIT, '25:15:0'), NULL); 