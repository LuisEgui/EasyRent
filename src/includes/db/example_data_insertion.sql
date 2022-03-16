-- Author: Luis Egui

-- Insert example model row:
insert into Model(make, model, submodel, gearbox, category)
values ('Audi', 'S8', '5.2 V10 FSI', 'automatic', 'sedan');

-- View inserted data:
select *
from Model;

-- Insert example image row:
-- We check the file directory to upload the images in our system
select @@secure_file_priv;

-- In Windows:
insert into Image(absoluteUrl, height, width, mimeType, imgBlob)
values (
    'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/6.jpg',
    960,
    640,
    'jpg',
    load_file('C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/6.jpg')
  );

-- In Linux:
insert into Image(absoluteUrl, height, width, mimeType, imgBlob)
values (
    'var/lib/mysql-files/6.jpg',
    960,
    640,
    'jpg',
    load_file('var/lib/mysql-files/6.jpg')
  ); 

-- View inserted data:
select
  img_id,
  absoluteUrl,
  height,
  width,
  mimeType
from Image;

-- Insert example Vehicle row:
insert into Vehicle(vin, licensePlate, model, fuelType, seatCount, vehicleImg)
values (123456, 'X-XX-1234', 1, 'petrol', '5', 1);

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
insert into user(email, password, role, userImg)
values (
    'luis@easyrent.com',
    '$2y$10$cpQ2kCIToPB3GXxNvGq/Fuq/H2PFuK3/
    UQDPrHgp9ZNyFcNWbQcq2',
    'admin',
    1
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
