-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 15, 2018 at 08:20 PM
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
-- Table structure for table `bonded_billing_invoice`
--

CREATE TABLE `bonded_billing_invoice` (
  `bill_id` int(11) NOT NULL,
  `grn_id` int(11) NOT NULL,
  `billing_date` date NOT NULL,
  `period_from` date NOT NULL,
  `period_to` date NOT NULL,
  `bill_amount` varchar(200) NOT NULL COMMENT 'sub total',
  `gst_type` varchar(50) NOT NULL,
  `sgst` varchar(100) DEFAULT NULL,
  `cgst` varchar(100) DEFAULT NULL,
  `igst` varchar(100) DEFAULT NULL,
  `ugst` varchar(100) DEFAULT NULL,
  `tax_payable` varchar(100) NOT NULL,
  `grand_total` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_billing_invoice_details`
--

CREATE TABLE `bonded_billing_invoice_details` (
  `invoice_details_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `service_type` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `gst_type` varchar(50) NOT NULL,
  `sgst` varchar(100) DEFAULT NULL,
  `cgst` varchar(100) DEFAULT NULL,
  `igst` varchar(100) DEFAULT NULL,
  `ugst` varchar(100) DEFAULT NULL,
  `tax_payable` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_despatch_request`
--

CREATE TABLE `bonded_despatch_request` (
  `pdr_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `client_web` varchar(20) NOT NULL,
  `importing_firm_name` varchar(100) NOT NULL,
  `cha_name` varchar(50) NOT NULL,
  `qty_units` int(11) NOT NULL COMMENT 'no of packages',
  `order_number` varchar(50) NOT NULL,
  `bond_number` varchar(100) NOT NULL,
  `boe_number` varchar(50) NOT NULL,
  `exbond_be_number` varchar(50) NOT NULL,
  `exbond_be_date` date NOT NULL,
  `customs_officer_name` varchar(50) NOT NULL,
  `number_of_packages` int(11) NOT NULL,
  `assessment_value` varchar(50) NOT NULL,
  `duty_value` varchar(50) NOT NULL,
  `transporter_name` varchar(50) NOT NULL,
  `document_verified` varchar(10) NOT NULL DEFAULT 'no',
  `igp_created` varchar(5) NOT NULL DEFAULT 'no',
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_discount_master`
--

CREATE TABLE `bonded_discount_master` (
  `discount_master_id` int(11) NOT NULL,
  `customer_pm_id` int(11) NOT NULL,
  `cha_pm_id` int(11) NOT NULL,
  `tariff_master_id` int(11) NOT NULL,
  `discount_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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
  `invoice_copy` varchar(10) NOT NULL DEFAULT 'no',
  `packing_list` varchar(10) NOT NULL DEFAULT 'no',
  `boe_copy` varchar(10) NOT NULL DEFAULT 'no',
  `bond_order` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- Table structure for table `bonded_dv_outward`
--

CREATE TABLE `bonded_dv_outward` (
  `dv_ver_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `exboe_original` varchar(10) NOT NULL DEFAULT 'no' COMMENT 'Ex Bond BOE',
  `order_number` varchar(10) NOT NULL DEFAULT 'no' COMMENT 'Release Order',
  `vehicle_number` varchar(10) NOT NULL DEFAULT 'no',
  `license_number` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `exception_status` varchar(50) NOT NULL DEFAULT 'created',
  `exception_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_good_delivery_note`
--

CREATE TABLE `bonded_good_delivery_note` (
  `gdn_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_good_receipt_note`
--

CREATE TABLE `bonded_good_receipt_note` (
  `grn_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `no_of_units` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `validity` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_grn_log`
--

CREATE TABLE `bonded_grn_log` (
  `log_id` int(11) NOT NULL,
  `grn_id` int(11) NOT NULL,
  `grn_date` date NOT NULL,
  `no_of_units` int(11) NOT NULL,
  `unit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_igp_loading`
--

CREATE TABLE `bonded_igp_loading` (
  `igp_lo_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `entry_date` date NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(50) NOT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driving_license` varchar(50) DEFAULT NULL,
  `time_in` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'igp_created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_igp_unloading`
--

CREATE TABLE `bonded_igp_unloading` (
  `igp_un_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `driving_license` varchar(100) NOT NULL,
  `container_number` varchar(100) DEFAULT NULL,
  `num_tonnage` varchar(100) DEFAULT NULL,
  `entry_date` varchar(50) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `container_condition` varchar(30) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `transporter_name` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_item_master`
--

CREATE TABLE `bonded_item_master` (
  `item_master_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_joborder_loading`
--

CREATE TABLE `bonded_joborder_loading` (
  `jl_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `space_occupied_after` varchar(50) NOT NULL,
  `supervisor_name` varchar(50) NOT NULL,
  `loading_type` int(11) NOT NULL,
  `equipment_ref_number` varchar(50) NOT NULL,
  `no_of_labors` varchar(10) NOT NULL,
  `loading_time` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_joborder_unloading`
--

CREATE TABLE `bonded_joborder_unloading` (
  `ju_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `grn_created` varchar(5) NOT NULL DEFAULT 'no',
  `grn_id` int(11) DEFAULT NULL,
  `sac_id` int(11) NOT NULL,
  `igp_id` int(11) NOT NULL,
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
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `exception_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_ogp_loading`
--

CREATE TABLE `bonded_ogp_loading` (
  `ogp_lo_id` int(11) NOT NULL,
  `jl_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_ogp_unloading`
--

CREATE TABLE `bonded_ogp_unloading` (
  `ogp_un_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_party_master`
--

CREATE TABLE `bonded_party_master` (
  `pm_id` int(11) NOT NULL,
  `pm_uuid` varchar(255) NOT NULL,
  `pm_customerName` varchar(150) DEFAULT NULL,
  `pm_type` varchar(100) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `bonded_tariff_master`
--

CREATE TABLE `bonded_tariff_master` (
  `tariff_master_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `price_per_unit` varchar(100) DEFAULT NULL,
  `minimum_slab` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_type_master`
--

CREATE TABLE `bonded_type_master` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `bonded_unit_master`
--

CREATE TABLE `bonded_unit_master` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_master`
--

CREATE TABLE `employee_master` (
  `em_id` int(11) NOT NULL,
  `employee_name` varchar(100) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `loginid` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role_master_id` int(11) NOT NULL,
  `employee_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `general_despatch_request`
--

CREATE TABLE `general_despatch_request` (
  `pdr_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
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
  `igp_created` varchar(5) NOT NULL DEFAULT 'no',
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `general_discount_master`
--

CREATE TABLE `general_discount_master` (
  `general_discount_master_id` int(11) NOT NULL,
  `customer_pm_id` int(11) NOT NULL,
  `cha_pm_id` int(11) NOT NULL,
  `tariff_master_id` int(11) NOT NULL,
  `discount_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `do_issued_by` varchar(100) NOT NULL,
  `invoice_copy` varchar(10) NOT NULL DEFAULT 'no',
  `packing_list` varchar(10) NOT NULL DEFAULT 'no',
  `boe_copy` varchar(10) NOT NULL DEFAULT 'no',
  `bond_order` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- Table structure for table `general_dv_outward`
--

CREATE TABLE `general_dv_outward` (
  `dv_ver_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `exboe_original` varchar(10) NOT NULL DEFAULT 'no' COMMENT 'Ex Bond BOE',
  `order_number` varchar(10) NOT NULL DEFAULT 'no' COMMENT 'Release Order',
  `vehicle_number` varchar(10) NOT NULL DEFAULT 'no',
  `license_number` varchar(10) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `image` varchar(500) DEFAULT NULL,
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `exception_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_good_delivery_note`
--

CREATE TABLE `general_good_delivery_note` (
  `gdn_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_good_receipt_note`
--

CREATE TABLE `general_good_receipt_note` (
  `grn_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `no_of_units` varchar(100) NOT NULL,
  `unit` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `validity` varchar(100) NOT NULL,
  `created_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_igp_loading`
--

CREATE TABLE `general_igp_loading` (
  `igp_lo_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `entry_date` date NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(50) NOT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driving_license` varchar(50) DEFAULT NULL,
  `time_in` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'igp_created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_igp_unloading`
--

CREATE TABLE `general_igp_unloading` (
  `igp_un_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `data_type` varchar(50) NOT NULL,
  `data_value` varchar(100) NOT NULL,
  `vehicle_number` varchar(50) NOT NULL,
  `driver_name` varchar(100) NOT NULL,
  `driving_license` varchar(100) NOT NULL,
  `container_number` varchar(100) DEFAULT NULL,
  `num_tonnage` varchar(100) DEFAULT NULL,
  `entry_date` varchar(50) NOT NULL,
  `time_in` varchar(50) NOT NULL,
  `container_condition` varchar(30) NOT NULL,
  `vehicle_type` varchar(100) NOT NULL,
  `transporter_name` varchar(200) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_item_master`
--

CREATE TABLE `general_item_master` (
  `item_master_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `general_joborder_loading`
--

CREATE TABLE `general_joborder_loading` (
  `jl_id` int(11) NOT NULL,
  `pdr_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `space_occupied_after` varchar(50) NOT NULL,
  `supervisor_name` varchar(50) NOT NULL,
  `loading_type` int(11) NOT NULL,
  `equipment_ref_number` varchar(50) NOT NULL,
  `no_of_labors` varchar(10) NOT NULL,
  `loading_time` varchar(10) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_joborder_unloading`
--

CREATE TABLE `general_joborder_unloading` (
  `ju_id` int(11) NOT NULL,
  `grn_created` varchar(5) NOT NULL DEFAULT 'no',
  `grn_id` int(11) DEFAULT NULL,
  `par_id` int(11) NOT NULL,
  `igp_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
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
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `exception_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_ogp_loading`
--

CREATE TABLE `general_ogp_loading` (
  `ogp_lo_id` int(11) NOT NULL,
  `jl_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_ogp_unloading`
--

CREATE TABLE `general_ogp_unloading` (
  `ogp_un_id` int(11) NOT NULL,
  `ju_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `exit_time` varchar(50) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `general_party_master`
--

CREATE TABLE `general_party_master` (
  `pm_id` int(11) NOT NULL,
  `pm_uuid` varchar(255) NOT NULL,
  `pm_customerName` varchar(150) DEFAULT NULL,
  `pm_type` varchar(100) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `general_tariff_master`
--

CREATE TABLE `general_tariff_master` (
  `tariff_master_id` int(11) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `unit` varchar(200) NOT NULL,
  `price_per_unit` varchar(100) DEFAULT NULL,
  `minimum_slab` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `general_type_master`
--

CREATE TABLE `general_type_master` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `general_unit_master`
--

CREATE TABLE `general_unit_master` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `par_container_info`
--

CREATE TABLE `par_container_info` (
  `container_info_id` int(11) NOT NULL,
  `dimension` varchar(100) NOT NULL,
  `has_containers` varchar(5) NOT NULL DEFAULT 'no',
  `container_count` int(11) DEFAULT NULL,
  `container_details` varchar(1000) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `tonnage` varchar(100) DEFAULT NULL,
  `igp_status` varchar(50) NOT NULL DEFAULT 'notgenerated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `par_log`
--

CREATE TABLE `par_log` (
  `par_log_id` int(11) NOT NULL,
  `par_id` int(11) NOT NULL,
  `status_from` varchar(50) DEFAULT NULL,
  `status_to` varchar(100) NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pre_arrival_request`
--

CREATE TABLE `pre_arrival_request` (
  `par_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `importing_firm_name` varchar(200) NOT NULL,
  `bol_awb_number` varchar(100) NOT NULL,
  `bol_awb_date` date NOT NULL,
  `material_name` varchar(200) NOT NULL,
  `packing_nature` varchar(100) NOT NULL,
  `assessable_value` varchar(100) NOT NULL,
  `material_nature` varchar(100) NOT NULL,
  `required_period` varchar(100) NOT NULL,
  `cha_name` varchar(200) NOT NULL,
  `boe_number` varchar(100) NOT NULL,
  `boe_date` date NOT NULL,
  `qty_units` varchar(100) NOT NULL,
  `space_requirement` varchar(100) NOT NULL,
  `duty_amount` varchar(100) NOT NULL,
  `expected_date` date NOT NULL,
  `cargo_life` date NOT NULL,
  `shelf_life` date NOT NULL,
  `insurance_by` varchar(50) NOT NULL,
  `client_insurance_copy` varchar(500) DEFAULT NULL,
  `insurance_declaration` varchar(25) NOT NULL,
  `insurance_declaration_copy` varchar(500) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `document_verified` varchar(10) NOT NULL DEFAULT 'no',
  `igp_created` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role_master`
--

CREATE TABLE `role_master` (
  `role_master_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sac_container_info`
--

CREATE TABLE `sac_container_info` (
  `container_info_id` int(11) NOT NULL,
  `dimension` varchar(100) NOT NULL,
  `has_containers` varchar(5) NOT NULL DEFAULT 'no',
  `container_count` int(11) DEFAULT NULL,
  `container_details` varchar(1000) DEFAULT NULL,
  `tonnage` varchar(100) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `igp_status` varchar(50) NOT NULL DEFAULT 'notgenerated'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `sac_log`
--

CREATE TABLE `sac_log` (
  `sac_log_id` int(11) NOT NULL,
  `sac_id` int(11) NOT NULL,
  `status_from` varchar(50) DEFAULT NULL,
  `status_to` varchar(50) NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remarks` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sac_request`
--

CREATE TABLE `sac_request` (
  `sac_id` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `importing_firm_name` varchar(300) NOT NULL,
  `cha_name` varchar(200) NOT NULL,
  `licence_code` varchar(200) NOT NULL,
  `bol_awb_number` varchar(200) NOT NULL,
  `bol_awb_date` date NOT NULL,
  `boe_number` varchar(200) NOT NULL,
  `boe_date` date NOT NULL,
  `material_name` varchar(200) NOT NULL,
  `qty_units` int(11) NOT NULL,
  `packing_nature` varchar(100) NOT NULL,
  `space_requirement` varchar(100) NOT NULL,
  `assessable_value` varchar(100) NOT NULL,
  `duty_amount` varchar(100) NOT NULL,
  `material_nature` varchar(100) NOT NULL,
  `expected_date` date NOT NULL,
  `required_period` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `document_verified` varchar(10) NOT NULL DEFAULT 'no',
  `igp_created` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bonded_billing_invoice`
--
ALTER TABLE `bonded_billing_invoice`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `bonded_billing_invoice_details`
--
ALTER TABLE `bonded_billing_invoice_details`
  ADD PRIMARY KEY (`invoice_details_id`);

--
-- Indexes for table `bonded_despatch_request`
--
ALTER TABLE `bonded_despatch_request`
  ADD PRIMARY KEY (`pdr_id`);

--
-- Indexes for table `bonded_discount_master`
--
ALTER TABLE `bonded_discount_master`
  ADD PRIMARY KEY (`discount_master_id`);

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
-- Indexes for table `bonded_good_delivery_note`
--
ALTER TABLE `bonded_good_delivery_note`
  ADD PRIMARY KEY (`gdn_id`);

--
-- Indexes for table `bonded_good_receipt_note`
--
ALTER TABLE `bonded_good_receipt_note`
  ADD PRIMARY KEY (`grn_id`);

--
-- Indexes for table `bonded_grn_log`
--
ALTER TABLE `bonded_grn_log`
  ADD PRIMARY KEY (`log_id`);

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
-- Indexes for table `bonded_item_master`
--
ALTER TABLE `bonded_item_master`
  ADD PRIMARY KEY (`item_master_id`);

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
-- Indexes for table `bonded_party_master`
--
ALTER TABLE `bonded_party_master`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `bonded_pdr_items`
--
ALTER TABLE `bonded_pdr_items`
  ADD PRIMARY KEY (`pdr_item_id`);

--
-- Indexes for table `bonded_tariff_master`
--
ALTER TABLE `bonded_tariff_master`
  ADD PRIMARY KEY (`tariff_master_id`);

--
-- Indexes for table `bonded_type_master`
--
ALTER TABLE `bonded_type_master`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `bonded_unit_master`
--
ALTER TABLE `bonded_unit_master`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `employee_master`
--
ALTER TABLE `employee_master`
  ADD PRIMARY KEY (`em_id`),
  ADD UNIQUE KEY `em_id` (`em_id`);

--
-- Indexes for table `general_despatch_request`
--
ALTER TABLE `general_despatch_request`
  ADD PRIMARY KEY (`pdr_id`);

--
-- Indexes for table `general_discount_master`
--
ALTER TABLE `general_discount_master`
  ADD PRIMARY KEY (`general_discount_master_id`);

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
-- Indexes for table `general_good_delivery_note`
--
ALTER TABLE `general_good_delivery_note`
  ADD PRIMARY KEY (`gdn_id`);

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
-- Indexes for table `general_item_master`
--
ALTER TABLE `general_item_master`
  ADD PRIMARY KEY (`item_master_id`);

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
-- Indexes for table `general_party_master`
--
ALTER TABLE `general_party_master`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `general_pdr_items`
--
ALTER TABLE `general_pdr_items`
  ADD PRIMARY KEY (`pdr_item_id`);

--
-- Indexes for table `general_tariff_master`
--
ALTER TABLE `general_tariff_master`
  ADD PRIMARY KEY (`tariff_master_id`);

--
-- Indexes for table `general_type_master`
--
ALTER TABLE `general_type_master`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `general_unit_master`
--
ALTER TABLE `general_unit_master`
  ADD PRIMARY KEY (`unit_id`);

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
-- Indexes for table `role_master`
--
ALTER TABLE `role_master`
  ADD PRIMARY KEY (`role_master_id`),
  ADD UNIQUE KEY `role_master_id` (`role_master_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bonded_billing_invoice`
--
ALTER TABLE `bonded_billing_invoice`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;
--
-- AUTO_INCREMENT for table `bonded_billing_invoice_details`
--
ALTER TABLE `bonded_billing_invoice_details`
  MODIFY `invoice_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=547;
--
-- AUTO_INCREMENT for table `bonded_despatch_request`
--
ALTER TABLE `bonded_despatch_request`
  MODIFY `pdr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bonded_discount_master`
--
ALTER TABLE `bonded_discount_master`
  MODIFY `discount_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `bonded_dv_inward`
--
ALTER TABLE `bonded_dv_inward`
  MODIFY `do_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `bonded_dv_items`
--
ALTER TABLE `bonded_dv_items`
  MODIFY `dv_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `bonded_dv_outward`
--
ALTER TABLE `bonded_dv_outward`
  MODIFY `dv_ver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `bonded_exception`
--
ALTER TABLE `bonded_exception`
  MODIFY `exception_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bonded_good_delivery_note`
--
ALTER TABLE `bonded_good_delivery_note`
  MODIFY `gdn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bonded_good_receipt_note`
--
ALTER TABLE `bonded_good_receipt_note`
  MODIFY `grn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bonded_grn_log`
--
ALTER TABLE `bonded_grn_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bonded_igp_loading`
--
ALTER TABLE `bonded_igp_loading`
  MODIFY `igp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bonded_igp_unloading`
--
ALTER TABLE `bonded_igp_unloading`
  MODIFY `igp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `bonded_item_master`
--
ALTER TABLE `bonded_item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bonded_joborder_loading`
--
ALTER TABLE `bonded_joborder_loading`
  MODIFY `jl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bonded_joborder_unloading`
--
ALTER TABLE `bonded_joborder_unloading`
  MODIFY `ju_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bonded_ogp_loading`
--
ALTER TABLE `bonded_ogp_loading`
  MODIFY `ogp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bonded_ogp_unloading`
--
ALTER TABLE `bonded_ogp_unloading`
  MODIFY `ogp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bonded_party_master`
--
ALTER TABLE `bonded_party_master`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `bonded_pdr_items`
--
ALTER TABLE `bonded_pdr_items`
  MODIFY `pdr_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bonded_tariff_master`
--
ALTER TABLE `bonded_tariff_master`
  MODIFY `tariff_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bonded_type_master`
--
ALTER TABLE `bonded_type_master`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `bonded_unit_master`
--
ALTER TABLE `bonded_unit_master`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `employee_master`
--
ALTER TABLE `employee_master`
  MODIFY `em_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `general_despatch_request`
--
ALTER TABLE `general_despatch_request`
  MODIFY `pdr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_discount_master`
--
ALTER TABLE `general_discount_master`
  MODIFY `general_discount_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
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
  MODIFY `exception_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `general_good_delivery_note`
--
ALTER TABLE `general_good_delivery_note`
  MODIFY `gdn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_good_receipt_note`
--
ALTER TABLE `general_good_receipt_note`
  MODIFY `grn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
-- AUTO_INCREMENT for table `general_item_master`
--
ALTER TABLE `general_item_master`
  MODIFY `item_master_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `general_joborder_loading`
--
ALTER TABLE `general_joborder_loading`
  MODIFY `jl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_joborder_unloading`
--
ALTER TABLE `general_joborder_unloading`
  MODIFY `ju_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_ogp_loading`
--
ALTER TABLE `general_ogp_loading`
  MODIFY `ogp_lo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_ogp_unloading`
--
ALTER TABLE `general_ogp_unloading`
  MODIFY `ogp_un_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_party_master`
--
ALTER TABLE `general_party_master`
  MODIFY `pm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `general_pdr_items`
--
ALTER TABLE `general_pdr_items`
  MODIFY `pdr_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `general_tariff_master`
--
ALTER TABLE `general_tariff_master`
  MODIFY `tariff_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `general_type_master`
--
ALTER TABLE `general_type_master`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `general_unit_master`
--
ALTER TABLE `general_unit_master`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `par_container_info`
--
ALTER TABLE `par_container_info`
  MODIFY `container_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `par_log`
--
ALTER TABLE `par_log`
  MODIFY `par_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pre_arrival_request`
--
ALTER TABLE `pre_arrival_request`
  MODIFY `par_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `role_master`
--
ALTER TABLE `role_master`
  MODIFY `role_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sac_container_info`
--
ALTER TABLE `sac_container_info`
  MODIFY `container_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sac_log`
--
ALTER TABLE `sac_log`
  MODIFY `sac_log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `sac_request`
--
ALTER TABLE `sac_request`
  MODIFY `sac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
