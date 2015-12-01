-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 07, 2013 at 09:25 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `2_canvass_voter`
--

CREATE TABLE IF NOT EXISTS `2_canvass_voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(10) unsigned NOT NULL,
  `canvass_id` int(10) unsigned NOT NULL,
  `canvassnothomeresult_id` int(10) unsigned DEFAULT NULL,
  `canvasscontactresult_id` int(10) unsigned DEFAULT NULL,
  `voluntary_flag` varchar(1) DEFAULT NULL,
  `note` text,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `2_canvass_voter_voter_id_foreign` (`voter_id`),
  KEY `2_canvass_voter_canvass_id_foreign` (`canvass_id`),
  KEY `2_canvass_voter_canvassnothomeresult_id_foreign` (`canvassnothomeresult_id`),
  KEY `2_canvass_voter_canvasscontactresult_id_foreign` (`canvasscontactresult_id`),
  KEY `2_canvass_voter_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=227178 ;

-- --------------------------------------------------------

--
-- Table structure for table `2_votehistory`
--

CREATE TABLE IF NOT EXISTS `2_votehistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(10) unsigned DEFAULT NULL,
  `electiontype_id` int(10) unsigned NOT NULL,
  `year` int(11) NOT NULL,
  `voted` varchar(1) NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `2_votehistory_voter_id_foreign` (`voter_id`),
  KEY `electiontype_id` (`electiontype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3943102 ;

-- --------------------------------------------------------

--
-- Table structure for table `2_voters`
--

CREATE TABLE IF NOT EXISTS `2_voters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` varchar(50) NOT NULL,
  `title` varchar(4) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middle_ini` varchar(1) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `surn_suff` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `party_id` int(10) unsigned DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `phone_code` int(11) DEFAULT NULL,
  `phonesource_id` int(10) unsigned DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `age` int(11) NOT NULL,
  `ethnicity_id` int(10) unsigned DEFAULT NULL,
  `ethnicconfidence_id` int(10) unsigned DEFAULT NULL,
  `ethnicgroup_id` int(10) unsigned DEFAULT NULL,
  `occupation_id` int(10) unsigned DEFAULT NULL,
  `random_number` int(11) NOT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `timezone_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(19) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `zip4` varchar(4) DEFAULT NULL,
  `mail_address` varchar(50) NOT NULL,
  `mail_city` varchar(19) NOT NULL,
  `mail_state` varchar(2) NOT NULL,
  `mail_zip` varchar(5) NOT NULL,
  `mail_zip4` varchar(4) DEFAULT NULL,
  `mail_carrier_route` varchar(4) DEFAULT NULL,
  `addresstype_id` int(10) unsigned DEFAULT NULL,
  `addressstatus_id` int(10) unsigned DEFAULT NULL,
  `house_number` varchar(8) NOT NULL,
  `pre_direction` varchar(2) DEFAULT NULL,
  `street_name` varchar(25) NOT NULL,
  `post_direction` varchar(2) DEFAULT NULL,
  `street_suffix` varchar(4) DEFAULT NULL,
  `apt_name` varchar(4) DEFAULT NULL,
  `apt_number` varchar(6) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `home_sequence` int(11) DEFAULT NULL,
  `educationlevel_id` int(10) unsigned DEFAULT NULL,
  `education_id` int(10) unsigned DEFAULT NULL,
  `ethniccode_id` int(10) unsigned DEFAULT NULL,
  `havechild` varchar(1) DEFAULT NULL,
  `household_number` int(11) DEFAULT NULL,
  `household_veteran` varchar(1) DEFAULT NULL,
  `homeownerindicator_id` int(10) unsigned DEFAULT NULL,
  `homemarketvalue_id` int(10) unsigned DEFAULT NULL,
  `homeowner_id` int(10) unsigned DEFAULT NULL,
  `incomelevel_id` int(10) unsigned DEFAULT NULL,
  `householdincomelevel_id` int(10) unsigned DEFAULT NULL,
  `language_id` int(10) unsigned DEFAULT NULL,
  `maritalstatus_id` int(10) unsigned DEFAULT NULL,
  `persons_household` int(11) DEFAULT NULL,
  `religion_id` int(10) unsigned DEFAULT NULL,
  `county_id` int(10) unsigned DEFAULT NULL,
  `st_up_hous` int(11) NOT NULL,
  `st_lo_hous` int(11) NOT NULL,
  `cong_dist` int(11) NOT NULL,
  `precinct_name` varchar(50) DEFAULT NULL,
  `precinct_number` int(11) NOT NULL,
  `schl_dist` varchar(5) DEFAULT NULL,
  `ward` varchar(8) DEFAULT NULL,
  `assemblydistrict_id` int(10) unsigned DEFAULT NULL,
  `pollsite_id` int(10) unsigned DEFAULT NULL,
  `electiondistrict_id` int(10) unsigned DEFAULT NULL,
  `congress_district` int(11) DEFAULT NULL,
  `council_district` int(11) DEFAULT NULL,
  `senate_district` int(11) DEFAULT NULL,
  `civil_court_district` int(11) DEFAULT NULL,
  `judicial_district` int(11) DEFAULT NULL,
  `dnc` varchar(1) DEFAULT NULL,
  `is_voluntary` varchar(1) DEFAULT NULL,
  `mine` varchar(1) NOT NULL DEFAULT 'N',
  `prime1` varchar(1) DEFAULT NULL,
  `prime2` varchar(1) DEFAULT NULL,
  `prime3` varchar(1) DEFAULT NULL,
  `photo` varchar(5) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `voter_id` (`voter_id`),
  KEY `2_voters_party_id_foreign` (`party_id`),
  KEY `2_voters_phonesource_id_foreign` (`phonesource_id`),
  KEY `2_voters_ethnicity_id_foreign` (`ethnicity_id`),
  KEY `2_voters_ethnicconfidence_id_foreign` (`ethnicconfidence_id`),
  KEY `2_voters_ethnicgroup_id_foreign` (`ethnicgroup_id`),
  KEY `2_voters_occupation_id_foreign` (`occupation_id`),
  KEY `2_voters_status_id_foreign` (`status_id`),
  KEY `2_voters_timezone_id_foreign` (`timezone_id`),
  KEY `2_voters_addresstype_id_foreign` (`addresstype_id`),
  KEY `2_voters_addressstatus_id_foreign` (`addressstatus_id`),
  KEY `2_voters_educationlevel_id_foreign` (`educationlevel_id`),
  KEY `2_voters_education_id_foreign` (`education_id`),
  KEY `2_voters_ethniccode_id_foreign` (`ethniccode_id`),
  KEY `2_voters_homeownerindicator_id_foreign` (`homeownerindicator_id`),
  KEY `2_voters_homemarketvalue_id_foreign` (`homemarketvalue_id`),
  KEY `2_voters_homeowner_id_foreign` (`homeowner_id`),
  KEY `2_voters_incomelevel_id_foreign` (`incomelevel_id`),
  KEY `2_voters_householdincomelevel_id_foreign` (`householdincomelevel_id`),
  KEY `2_voters_language_id_foreign` (`language_id`),
  KEY `2_voters_maritalstatus_id_foreign` (`maritalstatus_id`),
  KEY `2_voters_religion_id_foreign` (`religion_id`),
  KEY `2_voters_county_id_foreign` (`county_id`),
  KEY `2_voters_assemblydistrict_id_foreign` (`assemblydistrict_id`),
  KEY `2_voters_pollsite_id_foreign` (`pollsite_id`),
  KEY `2_voters_electiondistrict_id_foreign` (`electiondistrict_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58704 ;

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `datagroup_id` int(10) unsigned DEFAULT NULL,
  `electiontype_id` int(10) unsigned DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `accounts_code_unique` (`code`),
  KEY `accounts_datagroup_id_foreign` (`datagroup_id`),
  KEY `accounts_electiontype_id_foreign` (`electiontype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `addressstatus`
--

CREATE TABLE IF NOT EXISTS `addressstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `color` varchar(10) NOT NULL,
  `description` text,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `addresstypes`
--

CREATE TABLE IF NOT EXISTS `addresstypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `addresstypes_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `assemblydistricts`
--

CREATE TABLE IF NOT EXISTS `assemblydistricts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `state_id` int(10) unsigned NOT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assemblydistricts_state_id_foreign` (`state_id`),
  KEY `assemblydistricts_city_id_foreign` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `aud_voter_contact_history`
--

CREATE TABLE IF NOT EXISTS `aud_voter_contact_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(11) NOT NULL,
  `source` varchar(50) NOT NULL,
  `result` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL DEFAULT '#222222',
  `note` text NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `aud_voter_contact_history_account_id_foreign` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `board_data`
--

CREATE TABLE IF NOT EXISTS `board_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` varchar(9) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `middle_initial` varchar(1) NOT NULL,
  `name_suffix` varchar(4) NOT NULL,
  `house_number` varchar(10) NOT NULL,
  `house_number_suffix` varchar(10) DEFAULT NULL,
  `apartment_number` varchar(15) DEFAULT NULL,
  `street_name` varchar(50) NOT NULL,
  `city` varchar(40) NOT NULL,
  `zipcode` varchar(5) NOT NULL,
  `zipcode4` varchar(4) DEFAULT NULL,
  `mailing_address1` varchar(50) DEFAULT NULL,
  `mailing_address2` varchar(50) DEFAULT NULL,
  `mailing_address3` varchar(50) DEFAULT NULL,
  `mailing_address4` varchar(50) DEFAULT NULL,
  `birthdate` datetime NOT NULL,
  `gender` varchar(1) NOT NULL,
  `political_party` varchar(3) NOT NULL,
  `other_party` varchar(30) DEFAULT NULL,
  `election_district` varchar(3) NOT NULL,
  `assembly_district` varchar(2) NOT NULL,
  `congress_district` varchar(2) NOT NULL,
  `council_district` varchar(2) NOT NULL,
  `senate_district` varchar(2) NOT NULL,
  `civil_court_district` varchar(2) NOT NULL,
  `judicial_district` varchar(2) NOT NULL,
  `registration_date` datetime NOT NULL,
  `status_code` varchar(2) NOT NULL,
  `voter_type` varchar(1) NOT NULL,
  `eff_status_change_date` datetime NOT NULL,
  `year_last_voted` varchar(4) DEFAULT NULL,
  `telephone` varchar(12) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `board_data_voter_id_unique` (`voter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=644909 ;

-- --------------------------------------------------------

--
-- Table structure for table `board_data_history`
--

CREATE TABLE IF NOT EXISTS `board_data_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voter_id` varchar(50) NOT NULL,
  `assembly_district` varchar(2) NOT NULL,
  `election_district` varchar(3) NOT NULL,
  `political_party` varchar(3) NOT NULL,
  `raw_election_date` varchar(8) NOT NULL,
  `election_year` varchar(4) NOT NULL,
  `election_type` varchar(2) NOT NULL,
  `voter_type` varchar(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voter_id` (`voter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4744216 ;

-- --------------------------------------------------------

--
-- Table structure for table `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` timestamp NULL DEFAULT NULL,
  `description` text,
  `allday` varchar(1) NOT NULL DEFAULT 'N',
  `private` varchar(1) NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `calendar_user_id_foreign` (`user_id`),
  KEY `calendar_account_id_foreign` (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `canvasscontactresults`
--

CREATE TABLE IF NOT EXISTS `canvasscontactresults` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL,
  `convert_to_my_voters` varchar(1) NOT NULL DEFAULT 'N',
  `account_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `canvasscontactresults_account_id_foreign` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `canvasses`
--

CREATE TABLE IF NOT EXISTS `canvasses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `filters` text NOT NULL,
  `description` text,
  `account_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `canvasses_account_id_foreign` (`account_id`),
  KEY `canvasses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `canvassnothomeresults`
--

CREATE TABLE IF NOT EXISTS `canvassnothomeresults` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `canvassnothomeresults_account_id_foreign` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `canvass_user`
--

CREATE TABLE IF NOT EXISTS `canvass_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `canvass_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `canvass_user_canvass_id_foreign` (`canvass_id`),
  KEY `canvass_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Table structure for table `canvass_voter`
--

CREATE TABLE IF NOT EXISTS `canvass_voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(10) unsigned NOT NULL,
  `canvass_id` int(10) unsigned NOT NULL,
  `canvassnothomeresult_id` int(10) unsigned DEFAULT NULL,
  `canvasscontactresult_id` int(10) unsigned DEFAULT NULL,
  `voluntary_flag` varchar(1) DEFAULT NULL,
  `note` text,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `canvass_voter_voter_id_foreign` (`voter_id`),
  KEY `canvass_voter_canvass_id_foreign` (`canvass_id`),
  KEY `canvass_voter_canvassnothomeresult_id_foreign` (`canvassnothomeresult_id`),
  KEY `canvass_voter_canvasscontactresult_id_foreign` (`canvasscontactresult_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=207744 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `state_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_state_id_foreign` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `counties`
--

CREATE TABLE IF NOT EXISTS `counties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `counties_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `datafilters`
--

CREATE TABLE IF NOT EXISTS `datafilters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `assemblydistrict_id` int(10) unsigned NOT NULL,
  `pollsite_id` int(10) unsigned DEFAULT NULL,
  `electiondistrict_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `datafilters_assemblydistrict_id_foreign` (`assemblydistrict_id`),
  KEY `datafilters_pollsite_id_foreign` (`pollsite_id`),
  KEY `datafilters_electiondistrict_id_foreign` (`electiondistrict_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `datagoals`
--

CREATE TABLE IF NOT EXISTS `datagoals` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `electiondistrict_id` int(10) unsigned NOT NULL,
  `goal` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `datagoals_account_id_foreign` (`account_id`),
  KEY `datagoals_electiondistrict_id_foreign` (`electiondistrict_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=361 ;

-- --------------------------------------------------------

--
-- Table structure for table `datagroups`
--

CREATE TABLE IF NOT EXISTS `datagroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datagrouptype_id` int(10) unsigned NOT NULL,
  `number` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `datagroups_datagrouptype_id_number_unique` (`datagrouptype_id`,`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `datagrouptypes`
--

CREATE TABLE IF NOT EXISTS `datagrouptypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `datagroup_electiondistrict`
--

CREATE TABLE IF NOT EXISTS `datagroup_electiondistrict` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datagroup_id` int(10) unsigned NOT NULL,
  `electiondistrict_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `datagroup_electiondistrict_datagroup_id_foreign` (`datagroup_id`),
  KEY `datagroup_electiondistrict_electiondistrict_id_foreign` (`electiondistrict_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

-- --------------------------------------------------------

--
-- Table structure for table `directions`
--

CREATE TABLE IF NOT EXISTS `directions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `educationlevels`
--

CREATE TABLE IF NOT EXISTS `educationlevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE IF NOT EXISTS `educations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `educations_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `electiondistricts`
--

CREATE TABLE IF NOT EXISTS `electiondistricts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `pollsite_id` int(10) unsigned NOT NULL,
  `assemblydistrict_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `electiondistricts_pollsite_id_foreign` (`pollsite_id`),
  KEY `electiondistricts_assemblydistrict_id_foreign` (`assemblydistrict_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=921 ;

-- --------------------------------------------------------

--
-- Table structure for table `electiondistrict_user`
--

CREATE TABLE IF NOT EXISTS `electiondistrict_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `electiondistrict_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `electiondistrict_user_user_id_foreign` (`user_id`),
  KEY `electiondistrict_user_electiondistrict_id_foreign` (`electiondistrict_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Table structure for table `electiontypes`
--

CREATE TABLE IF NOT EXISTS `electiontypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ethniccodes`
--

CREATE TABLE IF NOT EXISTS `ethniccodes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ethniccodes_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `ethnicconfidences`
--

CREATE TABLE IF NOT EXISTS `ethnicconfidences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ethnicconfidences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ethnicgroups`
--

CREATE TABLE IF NOT EXISTS `ethnicgroups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ethnicgroups_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `ethnicities`
--

CREATE TABLE IF NOT EXISTS `ethnicities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ethnicities_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=185 ;

-- --------------------------------------------------------

--
-- Table structure for table `goal_assemblydistrict_users`
--

CREATE TABLE IF NOT EXISTS `goal_assemblydistrict_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `assemblydistrict_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goal_assemblydistrict_users_account_id_foreign` (`account_id`),
  KEY `goal_assemblydistrict_users_assemblydistrict_id_foreign` (`assemblydistrict_id`),
  KEY `goal_assemblydistrict_users_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `goal_electiondistrict_users`
--

CREATE TABLE IF NOT EXISTS `goal_electiondistrict_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `electiondistrict_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goal_electiondistrict_users_account_id_foreign` (`account_id`),
  KEY `goal_electiondistrict_users_electiondistrict_id_foreign` (`electiondistrict_id`),
  KEY `goal_electiondistrict_users_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `goal_pollsite_users`
--

CREATE TABLE IF NOT EXISTS `goal_pollsite_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `pollsite_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `goal_pollsite_users_account_id_foreign` (`account_id`),
  KEY `goal_pollsite_users_pollsite_id_foreign` (`pollsite_id`),
  KEY `goal_pollsite_users_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `homemarketvalues`
--

CREATE TABLE IF NOT EXISTS `homemarketvalues` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homemarketvalues_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `homeownerindicators`
--

CREATE TABLE IF NOT EXISTS `homeownerindicators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `homeowners`
--

CREATE TABLE IF NOT EXISTS `homeowners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `homeowners_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `householdincomelevels`
--

CREATE TABLE IF NOT EXISTS `householdincomelevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `householdincomelevels_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `incomelevels`
--

CREATE TABLE IF NOT EXISTS `incomelevels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `incomelevels_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `languages_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

-- --------------------------------------------------------

--
-- Table structure for table `laravel_migrations`
--

CREATE TABLE IF NOT EXISTS `laravel_migrations` (
  `bundle` varchar(50) NOT NULL,
  `name` varchar(200) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`bundle`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `laravel_sessions`
--

CREATE TABLE IF NOT EXISTS `laravel_sessions` (
  `id` varchar(40) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `maritalstatus`
--

CREATE TABLE IF NOT EXISTS `maritalstatus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `support_read` int(11) NOT NULL DEFAULT '0',
  `support_add` int(11) NOT NULL DEFAULT '0',
  `support_delete` int(11) NOT NULL DEFAULT '0',
  `support_update` int(11) NOT NULL DEFAULT '0',
  `support_export` int(11) NOT NULL DEFAULT '0',
  `support_import` int(11) NOT NULL DEFAULT '0',
  `support_print` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `modules_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `module_role`
--

CREATE TABLE IF NOT EXISTS `module_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `add` int(11) NOT NULL DEFAULT '0',
  `delete` int(11) NOT NULL DEFAULT '0',
  `update` int(11) NOT NULL DEFAULT '0',
  `export` int(11) NOT NULL DEFAULT '0',
  `import` int(11) NOT NULL DEFAULT '0',
  `print` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module_role_role_id_foreign` (`role_id`),
  KEY `module_role_module_id_foreign` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `occupations`
--

CREATE TABLE IF NOT EXISTS `occupations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `occupations_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=306 ;

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE IF NOT EXISTS `parties` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `parties_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebankingcallresults`
--

CREATE TABLE IF NOT EXISTS `phonebankingcallresults` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL,
  `remindable` varchar(1) NOT NULL DEFAULT 'N',
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebankingcallresults_account_id_foreign` (`account_id`),
  KEY `phonebankingcallresults_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebankingcontactresults`
--

CREATE TABLE IF NOT EXISTS `phonebankingcontactresults` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `color` varchar(10) NOT NULL,
  `convert_to_my_voters` varchar(1) NOT NULL DEFAULT 'N',
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebankingcontactresults_account_id_foreign` (`account_id`),
  KEY `phonebankingcontactresults_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebankings`
--

CREATE TABLE IF NOT EXISTS `phonebankings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `filters` text NOT NULL,
  `description` text,
  `phonebankingscript_id` int(10) unsigned DEFAULT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebankings_phonebankingscript_id_foreign` (`phonebankingscript_id`),
  KEY `phonebankings_account_id_foreign` (`account_id`),
  KEY `phonebankings_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebankingscripts`
--

CREATE TABLE IF NOT EXISTS `phonebankingscripts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebankingscripts_account_id_foreign` (`account_id`),
  KEY `phonebankingscripts_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebanking_user`
--

CREATE TABLE IF NOT EXISTS `phonebanking_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phonebanking_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebanking_user_phonebanking_id_foreign` (`phonebanking_id`),
  KEY `phonebanking_user_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonebanking_voter`
--

CREATE TABLE IF NOT EXISTS `phonebanking_voter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(10) unsigned NOT NULL,
  `phonebanking_id` int(10) unsigned NOT NULL,
  `phonebankingcallresult_id` int(10) unsigned DEFAULT NULL,
  `phonebankingcontactresult_id` int(10) unsigned DEFAULT NULL,
  `note` text,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `phonebanking_voter_voter_id_foreign` (`voter_id`),
  KEY `phonebanking_voter_phonebanking_id_foreign` (`phonebanking_id`),
  KEY `phonebanking_voter_phonebankingcallresult_id_foreign` (`phonebankingcallresult_id`),
  KEY `phonebanking_voter_phonebankingcontactresult_id_foreign` (`phonebankingcontactresult_id`),
  KEY `phonebanking_voter_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80387 ;

-- --------------------------------------------------------

--
-- Table structure for table `phonesources`
--

CREATE TABLE IF NOT EXISTS `phonesources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phonesources_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `pollsites`
--

CREATE TABLE IF NOT EXISTS `pollsites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=211 ;

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `pollsite_id` int(10) unsigned NOT NULL,
  `precinct_number` int(11) DEFAULT NULL,
  `goal` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `records_account_id_foreign` (`account_id`),
  KEY `records_pollsite_id_foreign` (`pollsite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `religions`
--

CREATE TABLE IF NOT EXISTS `religions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `religions_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_report_criteria_id` int(11) DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `columns` text,
  `filters` text,
  `groupby` text,
  `orderby` text,
  `model_id` int(11) DEFAULT NULL,
  `reporttype_id` int(10) unsigned NOT NULL,
  `display` int(11) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_reporttype_id_foreign` (`reporttype_id`),
  KEY `reports_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=414 ;

-- --------------------------------------------------------

--
-- Table structure for table `reporttasks`
--

CREATE TABLE IF NOT EXISTS `reporttasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `report_id` int(10) unsigned NOT NULL,
  `reporttypetemplate_id` int(10) unsigned DEFAULT NULL,
  `orientation` varchar(10) NOT NULL DEFAULT 'Portrait',
  `paper` varchar(10) NOT NULL DEFAULT 'Letter',
  `output` varchar(10) NOT NULL DEFAULT 'pdf',
  `command` text,
  `status` varchar(2) NOT NULL DEFAULT 'PN',
  `status_text` text,
  `progress` int(10) unsigned NOT NULL DEFAULT '0',
  `progress_text` text,
  `filename` text,
  `downloaded` int(11) NOT NULL DEFAULT '0',
  `notified` int(11) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `sorting` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reporttasks_report_id_foreign` (`report_id`),
  KEY `reporttasks_reporttypetemplate_id_foreign` (`reporttypetemplate_id`),
  KEY `reporttasks_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `reporttypes`
--

CREATE TABLE IF NOT EXISTS `reporttypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `code` varchar(20) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reporttypes_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `reporttypetemplates`
--

CREATE TABLE IF NOT EXISTS `reporttypetemplates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `view` varchar(255) DEFAULT NULL,
  `reporttype_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reporttypetemplates_reporttype_id_foreign` (`reporttype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `report_template`
--

CREATE TABLE IF NOT EXISTS `report_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `header` text NOT NULL,
  `footer` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `assign_roles` text,
  `description` text,
  `account_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roles_account_id_foreign` (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `country_id` int(10) unsigned NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `states_code_unique` (`code`),
  KEY `states_country_id_foreign` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `status_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `streetsuffixes`
--

CREATE TABLE IF NOT EXISTS `streetsuffixes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(20) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `timezones_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `tmp_clients`
--

CREATE TABLE IF NOT EXISTS `tmp_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone_daytime` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone_eveningtime` varchar(20) DEFAULT NULL,
  `best_time_call` varchar(20) DEFAULT NULL,
  `zipcode` varchar(10) NOT NULL,
  `apartment_number` varchar(10) DEFAULT NULL,
  `street_name` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2242 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `change_password_request` varchar(1) NOT NULL DEFAULT 'N',
  `confirmed` varchar(1) NOT NULL DEFAULT 'N',
  `confirmation_code` varchar(50) DEFAULT NULL,
  `address` text,
  `h_phone` varchar(20) DEFAULT NULL,
  `c_phone` varchar(20) DEFAULT NULL,
  `w_phone` varchar(20) DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'D',
  `account_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `is_admin` varchar(1) NOT NULL DEFAULT 'N',
  `has_custom_role` varchar(1) NOT NULL DEFAULT 'N',
  `photo` text,
  `created_by` int(10) unsigned DEFAULT NULL,
  `updated_by` int(10) unsigned DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_account_id_email_unique` (`account_id`,`email`),
  KEY `users_role_id_foreign` (`role_id`),
  KEY `users_created_by_foreign` (`created_by`),
  KEY `users_updated_by_foreign` (`updated_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `voluntaries`
--

CREATE TABLE IF NOT EXISTS `voluntaries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `account_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `voter_id` int(10) unsigned DEFAULT NULL,
  `su` int(11) DEFAULT '0',
  `su_ampm` varchar(2) DEFAULT NULL,
  `mo` int(11) DEFAULT '0',
  `mo_ampm` varchar(2) DEFAULT NULL,
  `tu` int(11) DEFAULT '0',
  `tu_ampm` varchar(2) DEFAULT NULL,
  `we` int(11) DEFAULT '0',
  `we_ampm` varchar(2) DEFAULT NULL,
  `th` int(11) DEFAULT '0',
  `th_ampm` varchar(2) DEFAULT NULL,
  `fr` int(11) DEFAULT '0',
  `fr_ampm` varchar(2) DEFAULT NULL,
  `sa` int(11) DEFAULT '0',
  `sa_ampm` varchar(2) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voluntaries_account_id_foreign` (`account_id`),
  KEY `voluntaries_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=140 ;

-- --------------------------------------------------------

--
-- Table structure for table `votehistory`
--

CREATE TABLE IF NOT EXISTS `votehistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` int(10) unsigned DEFAULT NULL,
  `electiontype_id` int(10) unsigned NOT NULL,
  `year` int(11) NOT NULL,
  `voted` varchar(1) NOT NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `votehistory_voter_id_foreign` (`voter_id`),
  KEY `votehistory_electiontype_id_foreign` (`electiontype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `votercalls`
--

CREATE TABLE IF NOT EXISTS `votercalls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phonebanking_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `phonebankingcallresult_id` int(10) unsigned DEFAULT NULL,
  `phonebankingcontactresult_id` int(10) unsigned DEFAULT NULL,
  `note` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `votercalls_phonebanking_id_foreign` (`phonebanking_id`),
  KEY `votercalls_user_id_foreign` (`user_id`),
  KEY `votercalls_phonebankingcallresult_id_foreign` (`phonebankingcallresult_id`),
  KEY `votercalls_phonebankingcontactresult_id_foreign` (`phonebankingcontactresult_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `voterlists`
--

CREATE TABLE IF NOT EXISTS `voterlists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `columns` text,
  `filters` text NOT NULL,
  `orderby` text,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voterlists_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `voterlists_back`
--

CREATE TABLE IF NOT EXISTS `voterlists_back` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `columns` text,
  `filters` text NOT NULL,
  `orderby` text,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voterlists_user_id_foreign` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE IF NOT EXISTS `voters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voter_id` varchar(50) NOT NULL,
  `title` varchar(4) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middle_ini` varchar(1) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `surn_suff` varchar(10) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `birthdate` datetime DEFAULT NULL,
  `party_id` int(10) unsigned DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `home_number` varchar(20) DEFAULT NULL,
  `work_number` varchar(20) DEFAULT NULL,
  `phone_code` int(11) DEFAULT NULL,
  `phonesource_id` int(10) unsigned DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `age` int(11) NOT NULL,
  `ethnicity_id` int(10) unsigned DEFAULT NULL,
  `ethnicconfidence_id` int(10) unsigned DEFAULT NULL,
  `ethnicgroup_id` int(10) unsigned DEFAULT NULL,
  `occupation_id` int(10) unsigned DEFAULT NULL,
  `random_number` int(11) NOT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `timezone_id` int(10) unsigned DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(19) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `zip4` varchar(4) DEFAULT NULL,
  `mail_address` varchar(50) NOT NULL,
  `mail_city` varchar(19) NOT NULL,
  `mail_state` varchar(2) NOT NULL,
  `mail_zip` varchar(5) NOT NULL,
  `mail_zip4` varchar(4) DEFAULT NULL,
  `mail_carrier_route` varchar(4) DEFAULT NULL,
  `addresstype_id` int(10) unsigned DEFAULT NULL,
  `addressstatus_id` int(10) unsigned DEFAULT NULL,
  `house_number` varchar(8) NOT NULL,
  `pre_direction` varchar(2) DEFAULT NULL,
  `street_name` varchar(25) NOT NULL,
  `post_direction` varchar(2) DEFAULT NULL,
  `street_suffix` varchar(4) DEFAULT NULL,
  `apt_name` varchar(4) DEFAULT NULL,
  `apt_number` varchar(6) DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `home_sequence` int(11) DEFAULT NULL,
  `educationlevel_id` int(10) unsigned DEFAULT NULL,
  `education_id` int(10) unsigned DEFAULT NULL,
  `ethniccode_id` int(10) unsigned DEFAULT NULL,
  `havechild` varchar(1) DEFAULT NULL,
  `household_number` int(11) DEFAULT NULL,
  `household_veteran` varchar(1) DEFAULT NULL,
  `homeownerindicator_id` int(10) unsigned DEFAULT NULL,
  `homemarketvalue_id` int(10) unsigned DEFAULT NULL,
  `homeowner_id` int(10) unsigned DEFAULT NULL,
  `incomelevel_id` int(10) unsigned DEFAULT NULL,
  `householdincomelevel_id` int(10) unsigned DEFAULT NULL,
  `language_id` int(10) unsigned DEFAULT NULL,
  `maritalstatus_id` int(10) unsigned DEFAULT NULL,
  `persons_household` int(11) DEFAULT NULL,
  `religion_id` int(10) unsigned DEFAULT NULL,
  `county_id` int(10) unsigned DEFAULT NULL,
  `st_up_hous` int(11) NOT NULL,
  `st_lo_hous` int(11) NOT NULL,
  `cong_dist` int(11) NOT NULL,
  `precinct_name` varchar(50) DEFAULT NULL,
  `precinct_number` int(11) NOT NULL,
  `schl_dist` varchar(5) DEFAULT NULL,
  `ward` varchar(8) DEFAULT NULL,
  `assemblydistrict_id` int(10) unsigned DEFAULT NULL,
  `pollsite_id` int(10) unsigned DEFAULT NULL,
  `electiondistrict_id` int(10) unsigned DEFAULT NULL,
  `congress_district` int(11) DEFAULT NULL,
  `council_district` int(11) DEFAULT NULL,
  `senate_district` int(11) DEFAULT NULL,
  `civil_court_district` int(11) DEFAULT NULL,
  `judicial_district` int(11) DEFAULT NULL,
  `dnc` varchar(1) DEFAULT NULL,
  `is_voluntary` varchar(1) DEFAULT NULL,
  `mine` varchar(1) NOT NULL DEFAULT 'N',
  `prime1` varchar(1) DEFAULT NULL,
  `prime2` varchar(1) DEFAULT NULL,
  `prime3` varchar(1) DEFAULT NULL,
  `photo` varchar(5) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `voters_party_id_foreign` (`party_id`),
  KEY `voters_phonesource_id_foreign` (`phonesource_id`),
  KEY `voters_ethnicity_id_foreign` (`ethnicity_id`),
  KEY `voters_ethnicconfidence_id_foreign` (`ethnicconfidence_id`),
  KEY `voters_ethnicgroup_id_foreign` (`ethnicgroup_id`),
  KEY `voters_occupation_id_foreign` (`occupation_id`),
  KEY `voters_status_id_foreign` (`status_id`),
  KEY `voters_timezone_id_foreign` (`timezone_id`),
  KEY `voters_addresstype_id_foreign` (`addresstype_id`),
  KEY `voters_educationlevel_id_foreign` (`educationlevel_id`),
  KEY `voters_education_id_foreign` (`education_id`),
  KEY `voters_ethniccode_id_foreign` (`ethniccode_id`),
  KEY `voters_homeownerindicator_id_foreign` (`homeownerindicator_id`),
  KEY `voters_homemarketvalue_id_foreign` (`homemarketvalue_id`),
  KEY `voters_homeowner_id_foreign` (`homeowner_id`),
  KEY `voters_incomelevel_id_foreign` (`incomelevel_id`),
  KEY `voters_householdincomelevel_id_foreign` (`householdincomelevel_id`),
  KEY `voters_language_id_foreign` (`language_id`),
  KEY `voters_maritalstatus_id_foreign` (`maritalstatus_id`),
  KEY `voters_religion_id_foreign` (`religion_id`),
  KEY `voters_county_id_foreign` (`county_id`),
  KEY `voters_assemblydistrict_id_foreign` (`assemblydistrict_id`),
  KEY `voters_pollsite_id_foreign` (`pollsite_id`),
  KEY `voters_electiondistrict_id_foreign` (`electiondistrict_id`),
  KEY `addressstatus_id` (`addressstatus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62522 ;

-- --------------------------------------------------------

--
-- Table structure for table `votersuffix`
--

CREATE TABLE IF NOT EXISTS `votersuffix` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `votertitles`
--

CREATE TABLE IF NOT EXISTS `votertitles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `voter_report_criteria`
--

CREATE TABLE IF NOT EXISTS `voter_report_criteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reporttemplate_id` int(11) DEFAULT NULL,
  `paper` varchar(64) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `orientation` varchar(128) DEFAULT NULL,
  `filters` text,
  `command` text,
  `status` varchar(2) NOT NULL DEFAULT 'PN',
  `output` varchar(5) NOT NULL DEFAULT 'pdf',
  `status_text` text,
  `progress` int(10) NOT NULL,
  `progress_text` text,
  `filename` text,
  `downloaded` int(11) NOT NULL,
  `notified` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `2_canvass_voter`
--
ALTER TABLE `2_canvass_voter`
  ADD CONSTRAINT `2_canvass_voter_canvasscontactresult_id_foreign` FOREIGN KEY (`canvasscontactresult_id`) REFERENCES `canvasscontactresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_canvass_voter_canvassnothomeresult_id_foreign` FOREIGN KEY (`canvassnothomeresult_id`) REFERENCES `canvassnothomeresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_canvass_voter_canvass_id_foreign` FOREIGN KEY (`canvass_id`) REFERENCES `canvasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `2_canvass_voter_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_canvass_voter_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `2_voters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `2_votehistory`
--
ALTER TABLE `2_votehistory`
  ADD CONSTRAINT `2_votehistory_electiontype_id_foreign` FOREIGN KEY (`electiontype_id`) REFERENCES `electiontypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `2_votehistory_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `2_voters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `2_voters`
--
ALTER TABLE `2_voters`
  ADD CONSTRAINT `2_voters_addressstatus_id_foreign` FOREIGN KEY (`addressstatus_id`) REFERENCES `addressstatus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_addresstype_id_foreign` FOREIGN KEY (`addresstype_id`) REFERENCES `addresstypes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_assemblydistrict_id_foreign` FOREIGN KEY (`assemblydistrict_id`) REFERENCES `assemblydistricts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_county_id_foreign` FOREIGN KEY (`county_id`) REFERENCES `counties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_educationlevel_id_foreign` FOREIGN KEY (`educationlevel_id`) REFERENCES `educationlevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_education_id_foreign` FOREIGN KEY (`education_id`) REFERENCES `educations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_ethniccode_id_foreign` FOREIGN KEY (`ethniccode_id`) REFERENCES `ethniccodes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_ethnicconfidence_id_foreign` FOREIGN KEY (`ethnicconfidence_id`) REFERENCES `ethnicconfidences` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_ethnicgroup_id_foreign` FOREIGN KEY (`ethnicgroup_id`) REFERENCES `ethnicgroups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_ethnicity_id_foreign` FOREIGN KEY (`ethnicity_id`) REFERENCES `ethnicities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_homemarketvalue_id_foreign` FOREIGN KEY (`homemarketvalue_id`) REFERENCES `homemarketvalues` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_homeownerindicator_id_foreign` FOREIGN KEY (`homeownerindicator_id`) REFERENCES `homeownerindicators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_homeowner_id_foreign` FOREIGN KEY (`homeowner_id`) REFERENCES `homeowners` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_householdincomelevel_id_foreign` FOREIGN KEY (`householdincomelevel_id`) REFERENCES `householdincomelevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_incomelevel_id_foreign` FOREIGN KEY (`incomelevel_id`) REFERENCES `incomelevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_maritalstatus_id_foreign` FOREIGN KEY (`maritalstatus_id`) REFERENCES `maritalstatus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_occupation_id_foreign` FOREIGN KEY (`occupation_id`) REFERENCES `occupations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_phonesource_id_foreign` FOREIGN KEY (`phonesource_id`) REFERENCES `phonesources` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_religion_id_foreign` FOREIGN KEY (`religion_id`) REFERENCES `religions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `2_voters_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_datagroup_id_foreign` FOREIGN KEY (`datagroup_id`) REFERENCES `datagroups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `accounts_electiontype_id_foreign` FOREIGN KEY (`electiontype_id`) REFERENCES `electiontypes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `assemblydistricts`
--
ALTER TABLE `assemblydistricts`
  ADD CONSTRAINT `assemblydistricts_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `assemblydistricts_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `aud_voter_contact_history`
--
ALTER TABLE `aud_voter_contact_history`
  ADD CONSTRAINT `aud_voter_contact_history_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `calendar`
--
ALTER TABLE `calendar`
  ADD CONSTRAINT `calendar_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `calendar_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `canvasscontactresults`
--
ALTER TABLE `canvasscontactresults`
  ADD CONSTRAINT `canvasscontactresults_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `canvasses`
--
ALTER TABLE `canvasses`
  ADD CONSTRAINT `canvasses_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canvasses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `canvassnothomeresults`
--
ALTER TABLE `canvassnothomeresults`
  ADD CONSTRAINT `canvassnothomeresults_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `canvass_user`
--
ALTER TABLE `canvass_user`
  ADD CONSTRAINT `canvass_user_canvass_id_foreign` FOREIGN KEY (`canvass_id`) REFERENCES `canvasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canvass_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `canvass_voter`
--
ALTER TABLE `canvass_voter`
  ADD CONSTRAINT `canvass_voter_canvasscontactresult_id_foreign` FOREIGN KEY (`canvasscontactresult_id`) REFERENCES `canvasscontactresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `canvass_voter_canvassnothomeresult_id_foreign` FOREIGN KEY (`canvassnothomeresult_id`) REFERENCES `canvassnothomeresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `canvass_voter_canvass_id_foreign` FOREIGN KEY (`canvass_id`) REFERENCES `canvasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `canvass_voter_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `datafilters`
--
ALTER TABLE `datafilters`
  ADD CONSTRAINT `datafilters_assemblydistrict_id_foreign` FOREIGN KEY (`assemblydistrict_id`) REFERENCES `assemblydistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datafilters_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datafilters_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `datagoals`
--
ALTER TABLE `datagoals`
  ADD CONSTRAINT `datagoals_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datagoals_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `datagroups`
--
ALTER TABLE `datagroups`
  ADD CONSTRAINT `datagroups_datagrouptype_id_foreign` FOREIGN KEY (`datagrouptype_id`) REFERENCES `datagrouptypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `datagroup_electiondistrict`
--
ALTER TABLE `datagroup_electiondistrict`
  ADD CONSTRAINT `datagroup_electiondistrict_datagroup_id_foreign` FOREIGN KEY (`datagroup_id`) REFERENCES `datagroups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datagroup_electiondistrict_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `electiondistricts`
--
ALTER TABLE `electiondistricts`
  ADD CONSTRAINT `electiondistricts_assemblydistrict_id_foreign` FOREIGN KEY (`assemblydistrict_id`) REFERENCES `assemblydistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `electiondistricts_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `electiondistrict_user`
--
ALTER TABLE `electiondistrict_user`
  ADD CONSTRAINT `electiondistrict_user_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `electiondistrict_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `goal_assemblydistrict_users`
--
ALTER TABLE `goal_assemblydistrict_users`
  ADD CONSTRAINT `goal_assemblydistrict_users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_assemblydistrict_users_assemblydistrict_id_foreign` FOREIGN KEY (`assemblydistrict_id`) REFERENCES `assemblydistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_assemblydistrict_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `goal_electiondistrict_users`
--
ALTER TABLE `goal_electiondistrict_users`
  ADD CONSTRAINT `goal_electiondistrict_users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_electiondistrict_users_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_electiondistrict_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `goal_pollsite_users`
--
ALTER TABLE `goal_pollsite_users`
  ADD CONSTRAINT `goal_pollsite_users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_pollsite_users_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goal_pollsite_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_role`
--
ALTER TABLE `module_role`
  ADD CONSTRAINT `module_role_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `module_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonebankingcallresults`
--
ALTER TABLE `phonebankingcallresults`
  ADD CONSTRAINT `phonebankingcallresults_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebankingcallresults_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `phonebankingcontactresults`
--
ALTER TABLE `phonebankingcontactresults`
  ADD CONSTRAINT `phonebankingcontactresults_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebankingcontactresults_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `phonebankings`
--
ALTER TABLE `phonebankings`
  ADD CONSTRAINT `phonebankings_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebankings_phonebankingscript_id_foreign` FOREIGN KEY (`phonebankingscript_id`) REFERENCES `phonebankingscripts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebankings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonebankingscripts`
--
ALTER TABLE `phonebankingscripts`
  ADD CONSTRAINT `phonebankingscripts_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebankingscripts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonebanking_user`
--
ALTER TABLE `phonebanking_user`
  ADD CONSTRAINT `phonebanking_user_phonebanking_id_foreign` FOREIGN KEY (`phonebanking_id`) REFERENCES `phonebankings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebanking_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phonebanking_voter`
--
ALTER TABLE `phonebanking_voter`
  ADD CONSTRAINT `phonebanking_voter_phonebankingcallresult_id_foreign` FOREIGN KEY (`phonebankingcallresult_id`) REFERENCES `phonebankingcallresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebanking_voter_phonebankingcontactresult_id_foreign` FOREIGN KEY (`phonebankingcontactresult_id`) REFERENCES `phonebankingcontactresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebanking_voter_phonebanking_id_foreign` FOREIGN KEY (`phonebanking_id`) REFERENCES `phonebankings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebanking_voter_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `phonebanking_voter_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `records_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `records_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_reporttype_id_foreign` FOREIGN KEY (`reporttype_id`) REFERENCES `reporttypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reporttasks`
--
ALTER TABLE `reporttasks`
  ADD CONSTRAINT `reporttasks_reporttypetemplate_id_foreign` FOREIGN KEY (`reporttypetemplate_id`) REFERENCES `reporttypetemplates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporttasks_report_id_foreign` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporttasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reporttypetemplates`
--
ALTER TABLE `reporttypetemplates`
  ADD CONSTRAINT `reporttypetemplates_reporttype_id_foreign` FOREIGN KEY (`reporttype_id`) REFERENCES `reporttypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `users_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `voluntaries`
--
ALTER TABLE `voluntaries`
  ADD CONSTRAINT `voluntaries_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `voluntaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `votehistory`
--
ALTER TABLE `votehistory`
  ADD CONSTRAINT `votehistory_electiontype_id_foreign` FOREIGN KEY (`electiontype_id`) REFERENCES `electiontypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `votehistory_voter_id_foreign` FOREIGN KEY (`voter_id`) REFERENCES `voters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `votercalls`
--
ALTER TABLE `votercalls`
  ADD CONSTRAINT `votercalls_phonebankingcallresult_id_foreign` FOREIGN KEY (`phonebankingcallresult_id`) REFERENCES `phonebankingcallresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `votercalls_phonebankingcontactresult_id_foreign` FOREIGN KEY (`phonebankingcontactresult_id`) REFERENCES `phonebankingcontactresults` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `votercalls_phonebanking_id_foreign` FOREIGN KEY (`phonebanking_id`) REFERENCES `phonebankings` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `votercalls_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `voterlists`
--
ALTER TABLE `voterlists`
  ADD CONSTRAINT `voterlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `voters`
--
ALTER TABLE `voters`
  ADD CONSTRAINT `voters_addresstype_id_foreign` FOREIGN KEY (`addresstype_id`) REFERENCES `addresstypes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_assemblydistrict_id_foreign` FOREIGN KEY (`assemblydistrict_id`) REFERENCES `assemblydistricts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_county_id_foreign` FOREIGN KEY (`county_id`) REFERENCES `counties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_educationlevel_id_foreign` FOREIGN KEY (`educationlevel_id`) REFERENCES `educationlevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_education_id_foreign` FOREIGN KEY (`education_id`) REFERENCES `educations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_electiondistrict_id_foreign` FOREIGN KEY (`electiondistrict_id`) REFERENCES `electiondistricts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_ethniccode_id_foreign` FOREIGN KEY (`ethniccode_id`) REFERENCES `ethniccodes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_ethnicconfidence_id_foreign` FOREIGN KEY (`ethnicconfidence_id`) REFERENCES `ethnicconfidences` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_ethnicgroup_id_foreign` FOREIGN KEY (`ethnicgroup_id`) REFERENCES `ethnicgroups` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_ethnicity_id_foreign` FOREIGN KEY (`ethnicity_id`) REFERENCES `ethnicities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_homemarketvalue_id_foreign` FOREIGN KEY (`homemarketvalue_id`) REFERENCES `homemarketvalues` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_homeownerindicator_id_foreign` FOREIGN KEY (`homeownerindicator_id`) REFERENCES `homeownerindicators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_homeowner_id_foreign` FOREIGN KEY (`homeowner_id`) REFERENCES `homeowners` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_householdincomelevel_id_foreign` FOREIGN KEY (`householdincomelevel_id`) REFERENCES `householdincomelevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_ibfk_1` FOREIGN KEY (`addressstatus_id`) REFERENCES `addressstatus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_incomelevel_id_foreign` FOREIGN KEY (`incomelevel_id`) REFERENCES `incomelevels` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_maritalstatus_id_foreign` FOREIGN KEY (`maritalstatus_id`) REFERENCES `maritalstatus` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_occupation_id_foreign` FOREIGN KEY (`occupation_id`) REFERENCES `occupations` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_phonesource_id_foreign` FOREIGN KEY (`phonesource_id`) REFERENCES `phonesources` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_pollsite_id_foreign` FOREIGN KEY (`pollsite_id`) REFERENCES `pollsites` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_religion_id_foreign` FOREIGN KEY (`religion_id`) REFERENCES `religions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `voters_timezone_id_foreign` FOREIGN KEY (`timezone_id`) REFERENCES `timezones` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
