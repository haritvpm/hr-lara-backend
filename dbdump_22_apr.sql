-- MySQL dump 10.13  Distrib 5.7.42, for Linux (x86_64)
--
-- Host: localhost    Database: hrapp3
-- ------------------------------------------------------
-- Server version	5.7.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `acquittances`
--

LOCK TABLES `acquittances` WRITE;
/*!40000 ALTER TABLE `acquittances` DISABLE KEYS */;
/*!40000 ALTER TABLE `acquittances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `administrative_offices`
--

LOCK TABLES `administrative_offices` WRITE;
/*!40000 ALTER TABLE `administrative_offices` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrative_offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `assembly_sessions`
--

LOCK TABLES `assembly_sessions` WRITE;
/*!40000 ALTER TABLE `assembly_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `assembly_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `attendance_books`
--

LOCK TABLES `attendance_books` WRITE;
/*!40000 ALTER TABLE `attendance_books` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_books` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `attendance_routing_employee`
--

LOCK TABLES `attendance_routing_employee` WRITE;
/*!40000 ALTER TABLE `attendance_routing_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_routing_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `attendance_routing_seat`
--

LOCK TABLES `attendance_routing_seat` WRITE;
/*!40000 ALTER TABLE `attendance_routing_seat` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_routing_seat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `attendance_routings`
--

LOCK TABLES `attendance_routings` WRITE;
/*!40000 ALTER TABLE `attendance_routings` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance_routings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ddos`
--

LOCK TABLES `ddos` WRITE;
/*!40000 ALTER TABLE `ddos` DISABLE KEYS */;
/*!40000 ALTER TABLE `ddos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `dept_designations`
--

LOCK TABLES `dept_designations` WRITE;
/*!40000 ALTER TABLE `dept_designations` DISABLE KEYS */;
/*!40000 ALTER TABLE `dept_designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `dept_employees`
--

LOCK TABLES `dept_employees` WRITE;
/*!40000 ALTER TABLE `dept_employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `dept_employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `designations`
--

LOCK TABLES `designations` WRITE;
/*!40000 ALTER TABLE `designations` DISABLE KEYS */;
/*!40000 ALTER TABLE `designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_ot_settings`
--

LOCK TABLES `employee_ot_settings` WRITE;
/*!40000 ALTER TABLE `employee_ot_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_ot_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_to_acquittances`
--

LOCK TABLES `employee_to_acquittances` WRITE;
/*!40000 ALTER TABLE `employee_to_acquittances` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_to_acquittances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_to_designations`
--

LOCK TABLES `employee_to_designations` WRITE;
/*!40000 ALTER TABLE `employee_to_designations` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_to_designations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_to_seats`
--

LOCK TABLES `employee_to_seats` WRITE;
/*!40000 ALTER TABLE `employee_to_seats` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_to_seats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_to_sections`
--

LOCK TABLES `employee_to_sections` WRITE;
/*!40000 ALTER TABLE `employee_to_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_to_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employee_to_shifts`
--

LOCK TABLES `employee_to_shifts` WRITE;
/*!40000 ALTER TABLE `employee_to_shifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_to_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `exemptions`
--

LOCK TABLES `exemptions` WRITE;
/*!40000 ALTER TABLE `exemptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `exemptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `govt_calendars`
--

LOCK TABLES `govt_calendars` WRITE;
/*!40000 ALTER TABLE `govt_calendars` DISABLE KEYS */;
/*!40000 ALTER TABLE `govt_calendars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `leaves`
--

LOCK TABLES `leaves` WRITE;
/*!40000 ALTER TABLE `leaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `leaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `monthly_attendances`
--

LOCK TABLES `monthly_attendances` WRITE;
/*!40000 ALTER TABLE `monthly_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `office_locations`
--

LOCK TABLES `office_locations` WRITE;
/*!40000 ALTER TABLE `office_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `office_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `office_times`
--

LOCK TABLES `office_times` WRITE;
/*!40000 ALTER TABLE `office_times` DISABLE KEYS */;
/*!40000 ALTER TABLE `office_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ot_categories`
--

LOCK TABLES `ot_categories` WRITE;
/*!40000 ALTER TABLE `ot_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ot_form_others`
--

LOCK TABLES `ot_form_others` WRITE;
/*!40000 ALTER TABLE `ot_form_others` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_form_others` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ot_forms`
--

LOCK TABLES `ot_forms` WRITE;
/*!40000 ALTER TABLE `ot_forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ot_routing_seat`
--

LOCK TABLES `ot_routing_seat` WRITE;
/*!40000 ALTER TABLE `ot_routing_seat` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_routing_seat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `ot_routings`
--

LOCK TABLES `ot_routings` WRITE;
/*!40000 ALTER TABLE `ot_routings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ot_routings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `overtime_others`
--

LOCK TABLES `overtime_others` WRITE;
/*!40000 ALTER TABLE `overtime_others` DISABLE KEYS */;
/*!40000 ALTER TABLE `overtime_others` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `overtime_sittings`
--

LOCK TABLES `overtime_sittings` WRITE;
/*!40000 ALTER TABLE `overtime_sittings` DISABLE KEYS */;
/*!40000 ALTER TABLE `overtime_sittings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `overtimes`
--

LOCK TABLES `overtimes` WRITE;
/*!40000 ALTER TABLE `overtimes` DISABLE KEYS */;
/*!40000 ALTER TABLE `overtimes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permission_role`
--

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `punching_devices`
--

LOCK TABLES `punching_devices` WRITE;
/*!40000 ALTER TABLE `punching_devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `punching_devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `punching_traces`
--

LOCK TABLES `punching_traces` WRITE;
/*!40000 ALTER TABLE `punching_traces` DISABLE KEYS */;
/*!40000 ALTER TABLE `punching_traces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `punchings`
--

LOCK TABLES `punchings` WRITE;
/*!40000 ALTER TABLE `punchings` DISABLE KEYS */;
/*!40000 ALTER TABLE `punchings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `seat_to_js_as_sses`
--

LOCK TABLES `seat_to_js_as_sses` WRITE;
/*!40000 ALTER TABLE `seat_to_js_as_sses` DISABLE KEYS */;
/*!40000 ALTER TABLE `seat_to_js_as_sses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `seats`
--

LOCK TABLES `seats` WRITE;
/*!40000 ALTER TABLE `seats` DISABLE KEYS */;
/*!40000 ALTER TABLE `seats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `seniorities`
--

LOCK TABLES `seniorities` WRITE;
/*!40000 ALTER TABLE `seniorities` DISABLE KEYS */;
/*!40000 ALTER TABLE `seniorities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `success_punchings`
--

LOCK TABLES `success_punchings` WRITE;
/*!40000 ALTER TABLE `success_punchings` DISABLE KEYS */;
/*!40000 ALTER TABLE `success_punchings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tax_entries`
--

LOCK TABLES `tax_entries` WRITE;
/*!40000 ALTER TABLE `tax_entries` DISABLE KEYS */;
/*!40000 ALTER TABLE `tax_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tds`
--

LOCK TABLES `tds` WRITE;
/*!40000 ALTER TABLE `tds` DISABLE KEYS */;
/*!40000 ALTER TABLE `tds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `yearly_attendances`
--

LOCK TABLES `yearly_attendances` WRITE;
/*!40000 ALTER TABLE `yearly_attendances` DISABLE KEYS */;
/*!40000 ALTER TABLE `yearly_attendances` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-30 15:21:12
