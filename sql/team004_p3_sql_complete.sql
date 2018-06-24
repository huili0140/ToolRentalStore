-- CREATE USR 'newuser'@'localhost' IDENTIFIED BY 'password';
CREATE USER IF NOT EXISTS tool4rentUser@localhost IDENTIFIED BY '12345';

DROP DATABASE IF EXISTS cs6400_fa17_team004;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cs6400_fa17_team004
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE cs6400_fa17_team004;

GRANT SELECT, INSERT, UPDATE, DELETE, FILE ON *.* TO 'tool4rentUser'@'localhost';
GRANT ALL PRIVILEGES ON `tool4rentUser`.* TO 'tool4rentUser'@'localhost';
GRANT ALL PRIVILEGES ON `cs6400_fa17_team004`.* TO 'tool4rentUser'@'localhost';
FLUSH PRIVILEGES;

-- Table

CREATE TABLE Clerk (
  clerkID int(16) unsigned NOT NULL AUTO_INCREMENT,
  email varchar(250) NOT NULL,
  password varchar(60) NOT NULL,
  first_name varchar(100) NOT NULL,
  middle_name varchar(100),
  last_name varchar(100) NOT NULL,
  hire_date date,
  PRIMARY KEY (clerkID),
  UNIQUE KEY email (email)
);

CREATE TABLE Customer (
  customerID int(16) unsigned NOT NULL AUTO_INCREMENT,
  email varchar(250) NOT NULL,
  password varchar(60) NOT NULL,
  first_name varchar(100) NOT NULL,
  middle_name varchar(100),
  last_name varchar(100) NOT NULL,
  street_address varchar(100),
  city varchar(50),
  state varchar(20),
  zip char(5),
  primary_phone char(10) NOT NULL,
  home_phone char(10) DEFAULT NULL,
  work_phone char(10) DEFAULT NULL,
  cell_phone char(10) DEFAULT NULL,
  PRIMARY KEY (customerID),
  UNIQUE KEY email (email)
);

CREATE TABLE CreditCard (
  email varchar(250) NOT NULL,
  name varchar(100),
  number char(16),
  cvc char(3),
  exp_mon char(10),
  exp_yr char(10),
  PRIMARY KEY email (email)
);

CREATE TABLE Tool (
  toolID int(16) unsigned NOT NULL AUTO_INCREMENT,
  purchase_price DECIMAL(10,2) NOT NULL,
  power_source ENUM('Manual', 'Electric', 'Cordless', 'Gas') NOT NULL,
  category ENUM('Hand', 'Garden', 'Ladder', 'Power') NOT NULL,
  sub_type varchar(20) NOT NULL,
  sub_option varchar(20) NOT NULL,
  width_diameter float NOT NULL,
  length float NOT NULL,
  weight float NOT NULL,
  manufacturer varchar(20) NOT NULL,
  status varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandScrewdriver (
  toolID int(16) unsigned NOT NULL,
  screw_size float NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandSocket (
  toolID int(16) unsigned NOT NULL,
  drive_size float NOT NULL,
  sae_size float NOT NULL,
  deep_socket boolean DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandRatchet (
  toolID int(16) unsigned NOT NULL,
  drive_size float NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandPlier (
  toolID int(16) unsigned NOT NULL,
  adjustable boolean NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandGun (
  toolID int(16) unsigned NOT NULL,
  gauge_rating int(2) DEFAULT NULL,
  capacity int(4) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE HandHammer (
  toolID int(16) unsigned NOT NULL,
  anti_vibration boolean NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE GardenPruner (
  toolID int(16) unsigned NOT NULL,
  blade_material varchar(20) DEFAULT NULL,
  blade_length float NOT NULL,
  handle_material varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE GardenStriker (
  toolID int(16) unsigned NOT NULL,
  head_weight float NOT NULL,
  handle_material varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE GardenDigger (
  toolID int(16) unsigned NOT NULL,
  blade_width float DEFAULT NULL,
  blade_length float NOT NULL,
  handle_material varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE GardenRake (
  toolID int(16) unsigned NOT NULL,
  tine_count int(2) NOT NULL,
  handle_material varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE GardenWheelbarrow (
  toolID int(16) unsigned NOT NULL,
  bin_material varchar(20) NOT NULL,
  bin_volumn float DEFAULT NULL,
  wheel_count int(1) NOT NULL,
  handle_material varchar(20) NOT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE PowerDrill (
  toolID int(16) unsigned NOT NULL,
  adjustable_clutch boolean NOT NULL,
  min_torque_rating float NOT NULL,
  max_torque_rating float NOT NULL,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE PowerSaw (
  toolID int(16) unsigned NOT NULL,
  blade_size float NOT NULL,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE PowerSander (
  toolID int(16) unsigned NOT NULL,
  dust_bag boolean NOT NULL,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
); 
 
CREATE TABLE PowerAircompressor (
  toolID int(16) unsigned NOT NULL,
  tank_size float NOT NULL,
  pressure_rating float,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);
  
CREATE TABLE PowerMixer (
  toolID int(16) unsigned NOT NULL,
  motor_rating float NOT NULL,
  drum_size float NOT NULL,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE PowerGenerator (
  toolID int(16) unsigned NOT NULL,
  power_rating float NOT NULL,
  volt_rating int(3) NOT NULL,
  amp_rating float NOT NULL,
  min_rpm_rating int(5) NOT NULL,
  max_rpm_rating int(5) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE Accessory (
  accessoryID int(16) unsigned NOT NULL AUTO_INCREMENT,
  acc_quantity int(10) NOT NULL,
  acc_description varchar(100) NOT NULL,
  battery_type varchar(10) DEFAULT NULL,
  PRIMARY KEY accessoryID (accessoryID)
);

CREATE TABLE ToolAccessory (
  toolID int(16) unsigned NOT NULL,
  accessoryID int(16) unsigned NOT NULL,
  PRIMARY KEY tool_accessoryID (toolID,accessoryID)
);

CREATE TABLE LadderStraight (
  toolID int(16) unsigned NOT NULL,
  rubber_feet boolean DEFAULT NULL,
  step_count int(2) DEFAULT NULL,
  weight_capacity int(3) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE LadderStep (
  toolID int(16) unsigned NOT NULL,
  pail_shelf boolean DEFAULT NULL,
  step_count int(2) DEFAULT NULL,
  weight_capacity int(3) DEFAULT NULL,
  PRIMARY KEY toolID (toolID)
);

CREATE TABLE Reservation (
  reservationID int(16) unsigned NOT NULL AUTO_INCREMENT,
  customer_email varchar(250) NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  pickup_clerk_email varchar(250),
  dropoff_clerk_email varchar(250),
  PRIMARY KEY reservationID (reservationID)
);

CREATE TABLE ToolReservation (
  toolID int(16) unsigned NOT NULL,
  reservationID int(16) unsigned NOT NULL,
  PRIMARY KEY tool_reservationID (toolID,reservationID)
);

CREATE TABLE Service (
  toolID int(16) unsigned NOT NULL,
  clerk_email varchar(250) NOT NULL,
  start_date date NOT NULL,
  end_date date NOT NULL,
  cost DECIMAL(10,2) NOT NULL, 
  serviceID int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY tool_start_date (toolID,start_date), 
  UNIQUE KEY serviceID (serviceID)
);

CREATE TABLE Sell (
  toolID int(16) unsigned NOT NULL,
  clerk_email varchar(250) NOT NULL,
  on_sale_date date NOT NULL,
  saleID int(16) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY toolID (toolID),
  UNIQUE KEY saleID (saleID)
);

CREATE TABLE Purchase (
  toolID int(16) unsigned NOT NULL,
  customer_email varchar(250) NOT NULL,
  purchase_date date NOT NULL,
  PRIMARY KEY toolID (toolID)
);

-- Constrains Foreign Keys: FK_ChildTable_childColumn_ParentTable_parentColumn

ALTER TABLE CreditCard
  ADD CONSTRAINT fk_CreditCard_email_Customer_email FOREIGN KEY (email) REFERENCES Customer (email);

ALTER TABLE Reservation
  ADD CONSTRAINT fk_Reservation_customer_email_Customer_email FOREIGN KEY (customer_email) REFERENCES Customer (email),
  ADD CONSTRAINT fk_Reservation_pickup_clerk_email_Clerk_email FOREIGN KEY (pickup_clerk_email) REFERENCES Clerk (email),
  ADD CONSTRAINT fk_Reservation_dropoff_clerk_email_Clerk_email FOREIGN KEY (dropoff_clerk_email) REFERENCES Clerk (email);

ALTER TABLE Purchase
  ADD CONSTRAINT fk_Purchase_customer_email_Customer_email FOREIGN KEY (customer_email) REFERENCES Customer (email),
  ADD CONSTRAINT fk_Purchase_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE ToolReservation
  ADD CONSTRAINT fk_ToolReservation_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID),
  ADD CONSTRAINT fk_ToolReservation_reservationID_Reservation_reservationID FOREIGN KEY (reservationID) REFERENCES Reservation (reservationID);

ALTER TABLE Service
  ADD CONSTRAINT fk_Service_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID),
  ADD CONSTRAINT fk_Service_clerk_email_Clerk_email FOREIGN KEY (clerk_email) REFERENCES Clerk (email);

ALTER TABLE Sell
  ADD CONSTRAINT fk_Sell_clerk_email_Clerk_email FOREIGN KEY (clerk_email) REFERENCES Clerk (email),
  ADD CONSTRAINT fk_Sell_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandScrewdriver
  ADD CONSTRAINT fk_HandScrewdriver_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandSocket
  ADD CONSTRAINT fk_HandSocket_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandRatchet
  ADD CONSTRAINT fk_HandRatchet_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandPlier
  ADD CONSTRAINT fk_HandPlier_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandGun
  ADD CONSTRAINT fk_HandGun_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE HandHammer
  ADD CONSTRAINT fk_HandHammer_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE GardenPruner
  ADD CONSTRAINT fk_GardenPruner_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE GardenStriker
  ADD CONSTRAINT fk_GardenStriker_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE GardenDigger
  ADD CONSTRAINT fk_GardenDigger_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE GardenRake
  ADD CONSTRAINT fk_GardenRake_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE GardenWheelbarrow
  ADD CONSTRAINT fk_GardenWheelbarrow_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerDrill
  ADD CONSTRAINT fk_PowerDrill_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerSaw
  ADD CONSTRAINT fk_PowerSaw_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerSander
  ADD CONSTRAINT fk_PowerSander_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerAircompressor
  ADD CONSTRAINT fk_PowerAircompressor_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerMixer
  ADD CONSTRAINT fk_PowerMixer_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE PowerGenerator
  ADD CONSTRAINT fk_PowerGenerator_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE LadderStraight
  ADD CONSTRAINT fk_LadderStraignt_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE LadderStep
  ADD CONSTRAINT fk_LadderStep_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID);

ALTER TABLE ToolAccessory
  ADD CONSTRAINT fk_ToolAccessory_toolID_Tool_toolID FOREIGN KEY (toolID) REFERENCES Tool (toolID),
  ADD CONSTRAINT fk_ToolAccessory_accessoryID_Accessory_accessoryID FOREIGN KEY (accessoryID) REFERENCES Accessory (accessoryID);

-- Seed Data

INSERT INTO clerk (email, password, first_name, middle_name, last_name, hire_date) VALUES
('mike@tool.com', '123', 'Michael', 'Ethan', 'Owen', '2017-10-01'),
('brian@tool.com', '123', 'Brian', 'Camaron', 'Mike', '2017-08-20'),
('ava@tool.com', '123', 'Ava', 'Dian', 'Monica', '2017-08-21'),
('faron@tool.com', '123', 'Faron', 'Jon', 'Jon', '2017-08-22'),
('joe@tool.com', '123', 'Joe', 'Liam', 'Dillon', '2017-08-23'),
('phil@tool.com', '123', 'Phil', 'Song', 'Watson', '2017-08-24'),
('bailey@tool.com', '123', 'Bailey', 'Kelly', 'Dong', '2017-08-25'),
('violet@tool.com', '123', 'Violet', 'Siri', 'Nectar', '2017-08-26'),
('george@tool.com', '123', 'George', 'Voka', 'Satish', '2017-08-27'),
('aidan@tool.com', '123', 'Aidan', 'Ash', 'Nair', '2017-08-28'),
('ethan@tool.com', '123', 'Ethan', 'Adam', 'Mike', '2017-08-29');

INSERT INTO customer (email, password, first_name, middle_name, last_name, street_address, city, state, zip, primary_phone, home_phone, work_phone, cell_phone) VALUES
('mary@tool.com', '123', 'Mary', 'May', 'Johnson', '888 W Chicago Ave', 'Chicago', 'IL', '60612', '3121231230', '3121231230', '3121231230', '3121231230'),
('georgia@tool.com', '123', 'Georgia', 'Terrie', 'Yogurt', '123 E Main St', 'Atlanta', 'GA', '10454', '2064567890', '2064567890', '2064567890', '2064567890'),
('apple@tool.com', '123', 'Apple', 'Mona', 'Johnson', '111 W 111 Rd', 'Champaign', 'IL', '67032', '4259732341', '4257659831', '4259732341', '4258907766'),
('gorden@tool.com', '123', 'Gorden', 'Mark', 'Ethan', '123 E Edin St', 'Palto', 'CA', '50821', '2255544450', '1244587895', '4148526905', '2255544450'),
('sam@tool.com', '123', 'Sam', 'Aidan', 'Sanders', '123 E Edin St', 'Boston', 'MA', '18902', '5056068921', '5056067878', '5056067921', '5056068921'),
('pine@tool.com', '123', 'Pine', 'Grape', 'Water', '123 E Edin St', 'Champaign', 'IL', '12345', '4802765353', '4801034576', '4802765353', '4802765353');

INSERT INTO creditcard (email, name, number, cvc, exp_mon, exp_yr) VALUES
('mary@tool.com', 'Mary Johnson', '1234123412341234', '999', '1', '2018'),
('apple@tool.com', 'Apple Johnson', '1234123412341234', '999', '5', '2018'),
('georgia@tool.com', 'Georgia Yogurt', '1234123412341234', '999', '7', '2018'),
('gorden@tool.com', 'Gorden Ethan', '1234123412341234', '999', '9', '2018'),
('sam@tool.com', null, null, null, null, null),
('pine@tool.com', 'Pine Water', '1334125478991258', '778', '8', '2019');

INSERT INTO tool (toolID, purchase_price, power_source, category, sub_type, sub_option, width_diameter, length, weight, manufacturer, status) VALUES
(1, '10.00', 'Manual', 'Hand', 'Screwdriver', 'Phillips', 1, 2, 3, 'Phillips', 'Available'),
(2, '50.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 20, 100, 20, 'Phillips', 'Available'),
(3, '12.00', 'Manual', 'Hand', 'Screwdriver', 'Hex', 5, 6, 3, 'Hex', 'Rented'),
(4, '13.00', 'Manual', 'Hand', 'Screwdriver', 'Torx', 5, 6, 3, 'Torx', 'Rented'),
(5, '14.00', 'Manual', 'Hand', 'Screwdriver', 'Slotted ', 5, 6, 3, 'Slotted ', 'Available'),
(6, '15.00', 'Manual', 'Hand', 'Socket', 'Deep', 5, 6, 3, 'Deep', 'Available'),
(7, '16.00', 'Manual', 'Hand', 'Socket', 'Standard', 5, 6, 3, 'Standard', 'Available'),
(8, '17.00', 'Manual', 'Hand', 'Ratchet', 'Adjustable', 5, 6, 3, 'Adjustable', 'Available'),
(9, '18.00', 'Manual', 'Hand', 'Ratchet', 'Fixed', 5, 6, 3, 'Fixed', 'Available'),
(10, '19.00', 'Manual', 'Hand', 'Wrench', 'Drescent', 5, 6, 3, 'Drescent', 'Available'),
(11, '20.00', 'Manual', 'Hand', 'Wrench', 'Torque', 5, 6, 3, 'Torque', 'Available'),
(12, '21.00', 'Manual', 'Hand', 'Wrench', 'Pipe', 5, 6, 3, 'Pipe', 'Available'),
(13, '22.00', 'Manual', 'Hand', 'Pliers', 'Needle Nose', 5, 6, 3, 'Needle Nose', 'Available'),
(14, '23.00', 'Manual', 'Hand', 'Pliers', 'Cutting', 5, 6, 3, 'Cutting', 'Available'),
(15, '24.00', 'Manual', 'Hand', 'Pliers', 'Crimper', 5, 6, 3, 'Crimper', 'Available'),
(16, '25.00', 'Manual', 'Hand', 'Gun', 'Nail', 5, 6, 3, 'Nail', 'Available'),
(17, '26.00', 'Manual', 'Hand', 'Gun', 'Staple', 5, 6, 3, 'Staple', 'Available'),
(18, '27.00', 'Manual', 'Hand', 'Hammer', 'Claw', 5, 6, 3, 'Claw', 'Available'),
(19, '28.00', 'Manual', 'Hand', 'Hammer', 'Sledge', 5, 6, 3, 'Sledge', 'Available'),
(20, '29.00', 'Manual', 'Hand', 'Hammer', 'Framing', 5, 6, 3, 'Framing', 'Available'),
(21, '31.00', 'Manual', 'Garden', 'Digger', 'Pointed Shovel', 5, 6, 3, 'HomeDepot', 'Available'),
(22, '32.00', 'Manual', 'Garden', 'Digger', 'Flat Shovel', 5, 6, 3, 'HomeDepot', 'Available'),
(23, '33.00', 'Manual', 'Garden', 'Digger', 'Scoop shovel', 5, 6, 3, 'HomeDepot', 'Available'),
(24, '34.00', 'Manual', 'Garden', 'Digger', 'Edger', 5, 6, 3, 'HomeDepot', 'Available'),
(25, '35.00', 'Manual', 'Garden', 'Pruner', 'Sheer', 5, 6, 3, 'HomeDepot', 'Available'),
(26, '36.00', 'Manual', 'Garden', 'Pruner', 'Loppers', 5, 6, 3, 'HomeDepot', 'Available'),
(27, '37.00', 'Manual', 'Garden', 'Pruner', 'Hedge', 5, 6, 3, 'HomeDepot', 'Available'),
(28, '38.00', 'Manual', 'Garden', 'Rakes', 'Leaf', 5, 6, 3, 'HomeDepot', 'Available'),
(29, '39.00', 'Manual', 'Garden', 'Rakes', 'Landscaping', 5, 6, 3, 'HomeDepot', 'Available'),
(30, '40.00', 'Manual', 'Garden', 'Rakes', 'Rock', 5, 6, 3, 'HomeDepot', 'Available'),
(31, '41.00', 'Manual', 'Garden', 'Wheelbarrows', '1-Wheel', 5, 6, 3, 'HomeDepot', 'Available'),
(32, '42.00', 'Manual', 'Garden', 'Wheelbarrows', '2-Wheel', 5, 6, 3, 'HomeDepot', 'Available'),
(33, '43.00', 'Manual', 'Garden', 'Striking', 'Bar Pry', 5, 6, 3, 'HomeDepot', 'Available'),
(34, '44.00', 'Manual', 'Garden', 'Striking', 'Rubber Mallet', 5, 6, 3, 'HomeDepot', 'Available'),
(35, '45.00', 'Manual', 'Garden', 'Striking', 'Tamper', 5, 6, 3, 'HomeDepot', 'Available'),
(36, '46.00', 'Manual', 'Garden', 'Striking', 'Pick Axe', 5, 6, 3, 'HomeDepot', 'Available'),
(37, '47.00', 'Manual', 'Garden', 'Striking', 'Single Bit Axe', 5, 6, 3, 'HomeDepot', 'Available'),
(38, '25.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 5, 6, 3, 'Lowes', 'Available'),
(39, '26.00', 'Manual', 'Ladder', 'Straight', 'Telescoping', 5, 6, 3, 'Lowes', 'Available'),
(40, '27.00', 'Manual', 'Ladder', 'Step', 'Folding', 5, 6, 3, 'Lowes', 'Rented'),
(41, '28.00', 'Manual', 'Ladder', 'Step', 'Multi-Position', 5, 6, 3, 'Lowes', 'Available'),
(42, '29.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 5, 6, 3, 'Lowes', 'Available'),
(43, '30.00', 'Manual', 'Ladder', 'Straight', 'Telescoping', 5, 6, 3, 'Lowes', 'Available'),
(44, '31.00', 'Manual', 'Ladder', 'Step', 'Folding', 5, 6, 3, 'Lowes', 'Available'),
(45, '32.00', 'Manual', 'Ladder', 'Step', 'Multi-Position', 5, 6, 3, 'Lowes', 'Rented'),
(46, '33.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 5, 6, 3, 'Lowes', 'Available'),
(47, '34.00', 'Manual', 'Ladder', 'Straight', 'Telescoping', 5, 6, 3, 'Lowes', 'Available'),
(48, '35.00', 'Manual', 'Ladder', 'Step', 'Folding', 5, 6, 3, 'Lowes', 'Available'),
(49, '36.00', 'Manual', 'Ladder', 'Step', 'Multi-Position', 5, 6, 3, 'Lowes', 'Available'),
(50, '37.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 5, 6, 3, 'Lowes', 'Rented'),
(51, '38.00', 'Manual', 'Ladder', 'Straight', 'Telescoping', 5, 6, 3, 'Lowes', 'Available'),
(52, '39.00', 'Manual', 'Ladder', 'Step', 'Folding', 5, 6, 3, 'Lowes', 'Available'),
(53, '40.00', 'Manual', 'Ladder', 'Step', 'Multi-Position', 5, 6, 3, 'Lowes', 'Available'),
(54, '41.00', 'Manual', 'Ladder', 'Straight', 'Rigid', 5, 6, 3, 'Lowes', 'Available'),
(55, '38.00', 'Electric', 'Power', 'Drill', 'Driver', 5, 6, 3, 'Walmart', 'Available'),
(56, '39.00', 'Electric', 'Power', 'Drill', 'Hammer', 5, 6, 3, 'Walmart', 'Available'),
(57, '40.00', 'Electric', 'Power', 'Saw', 'Circular', 5, 6, 3, 'Walmart', 'Available'),
(58, '41.00', 'Electric', 'Power', 'Saw', 'Reciprocating', 5, 6, 3, 'Walmart', 'Available'),
(59, '42.00', 'Electric', 'Power', 'Saw', 'Jig', 5, 6, 3, 'Walmart', 'Available'),
(60, '43.00', 'Electric', 'Power', 'Sander', 'Finish', 5, 6, 3, 'Walmart', 'Available'),
(61, '44.00', 'Electric', 'Power', 'Sander', 'Sheet', 5, 6, 3, 'Walmart', 'Available'),
(62, '45.00', 'Electric', 'Power', 'Sander', 'Belt', 5, 6, 3, 'Walmart', 'Available'),
(63, '46.00', 'Electric', 'Power', 'Sander', 'Random Orbital', 5, 6, 3, 'Walmart', 'Available'),
(64, '47.00', 'Electric', 'Power', 'Air-compressor', 'Reciprocating', 5, 6, 3, 'Walmart', 'Available'),
(65, '48.00', 'Electric', 'Power', 'Mixer', 'Concrete', 5, 6, 3, 'Walmart', 'Available'),
(66, '49.00', 'Gas', 'Power', 'Generator', 'Electric', 5, 6, 3, 'Walmart', 'Available'),
(67, '50.00', 'Cordless', 'Power', 'Drill', 'Driver', 5, 6, 3, 'Walmart', 'Available'),
(68, '51.00', 'Cordless', 'Power', 'Drill', 'Hammer', 5, 6, 3, 'Walmart', 'Available'),
(69, '52.00', 'Cordless', 'Power', 'Saw', 'Circular', 5, 6, 3, 'Walmart', 'Available'),
(70, '53.00', 'Cordless', 'Power', 'Saw', 'Reciprocating', 5, 6, 3, 'Walmart', 'Available'),
(71, '54.00', 'Cordless', 'Power', 'Saw', 'Jig', 5, 6, 3, 'Walmart', 'Available'),
(73, '44.00', 'Cordless', 'Power', 'Sander', 'Sheet', 5, 6, 3, 'Walmart', 'Available'),
(74, '45.00', 'Cordless', 'Power', 'Sander', 'Belt', 5, 6, 3, 'Walmart', 'Available'),
(75, '46.00', 'Cordless', 'Power', 'Sander', 'Random Orbital', 5, 6, 3, 'Walmart', 'Available'),
(76, '47.00', 'Gas', 'Power', 'Air-compressor', 'Reciprocating', 5, 6, 3, 'Walmart', 'Available'),
(77, '48.00', 'Gas', 'Power', 'Mixer', 'Concrete', 5, 6, 3, 'Walmart', 'Available'),
(78, '43.00', 'Gas', 'Power', 'Generator', 'Electric', 5, 6, 3, 'Walmart', 'Available'),
(79, '44.00', 'Electric', 'Power', 'Drill', 'Driver', 5, 6, 3, 'Walmart', 'Available'),
(80, '44.00', 'Electric', 'Power', 'Drill', 'Hammer', 5, 6, 3, 'Walmart', 'Available'),
(81, '45.00', 'Electric', 'Power', 'Saw', 'Circular', 5, 6, 3, 'Walmart', 'Available'),
(82, '46.00', 'Electric', 'Power', 'Saw', 'Reciprocating', 5, 6, 3, 'Walmart', 'Available'),
(83, '47.00', 'Cordless', 'Power', 'Saw', 'Jig', 5, 6, 3, 'Walmart', 'Available'),
(84, '48.00', 'Cordless', 'Power', 'Sander', 'Finish', 5, 6, 3, 'Walmart', 'Available'),
(85, '49.00', 'Cordless', 'Power', 'Sander', 'Sheet', 5, 6, 3, 'Walmart', 'Available'),
(86, '44.00', 'Cordless', 'Power', 'Sander', 'Belt', 5, 6, 3, 'Walmart', 'Available');

INSERT INTO accessory (acc_quantity, acc_description, battery_type) VALUES
(1, '18.0V Li-ion Battery', 'D/C'),
(1, 'Battery Charger', ''),
(1, 'Saw Blade', ''),
(1, 'Soft Case', '');

INSERT INTO toolaccessory (toolID, accessoryID) VALUES
(67, 1),
(67, 2),
(81, 3),
(81, 4);

INSERT INTO reservation (reservationID, customer_email, start_date, end_date, pickup_clerk_email, dropoff_clerk_email) VALUES
(1, 'mary@tool.com', '2017-10-10', '2017-10-12', 'mike@tool.com', 'mike@tool.com'),
(2, 'mary@tool.com', '2017-10-01', '2017-10-05', 'faron@tool.com', 'brian@tool.com'),
(3, 'apple@tool.com', '2017-10-01', '2017-10-30', 'mike@tool.com', NULL),
(4, 'pine@tool.com', '2017-11-01', '2017-11-05', NULL, NULL),
(5, 'georgia@tool.com', '2017-10-20', '2017-10-30', 'joe@tool.com', NULL),
(6, 'sam@tool.com', '2017-11-04', '2017-11-05', NULL, NULL),
(7, 'mary@tool.com', '2017-10-15', '2017-10-16', 'ava@tool.com', 'joe@tool.com'),
(8, 'mary@tool.com', '2017-10-16', '2017-10-17','faron@tool.com', 'bailey@tool.com'),
(9, 'gorden@tool.com', '2017-10-02', '2017-10-04', 'mike@tool.com', 'bailey@tool.com'),
(10, 'sam@tool.com', '2017-11-15', '2017-11-16', NULL, NULL),
(11, 'pine@tool.com', '2017-11-07', '2017-11-09', NULL, NULL);

INSERT INTO toolreservation (toolID, reservationID) VALUES
(1, 1),
(2, 1),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(3, 3), 
(4, 3), 
(20, 4),
(40, 5), 
(45, 5),
(50, 5), 
(66, 6), 
(67, 6),
(34, 7),
(36, 7),
(42, 7),
(33, 8),
(5, 8),
(6, 9),
(7, 9),
(81, 10),
(82, 10),
(83, 10),
(79, 11),
(86, 11);

ALTER TABLE tool ADD COLUMN description VARCHAR(250);

UPDATE tool SET description = IF(power_source='Manual', CONCAT(sub_option, ' ', sub_type), CONCAT(power_source, ' ', sub_option, ' ', sub_type));

CREATE VIEW tool_outjoin_reservation AS SELECT tool.toolID, purchase_price, power_source, category, sub_type, sub_option, width_diameter, length, weight, manufacturer, status, description, reservation.reservationID, customer_email, start_date, end_date, pickup_clerk_email, dropoff_clerk_email FROM tool LEFT OUTER JOIN toolreservation ON tool.toolID = toolreservation.toolID LEFT OUTER JOIN Reservation ON ToolReservation.reservationID = Reservation.reservationID;
