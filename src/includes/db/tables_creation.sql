-- Author: Luis Egui

-- Image table creation
create table
  Image (
    img_id serial primary key,
    path varchar(256) not null,
    mimeType enum('image/jpeg','image/jpg','image/png') not null
  );

-- Aux: check Image fields
-- describe Image;

-- Model table creation
create table
  Model (
    m_id serial primary key,
    brand varchar(40),
    model varchar(40),
    submodel varchar(40) unique not null,
    gearbox enum('Manual', 'Automatic', 'Semi-automatic', 'Duplex'),
    category enum('Coupe', 'Pickup', 'Roadster', 'Sedan', 'Small-car', 'Suv', 'Van'),
    fuelType enum ('Diesel', 'Electric-hybrid', 'Electric', 'Petrol', 'Plug-in-hybrid') not null,
    seatCount tinyint not null,
    vehicleImg bigint unsigned,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
    foreign key (vehicleImg) references Image(img_id),
    check (seatCount regexp '^[2-9]{1}$')
  );

-- Aux: check Model fields
-- describe Model;

-- Vehicle table creation
create table
  Vehicle (
    vin bigint primary key,
    licensePlate varchar(10) not null,
    model bigint unsigned,
    location varchar(40),
    state enum ('Available', 'Unavailable', 'Reserved') default 'Available',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
    foreign key (model) references Model(m_id) ON DELETE RESTRICT,
    check (vin regexp '^[0-9]{6}$'),
    check (licensePlate regexp '^[0-9]{4}-(?!.*(LL|CH))[BCDFGHJKLMNPRSTVWXYZ]{1,3}$')

  );

-- Aux: check Vehicle fields
-- describe Vehicle;

-- User table creation
create table
  User (
    u_id serial primary key,
    email varchar(30) unique not null,
    password varchar(70) not null,
    role enum ('admin', 'particular', 'enterprise', 'sponsor'),
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
    state enum ('reserved', 'pending') default 'pending',
    pickupLocation varchar(40) not null,
    returnLocation varchar(40),
    pickupTime datetime not null,
    returnTime datetime not null,
    price float,
    foreign key (vehicle) references Vehicle(vin) ON DELETE RESTRICT,
    foreign key (user) references User(u_id) ON DELETE RESTRICT,
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

-- Damage table creation
create table
  Damage (
    d_id serial primary key,
    vehicle bigint not null,
    user bigint unsigned not null,
    title varchar(30) not null,
    description varchar(70) not null,
    evidenceDamage bigint unsigned,
    area enum ('Brakes', 'Controls', 'Engine', 'Front', 'General', 'Interior', 'Left', 'Right', 'Rear', 'Roof', 'Trunk', 'Underbody', 'Wheels') not null,
    type enum ('Minor', 'Moderate', 'Severe'),
    isRepaired boolean default false,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP,
    foreign key (vehicle) references Vehicle(vin) ON DELETE RESTRICT,
    foreign key (evidenceDamage) references Image(img_id),
    foreign key (user) references User(u_id)
  );

-- Aux: check Damage fields:
-- describe Damage;
-- Priority table creation
create table
  Priority (
    p_id serial primary key,
    level enum('1', '2') not null,
    price decimal(5,2) not null
);

-- Advertisement table creation
create table
  Advertisement (
      a_id serial primary key,
      banner bigint unsigned,
      releaseDate datetime not null,
      endDate datetime not null,
      priority bigint unsigned not null,
      foreign key (banner) references Image(img_id),
      foreign key (priority) references Priority(p_id)
);
