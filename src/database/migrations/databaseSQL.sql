

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `UserID` int DEFAULT NULL,
  `FName` varchar(255) DEFAULT NULL,
  `LName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Pswd` varchar(255) DEFAULT NULL,
  `Salt` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_user`
--


--
-- Table structure for table `tbl_images`
--
DROP TABLE IF EXISTS `tbl_images`;
CREATE TABLE `tbl_images` (
  `ImageID` int DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `PrimaryImage` bit(1) DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_images`
--


--
-- Table structure for table `tbl_notes`
--
DROP TABLE IF EXISTS `tbl_notes`;
CREATE TABLE `tbl_notes` (
  `NoteID` int DEFAULT NULL,
  `NotesDate` datetime DEFAULT NULL,
  `Notes` varchar(255) DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_notes`
--


--
-- Table structure for table `tbl_locations`
--
DROP TABLE IF EXISTS `tbl_locations`;
CREATE TABLE `tbl_locations` (
  `City` varchar(50) DEFAULT NULL,
  `CityID` int DEFAULT NULL,
  `ProvinceName` varchar(50) DEFAULT NULL,
  `CountryName` varchar(50) DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_locations`
--


--
-- Table structure for table `tbl_customers`
--
DROP TABLE IF EXISTS `tbl_customers`;
CREATE TABLE `tbl_customers` (
  `CustomerID` int DEFAULT NULL,
  `CompanyName` varchar(75) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Title` varchar(50) DEFAULT NULL,
  `CustomerAddress` varchar(150) DEFAULT NULL,
  `CustomerPostal` varchar(20) DEFAULT NULL,
  `CityID_Fkey` int DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Other` varchar(15) DEFAULT NULL,
  `Fax` varchar(15) DEFAULT NULL,
  `NoteID_Fkey` int DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL,
  `OLDRecordNum` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_customers`
--

--
-- Table structure for table `tblbuildings`
--
DROP TABLE IF EXISTS `tbl_buildings`;
CREATE TABLE `tbl_buildings` (
  `BuildingID` int DEFAULT NULL,
  `CustomerID_Fkey` int DEFAULT NULL,
  `BuildingDesc` varchar(150) DEFAULT NULL,
  `BuildingAddress` varchar(150) DEFAULT NULL,
  `CityID_Fkey` int DEFAULT NULL,
  `BuildingPostal` varchar (20) DEFAULT NULL,
  `ImageID_Fkey` int DEFAULT NULL,
  `NoteID_Fkey` int DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tblbuildings`
--


--
-- Table structure for table `tbl_contracts`
--
DROP TABLE IF EXISTS `tbl_contracts`;
CREATE TABLE `tbl_contracts` (
  `ContractID` int DEFAULT NULL,
  `BuildingID_Fkey` int DEFAULT NULL,
  `CustomerID_Fkey` int DEFAULT NULL,
  `ImageID_Fkey` int DEFAULT NULL,
  `SMPNum` varchar(10) DEFAULT NULL,
  `SMPQuote` bit(1) DEFAULT NULL,
  `SMPActive` bit(1) DEFAULT NULL,
  `SMPReceived` bit(1) DEFAULT NULL,
  `ContractStartDate` datetime DEFAULT NULL,
  `ContractEndDate` datetime DEFAULT NULL,
  `RenewalDate` datetime DEFAULT NULL,
  `NumInstallments` smallint DEFAULT NULL,
  `TermLength` int DEFAULT NULL,
  `ContractUpdate` datetime DEFAULT NULL,
  `Yr1Price` double DEFAULT NULL,
  `Yr2Price` double DEFAULT NULL,
  `Renewal1_2` double DEFAULT NULL,
  `Renewal3_4` double DEFAULT NULL,
  `Renewal5_6` double DEFAULT NULL,
  `ActivePrice` double DEFAULT NULL,
  `BillMonth` varchar(23) DEFAULT NULL,
  `NoteID_Fkey` int DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL,
  `OldRecordNum` int DEFAULT NULL,
  `AgreedTo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_contracts`
--


--
-- Table structure for table `tbl_contractequipment`
--
DROP TABLE IF EXISTS `tbl_contractequipment`;
CREATE TABLE `tbl_contractequipment` (
  `ContractEquipmentID` int DEFAULT NULL,
  `ContractID_Fkey` int DEFAULT NULL,
  `BuildingID_Fkey` int DEFAULT NULL,
  `EquipmentID_Fkey` int DEFAULT NULL,
  `WorkMonth` varchar(23) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_contractequipment`
--


--
-- Table structure for table `tbl_manufacturers`
--
DROP TABLE IF EXISTS `tbl_manufacturers`;
CREATE TABLE `tbl_manufacturers` (
  `ManufacturerID` int DEFAULT NULL,
  `ManufacturerName` varchar(50) DEFAULT NULL,
  `NoteID_FKey` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_manufacturers`
--


--
-- Table structure for table `tbl_equipment`
--
DROP TABLE IF EXISTS `tbl_equipment`;
CREATE TABLE `tbl_equipment` (
  `EquipmentID` int DEFAULT NULL,
  `BuildingID_Fkey` int DEFAULT NULL,
  `UnitID` varchar(50) DEFAULT NULL,
  `EquipmentTypeID_Fkey` int DEFAULT NULL,
  `ManufacturerID_Fkey` int DEFAULT NULL,
  `Model` varchar(50) DEFAULT NULL,
  `Serial` varchar(50) DEFAULT NULL,
  `InServiceStart` datetime DEFAULT NULL,
  `InServiceEnd` datetime DEFAULT NULL,
  `LocationRoom` varchar(50) DEFAULT NULL,
  `NoteID_Fkey` int DEFAULT NULL,
  `Active` bit(1) DEFAULT NULL,
  `RecordDate` datetime DEFAULT NULL,
  `EquipmentValue` double DEFAULT NULL,
  `FullDetails` bit(1) DEFAULT NULL,
  `JobNumber` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_equipment`
--


--
-- Table structure for table `tbl_equiptype`
--
DROP TABLE IF EXISTS `tbl_equiptype`;
CREATE TABLE `tbl_equiptype` (
  `EquipmentTypeID` int DEFAULT NULL,
  `EquipType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_equiptype`
--


--
-- Table structure for table `tbllu_refrigeranttypes`
--
DROP TABLE IF EXISTS `tbl_refrigeranttypes`;
CREATE TABLE `tbl_refrigeranttypes` (
  `RefrigerantTypeID` int DEFAULT NULL,
  `RefrigerantCode` varchar(10) DEFAULT NULL,
  `RefrigerationModel` varchar(50) DEFAULT NULL,
  `RefrigerationSerial` varchar(50) DEFAULT NULL,
  `TotalRefrigerationCharge` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbllu_refrigeranttypes`
--


--
-- Table structure for table `tbl_filter`
--
DROP TABLE IF EXISTS `tbl_filter`;
CREATE TABLE `tbl_filter` (
  `FilterTypeID` int DEFAULT NULL,
  `FilterType` varchar(50) DEFAULT NULL,
  `EquipmentFilter` varchar(50) DEFAULT NULL,
  `FilterQty` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_filter`
--


--
-- Table structure for table `tbl_battery`
--
DROP TABLE IF EXISTS `tbl_battery`;
CREATE TABLE `tbl_battery` (
  `BatteryTypeID` int DEFAULT NULL,
  `BatteryTypeCode` varchar(20) DEFAULT NULL,
  `BatteryType` varchar(50) DEFAULT NULL,
  `BatteryQty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_520_ci;
--
-- Dumping data for table `tbl_battery`
--



-- Consult with client--

--
-- Table structure for table `tblcontractequipservicelogs`
--


ALTER TABLE tbl_user 
ADD PRIMARY KEY(UserID); 

ALTER TABLE tbl_images 
ADD PRIMARY KEY(ImageID); 

ALTER TABLE tbl_notes 
ADD PRIMARY KEY(NoteID);

ALTER TABLE tbl_locations 
ADD PRIMARY KEY(CityID); 

ALTER TABLE tbl_customers 
ADD PRIMARY KEY(CustomerID);

ALTER TABLE tbl_customers
ADD FOREIGN KEY(CityID_Fkey) REFERENCES tbl_locations(CityID);

ALTER TABLE tbl_customers 
ADD FOREIGN KEY(NoteID_Fkey) REFERENCES tbl_notes(NoteID);


ALTER TABLE tbl_buildings
ADD PRIMARY KEY(BuildingID);

ALTER TABLE tbl_buildings
ADD FOREIGN KEY (CustomerID_Fkey) REFERENCES tbl_customers(CustomerID);

ALTER TABLE tbl_buildings
ADD FOREIGN KEY (CityID_FKey) REFERENCES tbl_locations(CityID);

ALTER TABLE tbl_buildings
ADD FOREIGN KEY(ImageID_Fkey) REFERENCES tbl_images(ImageID);

ALTER TABLE tbl_buildings
ADD FOREIGN KEY(NoteID_Fkey) REFERENCES tbl_notes(NoteID);



ALTER TABLE tbl_contracts
ADD PRIMARY KEY(ContractID);

ALTER TABLE tbl_contracts
ADD FOREIGN KEY (BuildingID_Fkey) REFERENCES tbl_buildings(BuildingID); 

ALTER TABLE tbl_contracts
ADD FOREIGN KEY (CustomerID_Fkey) REFERENCES tbl_Customers(CustomerID);

ALTER TABLE tbl_contracts
ADD FOREIGN KEY (ImageID_Fkey) REFERENCES tbl_images(ImageID);



ALTER TABLE tbl_contracts
ADD FOREIGN KEY (NoteID_Fkey) REFERENCES tbl_notes(NoteID);




ALTER TABLE tbl_manufacturers
ADD PRIMARY KEY(ManufacturerID);

ALTER TABLE tbl_manufacturers 
ADD FOREIGN KEY (NoteID_FKey) REFERENCES tbl_notes(NoteID);

ALTER TABLE tbl_equiptype
ADD PRIMARY KEY(EquipmentTypeID);


ALTER TABLE tbl_refrigeranttypes
ADD PRIMARY KEY(RefrigerantTypeID);

ALTER TABLE tbl_filter
ADD PRIMARY KEY(FilterTypeID);

ALTER TABLE tbl_battery
ADD PRIMARY KEY(BatteryTypeID);


ALTER TABLE tbl_contractequipment
ADD PRIMARY KEY(ContractEquipmentID);



ALTER TABLE tbl_equipment
ADD PRIMARY KEY(EquipmentID);

ALTER TABLE tbl_equipment 
ADD FOREIGN KEY (BuildingID_Fkey) REFERENCES tbl_buildings(BuildingID);

ALTER TABLE tbl_equipment 
ADD FOREIGN KEY (EquipmentTypeID_Fkey) REFERENCES tbl_equiptype(EquipmentTypeID);

ALTER TABLE tbl_equipment 
ADD FOREIGN KEY (ManufacturerID_Fkey) REFERENCES tbl_manufacturers(ManufacturerID);

ALTER TABLE tbl_equipment 
ADD FOREIGN KEY (NoteID_Fkey) REFERENCES tbl_notes(NoteID);


ALTER TABLE tbl_contractequipment
ADD FOREIGN KEY (ContractID_Fkey) REFERENCES tbl_contracts(ContractID);

ALTER TABLE tbl_contractequipment
ADD FOREIGN KEY (BuildingID_Fkey) REFERENCES tbl_buildings(BuildingID);

ALTER TABLE tbl_contractequipment
ADD FOREIGN KEY (EquipmentID_Fkey) REFERENCES tbl_equipment(EquipmentID);

SET FOREIGN_KEY_CHECKS=0;


-- Contracts -----------------------------------------------------------------------------------
LOCK TABLES `tbl_customers` WRITE;
INSERT INTO `tbl_customers` VALUES (1, 'Company1', 'Tim', 'Wilson', 'Mr.', '123 street', 'A2N 2O1', 1 , 'test1@gmail.com', '2503334444', 'info', 'Fax', 1 , 0, '1900-01-01 00:00:00', 23 );
UNLOCK TABLES;

LOCK TABLES `tbl_contracts` WRITE;
INSERT INTO `tbl_contracts` VALUES (1, 1, 1, 1 , 4044, 0, 0, 1, '1900-01-01 00:00:00', '1900-01-01 00:00:00', '1900-01-01 00:00:00', 12, 6, '1900-01-01 00:00:00', 100, 200, 300, 400, 500, 2340, '0 1 1 1 1 1 1 1 1 1 1 1', 1,'1900-01-01 00:00:00', '1900-01-01 00:00:00', 123, 'Agree');
UNLOCK TABLES;

LOCK TABLES `tbl_contractequipment` WRITE;
INSERT INTO `tbl_contractequipment` VALUES (1,1,1,1,'0 1 1 1 1 1 1 1 1 1 1 1','1900-01-01 00:00:00','1900-01-01 00:00:00');
UNLOCK TABLES;


-- Equipments -----------------------------------------------------------------------------------

LOCK TABLES `tbl_filter` WRITE;
INSERT INTO `tbl_filter` VALUES (1, 'filter type 1', 'equipment filter ', 6);
UNLOCK TABLES;


LOCK TABLES `tbl_equiptype` WRITE;
INSERT INTO `tbl_equiptype` VALUES (1, 'equip type 1');
UNLOCK TABLES;


--
LOCK TABLES `tbl_equipment` WRITE;
INSERT INTO `tbl_equipment` VALUES (1, 1, 'AB-11', 1, 1, '123ABC/1-A', '123A-1', '1900-01-01 00:00:00', '1900-01-02 00:00:00', 'locationRoom', 1, 0, '1900-01-01 00:00:00', 300 , 0, 5);
UNLOCK TABLES;

LOCK TABLES `tbl_images` WRITE;
INSERT INTO `tbl_images` VALUES (1, 'imagepath', 1, '1900-01-01 00:00:00');
UNLOCK TABLES;

LOCK TABLES `tbl_manufacturers` WRITE;
INSERT INTO `tbl_manufacturers` VALUES (1, 'Manufacturer 1', 1);
UNLOCK TABLES;


-- locations -----------------------------------------------------------------------------------


LOCK TABLES `tbl_buildings` WRITE;
INSERT INTO `tbl_buildings` VALUES (1,1, 'is a Building', '123 somewhere St.', 1, 'postal B', 1, 1, 1, '1900-01-01 00:00:00');
UNLOCK TABLES;


-- city id, province id fkey, city, active
LOCK TABLES `tbl_locations` WRITE;
INSERT INTO `tbl_locations` VALUES ('Kelowna', 1, 'BC', 'Canada',1);
UNLOCK TABLES;




-- Insert Types -----------------------------------------------------------------------------------
LOCK TABLES `tbl_refrigeranttypes` WRITE;
INSERT INTO `tbl_refrigeranttypes` VALUES (1, 'R99', 'R-301','light',4);
UNLOCK TABLES;

LOCK TABLES `tbl_battery` WRITE;
INSERT INTO `tbl_battery` VALUES (1, 'PeaceKeeper', 'EVA-8', 2);
UNLOCK TABLES;

LOCK TABLES `tbl_notes` WRITE;
INSERT INTO `tbl_notes` VALUES (1, '1900-01-01 00:00:00', 'test Notes', 1);
UNLOCK TABLES;

-- Users -----------------------------------------------------------------------------------
LOCK TABLES `tbl_user` WRITE;
INSERT INTO `tbl_user` VALUES (1, 'FirstName', 'LastName', 'NAnumber1@gmail.com', 'TeemoNumber1','12AB');
UNLOCK TABLES;

SET FOREIGN_KEY_CHECKS=1;

