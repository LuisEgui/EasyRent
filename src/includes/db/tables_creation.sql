-- Author: Luis Egui

-- Model table creation
create table
  Model (
    m_id serial primary key,
    make varchar(40),
    model varchar(40),
    submodel varchar(40),
    gearbox enum('manual', 'automatic', 'semi-automatic', 'duplex'),
    category enum('coupe', 'pickup', 'roadster', 'sedan', 'small-car', 'suv', 'van')
  );

-- Aux: check Model fields
-- describe Model;

-- Image table creation
create table
  Image (
    img_id serial primary key,
    path varchar(256) not null,
    mimeType enum('image/jpeg','image/jpg','image/png') not null
  );

-- Aux: check Image fields
-- describe Image;

-- Vehicle table creation
create table
  Vehicle (
    vin bigint primary key,
    licensePlate varchar(10) not null,
    model bigint unsigned,
    vehicleImg bigint unsigned,
    fuelType enum ('diesel', 'electric-hybrid', 'electric', 'petrol', 'plug-in-hybrid') not null,
    seatCount tinyint not null,
    state enum ('available', 'unavailable', 'reserved') default 'available',
    foreign key (model) references Model(m_id),
    foreign key (vehicleImg) references Image(img_id),
    check (vin regexp '^[0-9]{6}$'), 
    check (seatCount regexp '^[2-9]{1}$'),
    check (licensePlate regexp '^[0-9]{4}-(?!.*(LL|CH))[BCDFGHJKLMNPRSTVWXYZ]{1,3}$')
  );

-- Aux: check Vehicle fields
-- describe Vehicle;

-- Damage table creation
create table
  Damage (
    d_id serial primary key,
    vehicle bigint not null,
    area enum (
      'brakes',
      'controls',
      'engine',
      'front',
      'general',
      'interior',
      'left',
      'right',
      'rear',
      'roof',
      'trunk',
      'underbody',
      'wheels'
    ) not null,
    type enum ('minor', 'moderate', 'severe'),
    isRepaired boolean default false,
    foreign key (vehicle) references Vehicle(vin)
  );

-- Aux: check Damage fields:
-- describe Damage;

-- EvidenceDamage table creation
create table
  EvidenceDamage (
    damage bigint not null, 
    image bigint not null, 
    primary key (damage, image),
    foreign key (damage) references Damage(d_id),
    foreign key (image) references Image(img_id)
  );

-- Aux: check EvidenceDamage fields:
-- describe EvidenceDamage;

-- User table creation
create table
  User (
    u_id serial primary key,
    email varchar(30) unique not null,
    password varchar(70) not null,
    role enum ('admin', 'particular', 'enterprise'),
    userImg bigint unsigned,
    foreign key (userImg) references Image(img_id),
    check (
      email regexp '^[a-zA-Z0-9.!#$%&*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$'
    )
  );

-- Aux: check EvidenceDamage fields:
-- describe User;

-- Reserve table creation
create table
  Reserve (
    id serial primary key,
    vehicle bigint not null,
    user bigint unsigned not null,
    state enum ('reserved', 'pending', 'cancelled') default 'pending',
    pickupLocation varchar(40) not null,
    returnLocation varchar(40),
    pickupTime datetime not null,
    returnTime datetime not null,
    price float,
    foreign key (vehicle) references Vehicle(vin),
    foreign key (user) references User(u_id),
    unique (vehicle, user, pickupTime),
    check (timediff(returnTime, pickupTime) > 0)
  );

-- Message table creation
create table 
  Message (
    id serial primary key,
    author bigint unsigned not null,
    txt varchar(140) not null,
    sendTime datetime not null,
    idParentMessage bigint unsigned default null,
    foreign key (idParentMessage) references Message(id),
    foreign key (author) references User(u_id)
);

-- Aux: check Message fields:
-- describe Message;
