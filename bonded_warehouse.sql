-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 05, 2017 at 10:14 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bonded_warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_login`
--

CREATE TABLE `client_login` (
  `client_id` int(11) NOT NULL,
  `pm_id` int(11) NOT NULL,
  `login_id` varchar(300) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `despatch_request`
--

CREATE TABLE `despatch_request` (
  `pdr_id` int(11) NOT NULL,
  `bond_number` varchar(50) NOT NULL,
  `sac_par_table` varchar(10) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `client_web` varchar(20) NOT NULL,
  `cha_name` varchar(50) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `boe_number` varchar(50) NOT NULL,
  `exbond_be_number` varchar(50) NOT NULL,
  `exbond_be_date` date NOT NULL,
  `customs_officer_name` varchar(50) NOT NULL,
  `number_of_packages` int(11) NOT NULL,
  `assessment_value` varchar(50) NOT NULL,
  `duty_value` varchar(50) NOT NULL,
  `transporter_name` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `despatch_request`
--

INSERT INTO `despatch_request` (`pdr_id`, `bond_number`, `sac_par_table`, `sac_par_id`, `client_web`, `cha_name`, `order_number`, `boe_number`, `exbond_be_number`, `exbond_be_date`, `customs_officer_name`, `number_of_packages`, `assessment_value`, `duty_value`, `transporter_name`, `status`) VALUES
(1, '6674', 'par', 44, 'Debond', 'abc', '1234', '445533', '334421', '2017-07-14', 'ram', 45, '4', '4', 'KPN', 'igp_created');

-- --------------------------------------------------------

--
-- Table structure for table `document_verification`
--

CREATE TABLE `document_verification` (
  `do_ver_id` int(11) NOT NULL,
  `sac_par_table` varchar(50) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `cfs_name` varchar(200) NOT NULL,
  `customs_officer_name` varchar(100) NOT NULL,
  `do_number` varchar(100) NOT NULL,
  `do_date` date NOT NULL,
  `bond_number` varchar(50) DEFAULT NULL,
  `bond_date` date DEFAULT NULL,
  `do_issued_by` varchar(100) NOT NULL,
  `weight` varchar(100) NOT NULL DEFAULT 'no',
  `no_of_packages` varchar(100) NOT NULL DEFAULT 'no',
  `description` varchar(100) NOT NULL DEFAULT 'no',
  `invoice_copy` varchar(10) NOT NULL DEFAULT 'no',
  `packing_list` varchar(10) NOT NULL DEFAULT 'no',
  `boe_copy` varchar(10) NOT NULL DEFAULT 'no',
  `bond_order` varchar(10) NOT NULL DEFAULT 'no',
  `do_verification` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_verification`
--

INSERT INTO `document_verification` (`do_ver_id`, `sac_par_table`, `sac_par_id`, `cfs_name`, `customs_officer_name`, `do_number`, `do_date`, `bond_number`, `bond_date`, `do_issued_by`, `weight`, `no_of_packages`, `description`, `invoice_copy`, `packing_list`, `boe_copy`, `bond_order`, `do_verification`) VALUES
(4, 'par', 1, 'tambram', 'xyz', '123', '2017-05-06', '44564', '2017-07-17', 'abc', 'yes', 'no', 'no', 'no', 'no', 'yes', 'no', 'yes'),
(5, 'par', 2, 'eerr', 'qwd', '123', '2017-06-28', '33225', '2017-06-20', '786', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'yes'),
(6, 'par', 4, '34', '44', '788', '0000-00-00', '344', '2017-06-23', '9900', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes'),
(7, 'par', 4, '1', '1', '1', '2017-06-27', '1', '2017-06-20', 's', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no'),
(8, 'par', 44, 'qq', 'qq', '44422', '2017-06-29', '1344', '2017-06-26', 'rr', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes'),
(9, 'par', 11, 'eer', 'qwwe', '334', '2017-07-11', 'qr445', '2017-07-17', '45t', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes'),
(10, 'par', 44, '1', '1', '2233', '2017-07-27', '6674', '2017-07-24', 'eerrttyy', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `dv_items`
--

CREATE TABLE `dv_items` (
  `dv_item_id` int(11) NOT NULL,
  `container_number` int(11) DEFAULT NULL,
  `sac_par_table` varchar(10) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `assessable_value` varchar(50) NOT NULL,
  `duty_value` varchar(50) NOT NULL,
  `insurance_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dv_items`
--

INSERT INTO `dv_items` (`dv_item_id`, `container_number`, `sac_par_table`, `sac_par_id`, `item_name`, `item_qty`, `assessable_value`, `duty_value`, `insurance_value`) VALUES
(1, NULL, 'par', 1, 'a', 0, '1', '1', '2'),
(2, NULL, 'par', 1, 'b', 0, '2', '2', '4'),
(3, NULL, 'par', 1, 'c', 0, '3', '3', '6'),
(4, NULL, 'par', 2, '', 0, '', '', ''),
(5, NULL, 'par', 4, '', 0, '', '', ''),
(6, NULL, 'par', 4, '', 0, '', '', ''),
(7, 6644556, 'par', 44, 'dummy', 0, '1', '1', '2'),
(8, 937789, 'par', 44, 'dummy 2', 0, '2', '2', '4'),
(9, 0, 'par', 11, '', 0, '', '', ''),
(10, 4355, 'par', 44, 'rrqq', 23, '1', '1', '2'),
(11, 937789, 'par', 44, '334', 34, '2', '2', '4');

-- --------------------------------------------------------

--
-- Table structure for table `exception`
--

CREATE TABLE `exception` (
  `exception_id` int(11) NOT NULL,
  `exception_type` varchar(50) NOT NULL,
  `exception_subtype` varchar(50) NOT NULL,
  `exception_remarks` varchar(500) NOT NULL,
  `exception_closingremarks` varchar(500) NOT NULL,
  `exception_status` varchar(50) NOT NULL DEFAULT 'created',
  `exception_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `exception`
--

INSERT INTO `exception` (`exception_id`, `exception_type`, `exception_subtype`, `exception_remarks`, `exception_closingremarks`, `exception_status`, `exception_time`) VALUES
(2, 'joborder_unloading', 'damage', '3', 'rectified', '', '2017-05-06 05:06:12'),
(3, 'joborder_unloading', 'excess', '2 excess', '', 'created', '2017-05-06 05:34:12');

-- --------------------------------------------------------

--
-- Table structure for table `good_receipt_note`
--

CREATE TABLE `good_receipt_note` (
  `grn_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `sac_par_table` varchar(10) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `space_occupied` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `validity` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `good_receipt_note`
--

INSERT INTO `good_receipt_note` (`grn_id`, `ju_id`, `sac_par_table`, `sac_par_id`, `space_occupied`, `location`, `validity`, `created_date`, `status`) VALUES
(1, 1, 'sac', 1, '1', '1', '1', '2017-05-09 02:41:47', 'created'),
(2, 2, 'sac', 1, '1', '2221', '11', '2017-07-03 17:38:41', 'created'),
(3, 2, 'sac', 1, '1', '2221', '11', '2017-07-03 17:39:12', 'created'),
(4, 2, 'sac', 1, '1', '2221', '11', '2017-07-03 17:40:00', 'created'),
(5, 2, 'sac', 1, '1', '2221', '11', '2017-07-03 17:40:45', 'created'),
(6, 3, 'sac', 1, '1', '2221', '11', '2017-07-03 17:58:10', 'created'),
(7, 6, 'par', 2, '1', '2221', '11', '2017-07-03 17:58:17', 'created'),
(8, 6, 'par', 2, '1', '2221', '11', '2017-07-03 17:59:17', 'created');

-- --------------------------------------------------------

--
-- Table structure for table `igp_loading`
--

CREATE TABLE `igp_loading` (
  `igp_lo_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(50) NOT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driving_license` varchar(50) DEFAULT NULL,
  `time_in` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'igp_created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `igp_loading`
--

INSERT INTO `igp_loading` (`igp_lo_id`, `entry_date`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `time_in`, `status`) VALUES
(1, '0000-00-00', 'pdr_id', '1', '1', '1', '1', '0:43:06', 'igp_created'),
(2, '0000-00-00', 'boe_number', '445533', 'uuyjkk', 'raamm', '77yuu5vh', '1:38:17', 'igp_created'),
(3, '0000-00-00', 'pdr_id', '1', 'gghh', 'gtghjujs', 'kkksl', '1:40:06', 'igp_created');

-- --------------------------------------------------------

--
-- Table structure for table `igp_unloading`
--

CREATE TABLE `igp_unloading` (
  `igp_un_id` int(11) NOT NULL,
  `sac_par_table` varchar(20) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(100) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `driving_license` varchar(100) NOT NULL,
  `container_number` varchar(100) NOT NULL,
  `seal_number` varchar(100) NOT NULL,
  `entry_date` varchar(50) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `container_condition` varchar(30) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `transporter_name` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `igp_unloading`
--

INSERT INTO `igp_unloading` (`igp_un_id`, `sac_par_table`, `sac_par_id`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `container_number`, `seal_number`, `entry_date`, `time_in`, `container_condition`, `vehicle_type`, `transporter_name`, `status`) VALUES
(4, 'par', 2, 'par', '2', '99', '9', '9', '9', '9', '01-05-2017', '22:28:50', 'Good', '20', '9', 'created'),
(5, 'par', 44, 'par', '44', '1', '1', '1', '774878', '1', '28-06-2017', '0:15:38', 'Good', '20', '1', ''),
(6, 'par', 44, 'par', '44', '1', '1', '1', '937789', '1', '28-06-2017', '0:17:12', 'Good', '20', '1', ''),
(7, 'par', 44, 'par', '44', '1', '1', '1', '', '1', '28-06-2017', '0:18:09', 'Good', '20', '1', ''),
(8, 'par', 44, 'par', '44', '1', '1', '1', '937789', '1', '28-06-2017', '0:21:25', 'Good', '20', '1', ''),
(9, 'sac', 3, 'sac', '3', '1', '1', '1', '11', '1', '28-06-2017', '0:22:55', 'Good', '20', '1', ''),
(10, 'sac', 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(11, 'sac', 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(12, 'sac', 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(13, 'sac', 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(14, 'sac', 4, 'sac', '4', '1', '1', '1', '4', '1', '28-06-2017', '0:32:10', 'Good', '20', '1', ''),
(15, 'sac', 4, 'sac', '4', '1', '2', '1', '1', '1', '28-06-2017', '0:33:40', 'Good', '20', '1', ''),
(16, 'sac', 4, 'customer_name', 'q', '1', '111', '111', '3', '112', '06-07-2017', '0:13:37', 'Good', '40', '223', '');

-- --------------------------------------------------------

--
-- Table structure for table `joborder_unloading`
--

CREATE TABLE `joborder_unloading` (
  `ju_id` int(11) NOT NULL,
  `sac_par_table` varchar(10) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `weight` varchar(100) NOT NULL,
  `no_of_packages` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `supervisor_name` varchar(100) NOT NULL,
  `unloading_type` int(11) NOT NULL,
  `equipment_ref_number` varchar(100) NOT NULL,
  `no_of_labors` varchar(100) NOT NULL,
  `unloading_time` varchar(50) NOT NULL,
  `dimension` varchar(80) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created',
  `exception_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `joborder_unloading`
--

INSERT INTO `joborder_unloading` (`ju_id`, `sac_par_table`, `sac_par_id`, `weight`, `no_of_packages`, `description`, `supervisor_name`, `unloading_type`, `equipment_ref_number`, `no_of_labors`, `unloading_time`, `dimension`, `status`, `exception_id`) VALUES
(1, 'sac', 1, '1', '2', 'box', 'ramu', 2, '45', '2', '30', '20 ft. Container', 'completed', 2),
(2, 'sac', 1, '1', '1', '1', '1', 1, '1', '1', '1', '20 ft. Container', 'created', 0),
(3, 'sac', 1, '1', '1', '1', '1', 1, '1', '1', '1', '20 ft. Container', 'created', 0),
(4, 'par', 1, '12', '12', '123', 'r', 1, '', '23', '123', '20 ft. Container', 'created', 0),
(5, 'par', 5, '100', '3', 'abc', 'xy', 2, '44321', '3', '30', '20 ft. Container', 'exception', 1),
(6, 'par', 2, '23', '1', '1', '1', 2, '1', '1', '1', '20 ft. Container', 'created', 0),
(7, 'par', 1, '3', '3', '34', '3', 1, '1233', '3556', '6', 'LCL', 'created', 0);

-- --------------------------------------------------------

--
-- Table structure for table `party_master`
--

CREATE TABLE `party_master` (
  `pm_id` int(11) NOT NULL,
  `nature_of_business` varchar(100) NOT NULL,
  `name_of_the_company` varchar(200) NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_type` varchar(100) NOT NULL,
  `customer_subtype` varchar(100) NOT NULL,
  `customer_parent` varchar(100) NOT NULL,
  `constitution_type` varchar(100) NOT NULL,
  `address1` varchar(400) NOT NULL,
  `address2` varchar(400) NOT NULL,
  `city_town` varchar(200) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `landline` varchar(150) NOT NULL,
  `fax` varchar(150) NOT NULL,
  `salestax_number` varchar(150) NOT NULL,
  `servicetax_number` varchar(150) NOT NULL,
  `ie_licence` varchar(150) NOT NULL,
  `tan_number` varchar(150) NOT NULL,
  `pan_number` varchar(150) NOT NULL,
  `inactive_from` date NOT NULL,
  `primary_contact_name` varchar(200) NOT NULL,
  `primary_contact_mobile` varchar(20) NOT NULL,
  `primary_contact_email` varchar(100) NOT NULL,
  `secondary_contact_name` varchar(200) NOT NULL,
  `secondary_contact_mobile` varchar(20) NOT NULL,
  `secondary_contact_email` varchar(100) NOT NULL,
  `tertiary_contact_name` varchar(200) NOT NULL,
  `tertiary_contact_mobile` varchar(20) NOT NULL,
  `tertiary_contact_email` varchar(100) NOT NULL,
  `credit_days` varchar(10) NOT NULL,
  `credit_limit` varchar(20) NOT NULL,
  `opening_balance` varchar(20) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pm_active_status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `par_log`
--

CREATE TABLE `par_log` (
  `par_log_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `status_from` varchar(50) NOT NULL,
  `status_to` int(50) NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `par_log`
--

INSERT INTO `par_log` (`par_log_id`, `par_id`, `status_from`, `status_to`, `logged_time`, `remarks`) VALUES
(1, 3, 'Submitted', 0, '2017-04-29 11:56:51', 'PAR Approved'),
(2, 4, 'Submitted', 0, '2017-04-29 11:57:02', 'PAR Rejected'),
(3, 1, 'Submitted', 0, '2017-04-29 12:16:47', 'PAR Approved'),
(4, 3, 'Submitted', 0, '2017-04-29 12:17:40', 'PAR Rejected'),
(5, 3, 'Submitted', 0, '2017-04-29 12:18:10', 'PAR Approved'),
(6, 5, 'Submitted', 0, '2017-04-29 12:19:50', 'PAR Approved'),
(7, 2, 'Submitted', 0, '2017-04-30 09:49:04', 'PAR Approved'),
(8, 2, 'Submitted', 0, '2017-04-30 09:49:32', 'PAR Rejected'),
(9, 2, 'Submitted', 0, '2017-04-30 09:50:06', 'PAR Approved'),
(10, 1, 'Submitted', 0, '2017-06-23 13:34:55', 'PAR Approved'),
(11, 5, 'Submitted', 0, '2017-06-23 13:40:22', 'PAR Approved');

-- --------------------------------------------------------

--
-- Table structure for table `pdr_items`
--

CREATE TABLE `pdr_items` (
  `pdr_item_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `dv_item_id` int(11) NOT NULL,
  `container_number` varchar(50) NOT NULL,
  `sac_par_table` varchar(10) NOT NULL,
  `sac_par_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `despatch_qty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pdr_items`
--

INSERT INTO `pdr_items` (`pdr_item_id`, `pdr_id`, `dv_item_id`, `container_number`, `sac_par_table`, `sac_par_id`, `item_name`, `despatch_qty`) VALUES
(1, 1, 11, '937789', 'par', 44, '334', '25');

-- --------------------------------------------------------

--
-- Table structure for table `pre_arrival_request`
--

CREATE TABLE `pre_arrival_request` (
  `par_id` int(11) NOT NULL,
  `importing_firm_name` varchar(200) NOT NULL,
  `bol_awb_number` varchar(100) NOT NULL,
  `material_name` varchar(200) NOT NULL,
  `packing_nature` varchar(100) NOT NULL,
  `assessable_value` varchar(100) NOT NULL,
  `material_nature` varchar(100) NOT NULL,
  `required_period` varchar(100) NOT NULL,
  `licence_code` varchar(100) NOT NULL,
  `boe_number` varchar(100) NOT NULL,
  `qty_units` varchar(100) NOT NULL,
  `space_requirement` varchar(100) NOT NULL,
  `duty_amount` varchar(100) NOT NULL,
  `expected_date` date NOT NULL,
  `cargo_life` date NOT NULL,
  `shelf_life` date NOT NULL,
  `insurance_by` varchar(50) NOT NULL,
  `client_insurance_copy` varchar(500) NOT NULL,
  `insurance_declaration` varchar(25) NOT NULL,
  `insurance_declaration_copy` varchar(500) NOT NULL,
  `status` varchar(50) NOT NULL,
  `document_verified` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pre_arrival_request`
--

INSERT INTO `pre_arrival_request` (`par_id`, `importing_firm_name`, `bol_awb_number`, `material_name`, `packing_nature`, `assessable_value`, `material_nature`, `required_period`, `licence_code`, `boe_number`, `qty_units`, `space_requirement`, `duty_amount`, `expected_date`, `cargo_life`, `shelf_life`, `insurance_by`, `client_insurance_copy`, `insurance_declaration`, `insurance_declaration_copy`, `status`, `document_verified`) VALUES
(1, 'xyz', 'AWB_2345', 'Jasmine', 'Wooden Crate Bags Cartons', '75000', 'Non Hazardous', '34', 'LN_2345', 'BOE_2345', '5', '5', '7500', '2017-05-06', '2017-05-17', '2017-05-31', 'Client', 'client-insurance-copy/xyz_client_insurance_copy_CCA-ramu Ramasamy.pdf', 'No', '', 'approved', 'yes'),
(2, 'xyz123', 'AWB_2345', 'ram', 'Metal Drum', '100000', 'Hazardous', '5', 'LN_1234', 'BOE_23459', '5', '5', '10000', '2017-05-19', '2017-05-27', '2017-05-26', 'TRLPL', '', 'Yes', 'insurance_declaration_copy/', 'grn_created', 'yes'),
(4, 'abc123', 'AWB_123', 'cotton material', 'Fibre Drum', '200000', 'Non Hazardous', '56', 'LN_2345', 'BOE_123', '12', '12', '20000', '2017-04-30', '2017-04-30', '2017-04-30', 'TRLPL', '', 'No', '', 'rejected', 'yes'),
(5, 'abcd', 'AWB_2345', 'steel', 'Metal Drum', '200000', 'Non Hazardous', '123', 'LN_1234', 'BOE_234501', '4', '4', '20000', '2017-04-30', '2017-04-30', '2017-04-30', 'Client', 'client-insurance-copy/abc_client_insurance_copy_CCA-ramu Ramasamy.pdf', 'Yes', 'insurance_declaration_copy/abc_client_insurance_copy_CCA-ramu Ramasamy.pdf', 'approved', 'no'),
(6, 'q', '122', 'ee', 'Metal Drum', '12231', 'Non Hazardous', '3', '123', '1223', '1', '12', '121', '2017-06-30', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(7, 'q', '122', 'ee', 'Metal Drum', '12231', 'Non Hazardous', '3', '123', '1223', '1', '12', '121', '2017-06-30', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(8, 'q', '122', 'ee', 'Metal Drum', '12231', 'Non Hazardous', '3', '123', '1223', '1', '12', '121', '2017-06-30', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(9, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '3', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(10, 'r', 'r', 'r', 'Metal Drum', '2', 'Non Hazardous', '5', 'r', 'r', 'r', '23', '4', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(11, 'r', 'r', 'r', 'Metal Drum', 'r', 'Non Hazardous', 'w', 'rr', 'r', 'r', 'r', 'r', '2017-06-28', '2017-06-29', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'yes'),
(12, 'r', '112', '11', 'Metal Drum', '11', 'Non Hazardous', '11', '12', '111', '11', '11', '11', '2017-06-28', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(13, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '12', '1', '1', '1', '1', '1', '2017-06-26', '2017-06-29', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(14, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '3', '1', '1', '1', '1', '1', '2017-06-26', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(15, '2', '2', '2', 'Metal Drum', '2', 'Non Hazardous', '2', '2', '2', '2', '2', '2', '2017-06-28', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(16, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '12', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(17, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '12', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(18, 'q', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '4', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(19, 'r', '1', '2', 'Metal Drum', '1', 'Non Hazardous', '1', '1', 'r', '1', '1', '1', '2017-06-30', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(20, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(21, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-28', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(22, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-29', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(23, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-28', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(24, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(25, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-26', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(26, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(27, '11', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-28', '2017-06-29', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(28, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-29', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(29, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(30, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(31, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-29', '2017-06-29', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(32, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-29', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(33, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-29', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(34, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(35, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(36, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-28', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(37, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-29', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(38, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(39, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-29', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(40, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-30', '2017-06-27', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(41, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '11', '1', '1', '1', '1', '1', '2017-06-28', '2017-06-29', '2017-06-26', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(42, '1', '1', '1', 'Metal Drum', '1', 'Non Hazardous', '1', '1', '1', '1', '1', '1', '2017-06-27', '2017-06-29', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(43, 'rams', '112333', '1223', 'Metal Drum', '112', 'Non Hazardous', '34', '112211', '113233', '1123', '1122', '223', '2017-06-29', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'submitted', 'no'),
(44, 'rr', 'rr', 'rr', 'Metal Drum', 'rr', 'Non Hazardous', '1', 'rr', 'rr', 'rr', 'rr', 'rr', '2017-06-27', '2017-06-30', '2017-06-28', 'TRLPL', '', 'No', '', 'approved', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sac_log`
--

CREATE TABLE `sac_log` (
  `sac_log_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `status_from` varchar(50) NOT NULL,
  `status_to` varchar(50) NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sac_log`
--

INSERT INTO `sac_log` (`sac_log_id`, `sac_id`, `status_from`, `status_to`, `logged_time`, `remarks`) VALUES
(1, 1, 'Submitted', 'Rejected', '2017-04-29 11:46:20', 'SAC Rejected'),
(2, 1, 'Submitted', 'Approved', '2017-04-29 11:46:39', 'SAC Approved'),
(3, 1, 'Submitted', 'Approved', '2017-06-23 13:25:37', 'SAC Approved'),
(4, 1, 'Submitted', 'Approved', '2017-06-23 13:25:55', 'SAC Approved'),
(5, 1, 'Submitted', 'Approved', '2017-06-23 13:26:45', 'SAC Approved'),
(6, 1, 'Submitted', 'Approved', '2017-06-23 13:27:35', 'SAC Approved'),
(7, 1, 'Submitted', 'Rejected', '2017-06-23 13:28:34', 'SAC Rejected'),
(8, 1, 'Submitted', 'Approved', '2017-06-23 13:30:58', 'SAC Approved'),
(9, 1, 'Submitted', 'Approved', '2017-06-23 13:31:19', 'SAC Approved'),
(10, 1, 'Submitted', 'Rejected', '2017-06-23 13:32:52', 'SAC Rejected'),
(11, 1, 'Submitted', 'Approved', '2017-06-23 13:33:04', 'SAC Approved'),
(12, 1, 'Submitted', 'Approved', '2017-06-23 13:34:10', 'SAC Approved'),
(13, 1, 'Submitted', 'Rejected', '2017-06-23 13:36:49', 'SAC Rejected');

-- --------------------------------------------------------

--
-- Table structure for table `sac_par_container_info`
--

CREATE TABLE `sac_par_container_info` (
  `container_info_id` int(11) NOT NULL,
  `dimension` varchar(100) NOT NULL,
  `container_count` int(11) NOT NULL,
  `container_details` varchar(1000) NOT NULL,
  `id` int(11) NOT NULL,
  `added_from` varchar(30) NOT NULL,
  `igp_status` varchar(50) NOT NULL DEFAULT 'notgenerated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sac_par_container_info`
--

INSERT INTO `sac_par_container_info` (`container_info_id`, `dimension`, `container_count`, `container_details`, `id`, `added_from`, `igp_status`) VALUES
(3, '20 ft. Container', 0, '9894', 1, 'sac', 'notgenerated'),
(4, 'Break Bulk/ODC', 0, '4545', 1, 'sac', 'notgenerated'),
(9, 'Break Bulk/ODC', 0, '3424', 3, 'par', 'notgenerated'),
(23, 'LCL', 0, '4444', 1, 'par', 'notgenerated'),
(24, '40 ft. Container', 0, '6544', 5, 'par', 'notgenerated'),
(25, '20 ft. Container', 0, '1233', 2, 'par', 'notgenerated'),
(26, '20 ft. Container', 0, '1234', 2, 'par', 'notgenerated'),
(28, '40 ft. Container', 2, '{\"0\":{\"container_number\":\"1\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"1\",\"status\":\"not_picked\"}}', 1, 'par', 'notgenerated'),
(31, '20 ft. Container', 2, '{\"0\":{\"container_number\":\"4355\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"774878\",\"status\":\"not_picked\"},\"2\":{\"container_number\":\"937789\",\"status\":\"picked\"},\"3\":{\"container_number\":\"998783\",\"status\":\"not_picked\"}}', 44, 'par', 'notgenerated'),
(32, 'LCL', 4, '{\"0\":{\"container_number\":\"4355\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"774878\",\"status\":\"not_picked\"},\"2\":{\"container_number\":\"937789\",\"status\":\"picked\"},\"3\":{\"container_number\":\"998783\",\"status\":\"not_picked\"}}', 44, 'par', 'notgenerated'),
(33, '40 ft. Container', 2, '{\"0\":{\"container_number\":\"11\",\"status\":\"picked\"},\"1\":{\"container_number\":\"22\",\"status\":\"not_picked\"}}', 3, 'sac', 'notgenerated'),
(34, 'Break Bulk/ODC', 2, '{\"0\":{\"container_number\":\"11\",\"status\":\"picked\"},\"1\":{\"container_number\":\"22\",\"status\":\"not_picked\"}}', 3, 'sac', 'notgenerated'),
(35, '20 ft. Container', 2, '{\"0\":{\"container_number\":\"1\",\"status\":\"picked\"},\"1\":{\"container_number\":\"2\",\"status\":\"not_picked\"}}', 4, 'sac', 'notgenerated'),
(36, '40 ft. Container', 3, '{\"0\":{\"container_number\":\"3\",\"status\":\"picked\"},\"1\":{\"container_number\":\"4\",\"status\":\"picked\"},\"2\":{\"container_number\":\"5\",\"status\":\"not_picked\"}}', 4, 'sac', 'notgenerated'),
(37, 'Break Bulk/ODC', 4, '{\"0\":{\"container_number\":\"6\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"7\",\"status\":\"not_picked\"},\"2\":{\"container_number\":\"8\",\"status\":\"not_picked\"},\"3\":{\"container_number\":\"9\",\"status\":\"not_picked\"}}', 4, 'sac', 'notgenerated'),
(38, 'LCL', 5, '{\"0\":{\"container_number\":\"10\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"11\",\"status\":\"not_picked\"},\"2\":{\"container_number\":\"12\",\"status\":\"not_picked\"},\"3\":{\"container_number\":\"13\",\"status\":\"not_picked\"},\"4\":{\"container_number\":\"14\",\"status\":\"picked\"}}', 4, 'sac', 'notgenerated'),
(39, '20 ft. Container', 2, '{\"0\":{\"container_number\":\"1\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"2\",\"status\":\"not_picked\"}}', 1, 'sac', 'notgenerated');

-- --------------------------------------------------------

--
-- Table structure for table `sac_request`
--

CREATE TABLE `sac_request` (
  `sac_id` int(11) NOT NULL,
  `importing_firm_name` varchar(300) NOT NULL,
  `licence_code` varchar(200) NOT NULL,
  `bol_awb_number` varchar(200) NOT NULL,
  `boe_number` varchar(200) NOT NULL,
  `material_name` varchar(200) NOT NULL,
  `qty_units` int(11) NOT NULL,
  `packing_nature` varchar(100) NOT NULL,
  `space_requirement` varchar(100) NOT NULL,
  `assessable_value` varchar(100) NOT NULL,
  `duty_amount` varchar(100) NOT NULL,
  `material_nature` varchar(100) NOT NULL,
  `expected_date` date NOT NULL,
  `required_period` varchar(100) NOT NULL,
  `insurance_by` varchar(50) NOT NULL,
  `status` varchar(100) NOT NULL,
  `document_verified` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sac_request`
--

INSERT INTO `sac_request` (`sac_id`, `importing_firm_name`, `licence_code`, `bol_awb_number`, `boe_number`, `material_name`, `qty_units`, `packing_nature`, `space_requirement`, `assessable_value`, `duty_amount`, `material_nature`, `expected_date`, `required_period`, `insurance_by`, `status`, `document_verified`) VALUES
(1, 'ABC123', 'LN_1234', 'AWB_123', 'BOE_12378', 'Lilly', 4, 'Wooden Crate Bags Cartons', '4', '50000', '5000', 'Non Hazardous', '2017-04-30', '2017-04-30', 'TRLPL', 'grn_created', 'yes'),
(2, '1', '1', '1', '1', '1', 1, 'Metal Drum', '1', '1', '1', 'Non Hazardous', '2017-06-27', '1', 'TRLPL', 'submitted', 'no'),
(3, '1', '1', '1', '1', '1', 1, 'Metal Drum', '1', '1', '1', 'Non Hazardous', '2017-06-27', '1', 'TRLPL', 'approved', 'yes'),
(4, 'q', 'q', 'q', 'q', 'q', 0, 'Metal Drum', 'q', 'q', 'q', 'Non Hazardous', '2017-06-28', 'q', 'TRLPL', 'approved', 'yes'),
(5, 'q', 'q', 'q', 'q', 'q', 0, 'Metal Drum', 'q', 'q', 'q', 'Non Hazardous', '2017-07-26', 'q', 'TRLPL', 'submitted', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_login`
--
ALTER TABLE `client_login`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `despatch_request`
--
ALTER TABLE `despatch_request`
  ADD PRIMARY KEY (`pdr_id`);

--
-- Indexes for table `document_verification`
--
ALTER TABLE `document_verification`
  ADD PRIMARY KEY (`do_ver_id`);

--
-- Indexes for table `dv_items`
--
ALTER TABLE `dv_items`
  ADD PRIMARY KEY (`dv_item_id`);

--
-- Indexes for table `exception`
--
ALTER TABLE `exception`
  ADD PRIMARY KEY (`exception_id`);

--
-- Indexes for table `good_receipt_note`
--
ALTER TABLE `good_receipt_note`
  ADD PRIMARY KEY (`grn_id`);

--
-- Indexes for table `igp_loading`
--
ALTER TABLE `igp_loading`
  ADD PRIMARY KEY (`igp_lo_id`);

--
-- Indexes for table `igp_unloading`
--
ALTER TABLE `igp_unloading`
  ADD PRIMARY KEY (`igp_un_id`);

--
-- Indexes for table `joborder_unloading`
--
ALTER TABLE `joborder_unloading`
  ADD PRIMARY KEY (`ju_id`);

--
-- Indexes for table `party_master`
--
ALTER TABLE `party_master`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `par_log`
--
ALTER TABLE `par_log`
  ADD PRIMARY KEY (`par_log_id`);

--
-- Indexes for table `pdr_items`
--
ALTER TABLE `pdr_items`
  ADD PRIMARY KEY (`pdr_item_id`);

--
-- Indexes for table `pre_arrival_request`
--
ALTER TABLE `pre_arrival_request`
  ADD PRIMARY KEY (`par_id`);

--
-- Indexes for table `sac_log`
--
ALTER TABLE `sac_log`
  ADD PRIMARY KEY (`sac_log_id`);

--
-- Indexes for table `sac_par_container_info`
--
ALTER TABLE `sac_par_container_info`
  ADD PRIMARY KEY (`container_info_id`);

--
-- Indexes for table `sac_request`
--
ALTER TABLE `sac_request`
  ADD PRIMARY KEY (`sac_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_login`
--
ALTER TABLE `client_login`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `despatch_request`
--
ALTER TABLE `despatch_request`
  MODIFY `pdr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `document_verification`
--
ALTER TABLE `document_verification`
  MODIFY `do_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `dv_items`
--
ALTER TABLE `dv_items`
  MODIFY `dv_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `exception`
--
ALTER TABLE `exception`
  MODIFY `exception_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `good_receipt_note`
--
ALTER TABLE `good_receipt_note`
  MODIFY `grn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `igp_loading`
--
ALTER TABLE `igp_loading`
  MODIFY `igp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `igp_unloading`
--
ALTER TABLE `igp_unloading`
  MODIFY `igp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `joborder_unloading`
--
ALTER TABLE `joborder_unloading`
  MODIFY `ju_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `party_master`
--
ALTER TABLE `party_master`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `par_log`
--
ALTER TABLE `par_log`
  MODIFY `par_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pdr_items`
--
ALTER TABLE `pdr_items`
  MODIFY `pdr_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pre_arrival_request`
--
ALTER TABLE `pre_arrival_request`
  MODIFY `par_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `sac_log`
--
ALTER TABLE `sac_log`
  MODIFY `sac_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `sac_par_container_info`
--
ALTER TABLE `sac_par_container_info`
  MODIFY `container_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `sac_request`
--
ALTER TABLE `sac_request`
  MODIFY `sac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
