-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2017 at 08:42 PM
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
-- Table structure for table `bonded_despatch_request`
--

CREATE TABLE `bonded_despatch_request` (
  `pdr_id` int(11) NOT NULL,
  `bond_number` varchar(50) NOT NULL,
  `sac_id` int(11) NOT NULL,
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
  `document_verified` varchar(10) NOT NULL DEFAULT 'no',
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_despatch_request`
--

INSERT INTO `bonded_despatch_request` (`pdr_id`, `bond_number`, `sac_id`, `client_web`, `cha_name`, `order_number`, `boe_number`, `exbond_be_number`, `exbond_be_date`, `customs_officer_name`, `number_of_packages`, `assessment_value`, `duty_value`, `transporter_name`, `document_verified`, `status`) VALUES
(1, '6674', 44, 'Reexport', 'Rams International', '99891', '34345', '1234', '2017-07-19', 'Ron', 3, '3000000', '280000', 'Siddha', 'yes', 'joborder_completed'),
(2, 'q12', 6, 'Debond', '1', '1', '1', '1', '2017-07-25', '1', 1, '1', '1', '1', 'no', 'approved'),
(3, 'q12', 6, 'Transfer Bond', 'wtty', 'w', 'w', 'q', '2017-07-24', 'a', 0, 'a', 'a', 'a', 'yes', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_dv_inward`
--

CREATE TABLE `bonded_dv_inward` (
  `do_ver_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_dv_inward`
--

INSERT INTO `bonded_dv_inward` (`do_ver_id`, `sac_id`, `cfs_name`, `customs_officer_name`, `do_number`, `do_date`, `bond_number`, `bond_date`, `do_issued_by`, `weight`, `no_of_packages`, `description`, `invoice_copy`, `packing_list`, `boe_copy`, `bond_order`, `do_verification`) VALUES
(1, 7, 'Dummy123', 'Dummy', '11223344', '2017-07-31', '12334', '2017-07-28', 'trlpl', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'yes'),
(2, 6, 'www', 'ww', 'wsee', '2017-07-26', 'q12', '2017-07-17', '45f', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_dv_items`
--

CREATE TABLE `bonded_dv_items` (
  `dv_item_id` int(11) NOT NULL,
  `container_number` int(11) DEFAULT NULL,
  `sac_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `assessable_value` varchar(50) NOT NULL,
  `duty_value` varchar(50) NOT NULL,
  `insurance_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_dv_items`
--

INSERT INTO `bonded_dv_items` (`dv_item_id`, `container_number`, `sac_id`, `item_name`, `item_qty`, `assessable_value`, `duty_value`, `insurance_value`) VALUES
(1, NULL, 1, 'a', 0, '1', '1', '2'),
(2, NULL, 1, 'b', 0, '2', '2', '4'),
(3, NULL, 1, 'c', 0, '3', '3', '6'),
(4, NULL, 2, '', 0, '', '', ''),
(5, NULL, 4, '', 0, '', '', ''),
(6, NULL, 4, '', 0, '', '', ''),
(7, 6644556, 44, 'dummy', 0, '1', '1', '2'),
(8, 937789, 44, 'dummy 2', 0, '2', '2', '4'),
(9, 0, 11, '', 0, '', '', ''),
(10, 4355, 44, 'Wood', 23, '1', '1', '2'),
(11, 937789, 44, 'Box', 34, '2', '2', '4'),
(12, 0, 6, 'qq', 1, '1', '1', '1'),
(13, 0, 5, '', 0, '', '', ''),
(14, 0, 2, '', 0, '', '', ''),
(15, 0, 6, '11233', 22, '22', '44', '44');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_dv_outward`
--

CREATE TABLE `bonded_dv_outward` (
  `dv_ver_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `exbond_original` varchar(10) NOT NULL DEFAULT 'no',
  `exboe_original` varchar(10) NOT NULL DEFAULT 'no',
  `order_number` varchar(10) NOT NULL DEFAULT 'no',
  `vehicle_number` varchar(10) NOT NULL DEFAULT 'no',
  `license_number` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_dv_outward`
--

INSERT INTO `bonded_dv_outward` (`dv_ver_id`, `pdr_id`, `exbond_original`, `exboe_original`, `order_number`, `vehicle_number`, `license_number`) VALUES
(1, 1, 'no', 'no', 'no', 'no', 'no'),
(2, 1, 'no', 'no', 'no', 'no', 'no'),
(3, 1, 'no', 'no', 'yes', 'no', 'no'),
(4, 1, 'yes', 'yes', 'yes', 'yes', 'yes'),
(5, 1, 'no', 'yes', 'no', 'yes', 'no'),
(6, 2, 'no', 'no', 'no', 'yes', 'no'),
(7, 1, 'no', 'no', 'no', 'yes', 'yes'),
(8, 3, 'no', 'no', 'no', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_exception`
--

CREATE TABLE `bonded_exception` (
  `exception_id` int(11) NOT NULL,
  `exception_type` varchar(50) NOT NULL,
  `exception_subtype` varchar(50) NOT NULL,
  `exception_remarks` varchar(500) NOT NULL,
  `exception_closingremarks` varchar(500) NOT NULL,
  `exception_status` varchar(50) NOT NULL DEFAULT 'created',
  `exception_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_exception`
--

INSERT INTO `bonded_exception` (`exception_id`, `exception_type`, `exception_subtype`, `exception_remarks`, `exception_closingremarks`, `exception_status`, `exception_time`) VALUES
(2, 'joborder_unloading', 'damage', '3', 'rectified', '', '2017-05-06 05:06:12'),
(3, 'joborder_unloading', 'excess', '2 excess', '', 'created', '2017-05-06 05:34:12'),
(4, 'joborder_unloading', 'damage', 'heavy damage', '', 'created', '2017-07-19 02:08:14'),
(5, 'joborder_unloading', 'damage', 'heavy', '', 'created', '2017-07-19 02:09:09'),
(6, 'joborder_unloading', 'damage', 'heavy damage', 'deone', 'complete', '2017-07-19 02:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_good_receipt_note`
--

CREATE TABLE `bonded_good_receipt_note` (
  `grn_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `space_occupied` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `validity` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_good_receipt_note`
--

INSERT INTO `bonded_good_receipt_note` (`grn_id`, `ju_id`, `sac_id`, `space_occupied`, `location`, `validity`, `created_date`, `status`) VALUES
(6, 3, 1, '50', '2221', '11', '2017-07-08 20:30:53', 'created'),
(7, 6, 2, '60', '2221', '11', '2017-07-08 20:30:59', 'created'),
(9, 8, 44, '70', 'tnagar', '70', '2017-07-08 20:31:02', 'created'),
(10, 8, 6, '35', 'anna nagar', '5', '2017-07-19 16:17:41', 'created');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_igp_loading`
--

CREATE TABLE `bonded_igp_loading` (
  `igp_lo_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `entry_date` date NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(50) NOT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driving_license` varchar(50) DEFAULT NULL,
  `time_in` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'igp_created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_igp_loading`
--

INSERT INTO `bonded_igp_loading` (`igp_lo_id`, `pdr_id`, `entry_date`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `time_in`, `status`) VALUES
(1, 1, '2017-07-09', 'pdr_id', '1', 'TN 38 AJ 0784', 'Ram', '3498721114', '15:16:44', 'joborder_completed'),
(2, 3, '2017-07-19', 'pdr_id', '3', '1234', '1223', '11223', '21:06:53', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_igp_unloading`
--

CREATE TABLE `bonded_igp_unloading` (
  `igp_un_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
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
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_igp_unloading`
--

INSERT INTO `bonded_igp_unloading` (`igp_un_id`, `sac_id`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `container_number`, `seal_number`, `entry_date`, `time_in`, `container_condition`, `vehicle_type`, `transporter_name`, `status`) VALUES
(4, 2, 'par', '2', '99', '9', '9', '9', '9', '01-05-2017', '22:28:50', 'Good', '20', '9', 'created'),
(10, 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(11, 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(12, 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(13, 4, 'sac', '4', '1', '1', '1', '14', '1', '28-06-2017', '0:28:04', 'Good', '20', '1', ''),
(14, 4, 'sac', '4', '1', '1', '1', '4', '1', '28-06-2017', '0:32:10', 'Good', '20', '1', ''),
(15, 4, 'sac', '4', '1', '2', '1', '1', '1', '28-06-2017', '0:33:40', 'Good', '20', '1', ''),
(16, 4, 'customer_name', 'q', '1', '111', '111', '3', '112', '06-07-2017', '0:13:37', 'Good', '40', '223', ''),
(17, 44, 'par', '44', 'TN 10 AB 1233', 'qwerty', '1122', '774878', '67', '08-07-2017', '20:35:53', 'Good', 'Break Bulk', '11', 'joborder_completed'),
(18, 3, 'sac', '3', '2345', 'sac-igp-vehicle num', '1123', '112233', '123', '19-07-2017', '0:18:02', 'Good', '20', '11223', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_joborder_loading`
--

CREATE TABLE `bonded_joborder_loading` (
  `jl_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `space_occupied_after` varchar(50) NOT NULL,
  `supervisor_name` varchar(50) NOT NULL,
  `loading_type` int(11) NOT NULL,
  `equipment_ref_number` varchar(50) NOT NULL,
  `no_of_labors` varchar(10) NOT NULL,
  `loading_time` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_joborder_loading`
--

INSERT INTO `bonded_joborder_loading` (`jl_id`, `pdr_id`, `space_occupied_after`, `supervisor_name`, `loading_type`, `equipment_ref_number`, `no_of_labors`, `loading_time`, `status`) VALUES
(1, 1, '15', 'Ram', 3, '11443123', '2', '1 hour', 'completed'),
(2, 3, '25', 'rewwr', 2, '1234', '2', '2', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_joborder_unloading`
--

CREATE TABLE `bonded_joborder_unloading` (
  `ju_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_joborder_unloading`
--

INSERT INTO `bonded_joborder_unloading` (`ju_id`, `sac_id`, `weight`, `no_of_packages`, `description`, `supervisor_name`, `unloading_type`, `equipment_ref_number`, `no_of_labors`, `unloading_time`, `dimension`, `status`, `exception_id`) VALUES
(1, 1, '1', '2', 'box', 'ramu', 2, '45', '2', '30', '20 ft. Container', 'completed', 2),
(5, 5, '100', '3', 'abc', 'xy', 2, '44321', '3', '30', '20 ft. Container', 'exception', 1),
(6, 2, '23', '1', '1', '1', 2, '1', '1', '1', '20 ft. Container', 'created', 0),
(7, 44, '3', '3', '34', '3', 1, '1233', '3556', '6', 'LCL', 'completed', 0),
(8, 3, '300', '2', '1122', '112', 4, '12', '12', '3', '40 ft. Container', 'completed', 6);

-- --------------------------------------------------------

--
-- Table structure for table `bonded_ogp_loading`
--

CREATE TABLE `bonded_ogp_loading` (
  `ogp_lo_id` int(11) NOT NULL,
  `jl_id` int(11) NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_ogp_loading`
--

INSERT INTO `bonded_ogp_loading` (`ogp_lo_id`, `jl_id`, `exit_time`, `status`) VALUES
(1, 1, '2017-07-09 17:53:27', 'completed'),
(2, 2, '2017-07-19 21:54:03', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_ogp_unloading`
--

CREATE TABLE `bonded_ogp_unloading` (
  `ogp_un_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_ogp_unloading`
--

INSERT INTO `bonded_ogp_unloading` (`ogp_un_id`, `ju_id`, `exit_time`, `status`) VALUES
(1, 7, '2017-07-09 17:57:19', 'completed'),
(2, 8, '2017-07-19 07:59:02', 'completed'),
(3, 8, '2017-07-19 07:59:05', 'completed'),
(4, 8, '2017-07-19 07:58:38', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `bonded_pdr_items`
--

CREATE TABLE `bonded_pdr_items` (
  `pdr_item_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `dv_item_id` int(11) NOT NULL,
  `container_number` varchar(50) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `despatch_qty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `bonded_pdr_items`
--

INSERT INTO `bonded_pdr_items` (`pdr_item_id`, `pdr_id`, `dv_item_id`, `container_number`, `sac_id`, `item_name`, `despatch_qty`) VALUES
(7, 3, 15, '0', 6, '11233', '20');

-- --------------------------------------------------------

--
-- Table structure for table `general_despatch_request`
--

CREATE TABLE `general_despatch_request` (
  `pdr_id` int(11) NOT NULL,
  `bond_number` varchar(50) NOT NULL,
  `par_id` int(11) NOT NULL,
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
  `document_verified` varchar(10) NOT NULL DEFAULT 'no',
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `general_despatch_request`
--

INSERT INTO `general_despatch_request` (`pdr_id`, `bond_number`, `par_id`, `client_web`, `cha_name`, `order_number`, `boe_number`, `exbond_be_number`, `exbond_be_date`, `customs_officer_name`, `number_of_packages`, `assessment_value`, `duty_value`, `transporter_name`, `document_verified`, `status`) VALUES
(1, '123', 3, 'Debond', '123', '1111', '1111', '1111', '2017-07-12', '1111', 111, '111', '1111', '1111', 'yes', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_dv_inward`
--

CREATE TABLE `general_dv_inward` (
  `do_ver_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `general_dv_inward`
--

INSERT INTO `general_dv_inward` (`do_ver_id`, `par_id`, `cfs_name`, `customs_officer_name`, `do_number`, `do_date`, `bond_number`, `bond_date`, `do_issued_by`, `weight`, `no_of_packages`, `description`, `invoice_copy`, `packing_list`, `boe_copy`, `bond_order`, `do_verification`) VALUES
(1, 3, 'ABC', 'ram', '212', '2017-07-26', '123', '2017-07-13', '122', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `general_dv_items`
--

CREATE TABLE `general_dv_items` (
  `dv_item_id` int(11) NOT NULL,
  `container_number` int(11) DEFAULT NULL,
  `par_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `assessable_value` varchar(50) NOT NULL,
  `duty_value` varchar(50) NOT NULL,
  `insurance_value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_dv_items`
--

INSERT INTO `general_dv_items` (`dv_item_id`, `container_number`, `par_id`, `item_name`, `item_qty`, `assessable_value`, `duty_value`, `insurance_value`) VALUES
(1, 123, 3, 'abc', 12, '12', '12', '24');

-- --------------------------------------------------------

--
-- Table structure for table `general_dv_outward`
--

CREATE TABLE `general_dv_outward` (
  `dv_ver_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `exbond_original` varchar(10) NOT NULL DEFAULT 'no',
  `exboe_original` varchar(10) NOT NULL DEFAULT 'no',
  `order_number` varchar(10) NOT NULL DEFAULT 'no',
  `vehicle_number` varchar(10) NOT NULL DEFAULT 'no',
  `license_number` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_dv_outward`
--

INSERT INTO `general_dv_outward` (`dv_ver_id`, `pdr_id`, `exbond_original`, `exboe_original`, `order_number`, `vehicle_number`, `license_number`) VALUES
(1, 1, 'no', 'no', 'yes', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `general_exception`
--

CREATE TABLE `general_exception` (
  `exception_id` int(11) NOT NULL,
  `exception_type` varchar(50) NOT NULL,
  `exception_subtype` varchar(50) NOT NULL,
  `exception_remarks` varchar(500) NOT NULL,
  `exception_closingremarks` varchar(500) NOT NULL,
  `exception_status` varchar(50) NOT NULL DEFAULT 'created',
  `exception_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_exception`
--

INSERT INTO `general_exception` (`exception_id`, `exception_type`, `exception_subtype`, `exception_remarks`, `exception_closingremarks`, `exception_status`, `exception_time`) VALUES
(1, 'joborder_unloading', 'damage', 'heavy damage', 'resolved', 'complete', '2017-07-20 02:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `general_good_receipt_note`
--

CREATE TABLE `general_good_receipt_note` (
  `grn_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `space_occupied` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `validity` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_good_receipt_note`
--

INSERT INTO `general_good_receipt_note` (`grn_id`, `ju_id`, `par_id`, `space_occupied`, `location`, `validity`, `created_date`, `status`) VALUES
(6, 3, 1, '50', '2221', '11', '2017-07-08 20:30:53', 'created'),
(7, 6, 2, '60', '2221', '11', '2017-07-08 20:30:59', 'created'),
(9, 8, 44, '70', 'tnagar', '70', '2017-07-08 20:31:02', 'created'),
(12, 2, 3, '50', 'tnagar', '30', '2017-07-20 02:52:29', 'created');

-- --------------------------------------------------------

--
-- Table structure for table `general_igp_loading`
--

CREATE TABLE `general_igp_loading` (
  `igp_lo_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
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
-- Dumping data for table `general_igp_loading`
--

INSERT INTO `general_igp_loading` (`igp_lo_id`, `pdr_id`, `entry_date`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `time_in`, `status`) VALUES
(1, 1, '2017-07-20', 'pdr_id', '1', 'TN 38 AJ 0784', 'Ram', '1234', '23:50:37', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_igp_unloading`
--

CREATE TABLE `general_igp_unloading` (
  `igp_un_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
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
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_igp_unloading`
--

INSERT INTO `general_igp_unloading` (`igp_un_id`, `par_id`, `data_type`, `data_value`, `vehicle_number`, `driver_name`, `driving_license`, `container_number`, `seal_number`, `entry_date`, `time_in`, `container_condition`, `vehicle_type`, `transporter_name`, `status`) VALUES
(1, 3, 'par', '3', '9894', 'Ram', '11226677889944', '11223', '23', '20-07-2017', '6:59:52', 'Good', '20', 'KPN', 'joborder_completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_joborder_loading`
--

CREATE TABLE `general_joborder_loading` (
  `jl_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `space_occupied_after` varchar(50) NOT NULL,
  `supervisor_name` varchar(50) NOT NULL,
  `loading_type` int(11) NOT NULL,
  `equipment_ref_number` varchar(50) NOT NULL,
  `no_of_labors` varchar(10) NOT NULL,
  `loading_time` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_joborder_loading`
--

INSERT INTO `general_joborder_loading` (`jl_id`, `pdr_id`, `space_occupied_after`, `supervisor_name`, `loading_type`, `equipment_ref_number`, `no_of_labors`, `loading_time`, `status`) VALUES
(1, 1, '123', 'ram', 2, '677554', '3', '1 hour', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_joborder_unloading`
--

CREATE TABLE `general_joborder_unloading` (
  `ju_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
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
-- Dumping data for table `general_joborder_unloading`
--

INSERT INTO `general_joborder_unloading` (`ju_id`, `par_id`, `weight`, `no_of_packages`, `description`, `supervisor_name`, `unloading_type`, `equipment_ref_number`, `no_of_labors`, `unloading_time`, `dimension`, `status`, `exception_id`) VALUES
(1, 1, '50', '30', 'dummy', 'ram', 3, '677554', '3', '3', '40 ft. Container', 'completed', 1),
(2, 3, '67', '12', 'jj', 'j', 1, '12', '12', '1', '40 ft. Container', 'created', 0);

-- --------------------------------------------------------

--
-- Table structure for table `general_ogp_loading`
--

CREATE TABLE `general_ogp_loading` (
  `ogp_lo_id` int(11) NOT NULL,
  `jl_id` int(11) NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_ogp_loading`
--

INSERT INTO `general_ogp_loading` (`ogp_lo_id`, `jl_id`, `exit_time`, `status`) VALUES
(2, 1, '2017-07-21 00:10:54', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_ogp_unloading`
--

CREATE TABLE `general_ogp_unloading` (
  `ogp_un_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_ogp_unloading`
--

INSERT INTO `general_ogp_unloading` (`ogp_un_id`, `ju_id`, `exit_time`, `status`) VALUES
(1, 7, '2017-07-09 17:57:19', 'completed'),
(3, 2, '2017-07-20 08:04:52', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `general_pdr_items`
--

CREATE TABLE `general_pdr_items` (
  `pdr_item_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `dv_item_id` int(11) NOT NULL,
  `container_number` varchar(50) NOT NULL,
  `par_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `despatch_qty` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `general_pdr_items`
--

INSERT INTO `general_pdr_items` (`pdr_item_id`, `pdr_id`, `dv_item_id`, `container_number`, `par_id`, `item_name`, `despatch_qty`) VALUES
(1, 1, 1, '123', 3, 'abc', '10');

-- --------------------------------------------------------

--
-- Table structure for table `item_master`
--

CREATE TABLE `item_master` (
  `item_master_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `item_master`
--

INSERT INTO `item_master` (`item_master_id`, `item_name`, `type_id`) VALUES
(9, 'Varnish', 11),
(10, 'dum', 11),
(11, 'paru', 11),
(12, 'parm', 11);

-- --------------------------------------------------------

--
-- Table structure for table `party_master`
--

CREATE TABLE `party_master` (
  `pm_id` int(11) NOT NULL,
  `pm_uuid` varchar(255) NOT NULL,
  `pm_customerName` varchar(150) DEFAULT NULL,
  `pm_type` varchar(100) NOT NULL,
  `pm_subtype` varchar(100) NOT NULL,
  `pm_address1` varchar(200) DEFAULT NULL,
  `pm_address2` varchar(200) NOT NULL,
  `pm_cityTown` varchar(150) DEFAULT NULL,
  `pm_state` varchar(150) DEFAULT NULL,
  `pm_pin` int(100) DEFAULT NULL,
  `pm_landline` varchar(150) DEFAULT NULL,
  `pm_fax` varchar(150) DEFAULT NULL,
  `pm_sales` varchar(150) DEFAULT NULL,
  `pm_servicesTax` varchar(150) DEFAULT NULL,
  `pm_licence` varchar(150) DEFAULT NULL,
  `pm_tan` varchar(150) DEFAULT NULL,
  `pm_pan` varchar(150) DEFAULT NULL,
  `pm_doc` varchar(150) DEFAULT NULL,
  `pm_sd` varchar(150) DEFAULT NULL,
  `pm_inactive` date DEFAULT NULL,
  `pm_primaryContact` varchar(150) DEFAULT NULL,
  `pm_primaryContactMobile` varchar(150) DEFAULT NULL,
  `pm_primaryContactEmail` varchar(200) DEFAULT NULL,
  `pm_secondaryContact` varchar(150) DEFAULT NULL,
  `pm_secondaryContactMobile` varchar(150) DEFAULT NULL,
  `pm_secondaryContactEmail` varchar(200) DEFAULT NULL,
  `pm_tertiaryContact` varchar(150) NOT NULL,
  `pm_tertiaryContactMobile` varchar(150) NOT NULL,
  `pm_tertiaryContactEmail` varchar(150) NOT NULL,
  `pm_ccd` varchar(200) DEFAULT NULL,
  `pm_ccLimit` varchar(150) DEFAULT NULL,
  `pm_ccBalance` varchar(150) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pm_active_status` enum('YES','NO') DEFAULT 'YES'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `party_master`
--

INSERT INTO `party_master` (`pm_id`, `pm_uuid`, `pm_customerName`, `pm_type`, `pm_subtype`, `pm_address1`, `pm_address2`, `pm_cityTown`, `pm_state`, `pm_pin`, `pm_landline`, `pm_fax`, `pm_sales`, `pm_servicesTax`, `pm_licence`, `pm_tan`, `pm_pan`, `pm_doc`, `pm_sd`, `pm_inactive`, `pm_primaryContact`, `pm_primaryContactMobile`, `pm_primaryContactEmail`, `pm_secondaryContact`, `pm_secondaryContactMobile`, `pm_secondaryContactEmail`, `pm_tertiaryContact`, `pm_tertiaryContactMobile`, `pm_tertiaryContactEmail`, `pm_ccd`, `pm_ccLimit`, `pm_ccBalance`, `created_date`, `pm_active_status`) VALUES
(13, '8496E4C0-9CA8-40BC-B563-26EDE633B240-1499823272', 'Rams Int', 'customer', 'chcagent', 'bbbb', 'ccccc', 'chennai', 'tamil nadu', 600097, '', '', '1', '1', '1', '1', '1', NULL, NULL, '2017-07-28', '1', '1', '1', '1', '1', '1', '1', '1', '1', '30', '100000', '500000', '2017-07-12 01:34:32', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `par_container_info`
--

CREATE TABLE `par_container_info` (
  `container_info_id` int(11) NOT NULL,
  `dimension` varchar(100) NOT NULL,
  `container_count` int(11) NOT NULL,
  `container_details` varchar(1000) NOT NULL,
  `id` int(11) NOT NULL,
  `igp_status` varchar(50) NOT NULL DEFAULT 'notgenerated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `par_container_info`
--

INSERT INTO `par_container_info` (`container_info_id`, `dimension`, `container_count`, `container_details`, `id`, `igp_status`) VALUES
(1, '20 ft. Container', 2, '{\"0\":{\"container_number\":\"123\",\"status\":\"not_picked\"},\"1\":{\"container_number\":\"11223\",\"status\":\"picked\"}}', 3, 'notgenerated');

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
(11, 5, 'Submitted', 0, '2017-06-23 13:40:22', 'PAR Approved'),
(12, 5, 'Submitted', 0, '2017-07-06 02:13:39', 'PAR Approved'),
(13, 44, 'Submitted', 0, '2017-07-06 02:24:28', 'PAR Approved'),
(14, 1, 'Submitted', 0, '2017-07-06 02:24:34', 'PAR Rejected'),
(15, 44, 'Submitted', 0, '2017-07-08 15:05:49', 'PAR Approved'),
(16, 3, 'Submitted', 0, '2017-07-19 17:52:18', 'PAR Rejected'),
(17, 3, 'Submitted', 0, '2017-07-19 17:52:32', 'PAR Approved');

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
(3, 'qwerty123', 'r', 'q', 'Wooden Crate Bags Cartons', '12231', 'Chemcals Compositor', '1', '123', 'r', 'q', '23', '3444', '2017-07-31', '2017-06-30', '2017-06-26', 'TRLPL', '', 'No', '', 'grn_created', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `sac_container_info`
--

CREATE TABLE `sac_container_info` (
  `container_info_id` int(11) NOT NULL,
  `dimension` varchar(100) NOT NULL,
  `container_count` int(11) NOT NULL,
  `container_details` varchar(1000) NOT NULL,
  `id` int(11) NOT NULL,
  `igp_status` varchar(50) NOT NULL DEFAULT 'notgenerated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sac_container_info`
--

INSERT INTO `sac_container_info` (`container_info_id`, `dimension`, `container_count`, `container_details`, `id`, `igp_status`) VALUES
(1, '20 ft. Container', 1, '{\"0\":{\"container_number\":\"112233\",\"status\":\"picked\"}}', 5, 'notgenerated');

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
(13, 1, 'Submitted', 'Rejected', '2017-06-23 13:36:49', 'SAC Rejected'),
(14, 5, 'Submitted', 'Approved', '2017-07-06 02:48:46', 'SAC Approved'),
(15, 3, 'Submitted', 'Rejected', '2017-07-06 02:49:55', 'SAC Rejected'),
(16, 3, 'Submitted', 'Approved', '2017-07-06 02:50:13', 'SAC Approved'),
(17, 7, 'Submitted', 'Approved', '2017-07-18 18:56:29', 'SAC Approved'),
(18, 7, 'Submitted', 'Approved', '2017-07-18 18:57:10', 'SAC Approved'),
(19, 6, 'Submitted', 'Rejected', '2017-07-18 18:57:41', 'SAC Rejected'),
(20, 8, 'Submitted', 'Rejected', '2017-07-19 02:47:34', 'SAC Rejected');

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
(2, '1', '1', '1', '1', '1', 1, 'Metal Drum', '1', '1', '1', 'Non Hazardous', '2017-06-27', '1', 'TRLPL', 'submitted', 'yes'),
(3, '1', '1', '1', '1', '1', 1, 'Metal Drum', '2', '1', '1', 'Non Hazardous', '2017-07-29', '2017-06-27', 'TRLPL', 'grn_created', 'yes'),
(4, 'q', 'q', 'q', 'q', 'q', 0, 'Metal Drum', 'q', 'q', 'q', 'Non Hazardous', '2017-06-28', 'q', 'TRLPL', 'approved', 'yes'),
(5, 'q', 'q', 'q', 'q', 'q', 0, 'Metal Drum', 'q', 'q', 'q', 'Non Hazardous', '2017-07-26', 'q', 'TRLPL', 'approved', 'no'),
(6, '1', '1', '1', '1', '1', 1, 'Metal Drum', '1', '1', '1', 'Non Hazardous', '2017-07-24', '1', 'TRLPL', 'rejected', 'yes'),
(7, '1', '1', '1', '1', '1', 1, 'Metal Drum', '1', '1', '11', 'Non Hazardous', '2017-07-31', '1', 'TRLPL', 'approved', 'yes'),
(8, 'a', 'a', 'a', 'a', 'a', 0, 'Metal Drum', 'a', 'a', 'a', 'Non Hazardous', '2017-07-29', 'a', 'TRLPL', 'rejected', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `tariff_master`
--

CREATE TABLE `tariff_master` (
  `tariff_master_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `base_tariff` float(10,2) NOT NULL,
  `storage_unit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `type_master`
--

CREATE TABLE `type_master` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `type_master`
--

INSERT INTO `type_master` (`type_id`, `type_name`) VALUES
(11, 'Chemicals');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonded_despatch_request`
--
ALTER TABLE `bonded_despatch_request`
  ADD PRIMARY KEY (`pdr_id`);

--
-- Indexes for table `bonded_dv_inward`
--
ALTER TABLE `bonded_dv_inward`
  ADD PRIMARY KEY (`do_ver_id`);

--
-- Indexes for table `bonded_dv_items`
--
ALTER TABLE `bonded_dv_items`
  ADD PRIMARY KEY (`dv_item_id`);

--
-- Indexes for table `bonded_dv_outward`
--
ALTER TABLE `bonded_dv_outward`
  ADD PRIMARY KEY (`dv_ver_id`);

--
-- Indexes for table `bonded_exception`
--
ALTER TABLE `bonded_exception`
  ADD PRIMARY KEY (`exception_id`);

--
-- Indexes for table `bonded_good_receipt_note`
--
ALTER TABLE `bonded_good_receipt_note`
  ADD PRIMARY KEY (`grn_id`);

--
-- Indexes for table `bonded_igp_loading`
--
ALTER TABLE `bonded_igp_loading`
  ADD PRIMARY KEY (`igp_lo_id`);

--
-- Indexes for table `bonded_igp_unloading`
--
ALTER TABLE `bonded_igp_unloading`
  ADD PRIMARY KEY (`igp_un_id`);

--
-- Indexes for table `bonded_joborder_loading`
--
ALTER TABLE `bonded_joborder_loading`
  ADD PRIMARY KEY (`jl_id`);

--
-- Indexes for table `bonded_joborder_unloading`
--
ALTER TABLE `bonded_joborder_unloading`
  ADD PRIMARY KEY (`ju_id`);

--
-- Indexes for table `bonded_ogp_loading`
--
ALTER TABLE `bonded_ogp_loading`
  ADD PRIMARY KEY (`ogp_lo_id`);

--
-- Indexes for table `bonded_ogp_unloading`
--
ALTER TABLE `bonded_ogp_unloading`
  ADD PRIMARY KEY (`ogp_un_id`);

--
-- Indexes for table `bonded_pdr_items`
--
ALTER TABLE `bonded_pdr_items`
  ADD PRIMARY KEY (`pdr_item_id`);

--
-- Indexes for table `general_despatch_request`
--
ALTER TABLE `general_despatch_request`
  ADD PRIMARY KEY (`pdr_id`);

--
-- Indexes for table `general_dv_inward`
--
ALTER TABLE `general_dv_inward`
  ADD PRIMARY KEY (`do_ver_id`);

--
-- Indexes for table `general_dv_items`
--
ALTER TABLE `general_dv_items`
  ADD PRIMARY KEY (`dv_item_id`);

--
-- Indexes for table `general_dv_outward`
--
ALTER TABLE `general_dv_outward`
  ADD PRIMARY KEY (`dv_ver_id`);

--
-- Indexes for table `general_exception`
--
ALTER TABLE `general_exception`
  ADD PRIMARY KEY (`exception_id`);

--
-- Indexes for table `general_good_receipt_note`
--
ALTER TABLE `general_good_receipt_note`
  ADD PRIMARY KEY (`grn_id`);

--
-- Indexes for table `general_igp_loading`
--
ALTER TABLE `general_igp_loading`
  ADD PRIMARY KEY (`igp_lo_id`);

--
-- Indexes for table `general_igp_unloading`
--
ALTER TABLE `general_igp_unloading`
  ADD PRIMARY KEY (`igp_un_id`);

--
-- Indexes for table `general_joborder_loading`
--
ALTER TABLE `general_joborder_loading`
  ADD PRIMARY KEY (`jl_id`);

--
-- Indexes for table `general_joborder_unloading`
--
ALTER TABLE `general_joborder_unloading`
  ADD PRIMARY KEY (`ju_id`);

--
-- Indexes for table `general_ogp_loading`
--
ALTER TABLE `general_ogp_loading`
  ADD PRIMARY KEY (`ogp_lo_id`);

--
-- Indexes for table `general_ogp_unloading`
--
ALTER TABLE `general_ogp_unloading`
  ADD PRIMARY KEY (`ogp_un_id`);

--
-- Indexes for table `general_pdr_items`
--
ALTER TABLE `general_pdr_items`
  ADD PRIMARY KEY (`pdr_item_id`);

--
-- Indexes for table `item_master`
--
ALTER TABLE `item_master`
  ADD PRIMARY KEY (`item_master_id`);

--
-- Indexes for table `party_master`
--
ALTER TABLE `party_master`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `par_container_info`
--
ALTER TABLE `par_container_info`
  ADD PRIMARY KEY (`container_info_id`);

--
-- Indexes for table `par_log`
--
ALTER TABLE `par_log`
  ADD PRIMARY KEY (`par_log_id`);

--
-- Indexes for table `pre_arrival_request`
--
ALTER TABLE `pre_arrival_request`
  ADD PRIMARY KEY (`par_id`);

--
-- Indexes for table `sac_container_info`
--
ALTER TABLE `sac_container_info`
  ADD PRIMARY KEY (`container_info_id`);

--
-- Indexes for table `sac_log`
--
ALTER TABLE `sac_log`
  ADD PRIMARY KEY (`sac_log_id`);

--
-- Indexes for table `sac_request`
--
ALTER TABLE `sac_request`
  ADD PRIMARY KEY (`sac_id`);

--
-- Indexes for table `tariff_master`
--
ALTER TABLE `tariff_master`
  ADD PRIMARY KEY (`tariff_master_id`);

--
-- Indexes for table `type_master`
--
ALTER TABLE `type_master`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonded_despatch_request`
--
ALTER TABLE `bonded_despatch_request`
  MODIFY `pdr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bonded_dv_inward`
--
ALTER TABLE `bonded_dv_inward`
  MODIFY `do_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bonded_dv_items`
--
ALTER TABLE `bonded_dv_items`
  MODIFY `dv_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `bonded_dv_outward`
--
ALTER TABLE `bonded_dv_outward`
  MODIFY `dv_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bonded_exception`
--
ALTER TABLE `bonded_exception`
  MODIFY `exception_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `bonded_good_receipt_note`
--
ALTER TABLE `bonded_good_receipt_note`
  MODIFY `grn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bonded_igp_loading`
--
ALTER TABLE `bonded_igp_loading`
  MODIFY `igp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bonded_igp_unloading`
--
ALTER TABLE `bonded_igp_unloading`
  MODIFY `igp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `bonded_joborder_loading`
--
ALTER TABLE `bonded_joborder_loading`
  MODIFY `jl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bonded_joborder_unloading`
--
ALTER TABLE `bonded_joborder_unloading`
  MODIFY `ju_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bonded_ogp_loading`
--
ALTER TABLE `bonded_ogp_loading`
  MODIFY `ogp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bonded_ogp_unloading`
--
ALTER TABLE `bonded_ogp_unloading`
  MODIFY `ogp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bonded_pdr_items`
--
ALTER TABLE `bonded_pdr_items`
  MODIFY `pdr_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `general_despatch_request`
--
ALTER TABLE `general_despatch_request`
  MODIFY `pdr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_dv_inward`
--
ALTER TABLE `general_dv_inward`
  MODIFY `do_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_dv_items`
--
ALTER TABLE `general_dv_items`
  MODIFY `dv_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_dv_outward`
--
ALTER TABLE `general_dv_outward`
  MODIFY `dv_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_exception`
--
ALTER TABLE `general_exception`
  MODIFY `exception_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_good_receipt_note`
--
ALTER TABLE `general_good_receipt_note`
  MODIFY `grn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `general_igp_loading`
--
ALTER TABLE `general_igp_loading`
  MODIFY `igp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_igp_unloading`
--
ALTER TABLE `general_igp_unloading`
  MODIFY `igp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_joborder_loading`
--
ALTER TABLE `general_joborder_loading`
  MODIFY `jl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_joborder_unloading`
--
ALTER TABLE `general_joborder_unloading`
  MODIFY `ju_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `general_ogp_loading`
--
ALTER TABLE `general_ogp_loading`
  MODIFY `ogp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `general_ogp_unloading`
--
ALTER TABLE `general_ogp_unloading`
  MODIFY `ogp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `general_pdr_items`
--
ALTER TABLE `general_pdr_items`
  MODIFY `pdr_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `item_master`
--
ALTER TABLE `item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `party_master`
--
ALTER TABLE `party_master`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `par_container_info`
--
ALTER TABLE `par_container_info`
  MODIFY `container_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `par_log`
--
ALTER TABLE `par_log`
  MODIFY `par_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `pre_arrival_request`
--
ALTER TABLE `pre_arrival_request`
  MODIFY `par_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sac_container_info`
--
ALTER TABLE `sac_container_info`
  MODIFY `container_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sac_log`
--
ALTER TABLE `sac_log`
  MODIFY `sac_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `sac_request`
--
ALTER TABLE `sac_request`
  MODIFY `sac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `tariff_master`
--
ALTER TABLE `tariff_master`
  MODIFY `tariff_master_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_master`
--
ALTER TABLE `type_master`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
