-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2023 at 08:09 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trippintrip`
--

-- --------------------------------------------------------

--
-- Table structure for table `personas_trip`
--

CREATE TABLE `personas_trip` (
  `plan_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `att_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plan_cost`
--

CREATE TABLE `plan_cost` (
  `plan_id` int(11) NOT NULL,
  `cost` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_phone` varchar(20) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_name`, `admin_phone`, `admin_email`, `admin_password`, `state_id`) VALUES
(1, 'Shyvonne', '0164181487', 'shyvonnejinshi@gmail.com', '3476a16f2c6145c2abe0005346ffcbee422330dc', 9),
(2, 'John', '0123456789', 'john@gmail.com', '997ade576976b31e106a0913915a7d877cb7f882', 9);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attraction`
--

CREATE TABLE `tbl_attraction` (
  `att_id` int(10) NOT NULL,
  `att_name` varchar(255) NOT NULL,
  `att_category` varchar(255) NOT NULL,
  `att_location` varchar(255) NOT NULL,
  `att_longtitude` decimal(30,15) DEFAULT NULL,
  `att_latitude` decimal(30,15) DEFAULT NULL,
  `att_opening` varchar(255) NOT NULL,
  `att_closing` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `att_price` varchar(255) NOT NULL,
  `att_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_attraction`
--

INSERT INTO `tbl_attraction` (`att_id`, `att_name`, `att_category`, `att_location`, `att_longtitude`, `att_latitude`, `att_opening`, `att_closing`, `state_id`, `att_price`, `att_desc`) VALUES
(1, 'Audi Dream Farm', 'Outdoor', 'Audi dreamfarm 145, MK B, Sg.Rusa, 11010 Balik Pulau, Pulau Pinang', '5.386209858407821', '100.210116938111800', '9am', '6pm', 9, 'Adult - RM33Child - RM30Senior - RM30', 'This mini farm grows non-toxic chemicals and nature growing plants with several kinds of tame animals. Experience planting, fishing, animal riding, traditional home made, Malay traditional batik painting and more.'),
(2, 'Boutique Aquarium TOP Penang', 'Indoor, Scenery, Ocean, Nature', '1, No, 1, Jln Penang, 10000 George Town, Pulau Pinang', '0.000000000000000', '0.000000000000000', '11am', '7pm', 9, 'Adult - RM34\r\nChild/Senior - RM30', 'Get up close and personal with marine flora and fauna as you go on a journey of discovery at Penang Boutique Aquarium! A place where you can get amazed by and learn about marine species.'),
(3, 'Carnivorous Plants Terrarium Workshop', 'Indoor, Crafts', '66, Tanjung Bungah Park, 11200 Penang', '0.000000000000000', '0.000000000000000', '10am', '7pm', 9, 'RM120', 'earn more about carnivorous or insect eating plants, be amazed by their abilities to lure, hunt and digest little bugs. Experience the creation of a carnivorous plants terrarium, with venus flytrap, drosera, pinguicula or various pitcher plants. Bring hom'),
(4, 'Entopia by Penang Butterfly Farm', 'Outdoor, Scenery, Nature', 'Entopia by Penang Butterfly Farm, C6X8+33, 830, Jalan Teluk Bahang, Teluk Bahang, 11050 Tanjung Bungah, Penang', '0.000000000000000', '0.000000000000000', '9am', '5pm', 9, 'Malaysian - RM59\r\n', 'Visit Entopia, one of the largest butterfly gardens in Malaysia which contains more than 15,000 free-flying butterflies. Explore nature’s largest classroom and discovery hub, where butterflies and insects are free to come out and play.'),
(5, 'ESCAPE Theme Park Penang', 'Sports, Outdoor, Nature', 'ESCAPE Penang, 828, Jalan Teluk Bahang, Teluk Bahang, 11050 Tanjung Bungah, Penang', '0.000000000000000', '0.000000000000000', '10am', '6pm', 9, 'Junior Kid - RM103\r\nBig Kid - RM155', 'ESCAPE Penang is a must-visit destination with family and friends when you are in Penang! ESCAPE Penang holds a Guinness World Record of having the Longest Tube Water Slide and the Longest Zip Coaster in the world'),
(6, 'Penang Bird Park', 'Outdoor, Nature', 'Jalan Todak Seberang Jaya, 13700 Perai, Penang', '0.000000000000000', '0.000000000000000', '9am', '6pm', 9, 'Non-Malaysian Adult - RM43\r\nNon-Malaysian Child - RM18\r\nMalaysian Adult - RM36\r\nMalaysian Child - RM13.50', 'Go for a day outing with your family and friends at Penang Bird Park, one of the largest bird park attractions in Malaysia with a huge variety of bird species and plants.'),
(7, 'Pottery Wheel-throwing Workshop', 'Outdoor, Crafts', 'Thit-tho 28, 28, Lorong Lembah Permai 6, Tanjung Bungah, 11200 Pulau Pinang\r\n', '0.000000000000000', '0.000000000000000', '9am', '5pm', 9, 'RM110', 'Experience the making process of pottery pots and mugs when you participate this workshop. Learn the personality of clay while having fun at the same time.'),
(8, 'Project Rock', 'Indoor, Sports', '170-07-12A, Plaza Gurney, Persiaran Gurney, 10250 George Town, Pulau Pinang', '0.000000000000000', '0.000000000000000', '10am', '10pm', 9, 'Rockers (Aged 18+) - RM49\r\nRookies (Aged 18-) - RM40', 'Experience rock climbing and bouldering in Penang in a fun and safe environment. Explore these activities without having to worry about weather conditions'),
(9, 'Tech Dome Penang', 'Indoor, Science', 'Geodesic Dome, KOMTAR, Jln Penang, 10000 George Town, Pulau Pinang', '0.000000000000000', '0.000000000000000', '10am', '7pm', 9, 'Adult - RM28\r\nChild - RM 16', 'Tech Dome Penang is a place for kids to learn more about technology. Discover the difference of technology and our life'),
(10, 'The Habitat Penang Hill', 'Outdoor, Scenery, Nature', 'The Habitat Penang Hill, Jalan Stesen, Bukit Bendera Air Itam, 11500 George Town, Pulau Pinang', '0.000000000000000', '0.000000000000000', '9am', '7pm', 9, 'RM60', 'Enjoy an impressive 360-degree panoramic view of Penang Island from the highest viewing point of Penang, The Habitat Penang Hill. Visit and explore the diverse flora and fauna that grows within The Habitat Penang Hill'),
(11, 'The TOP Penang', 'Scenery, Outdoor, Sports', 'The TOP Penang, Theme Park Penang, 1, Jln Penang, Georgetown, 10000 George Town, Penang', '0.000000000000000', '0.000000000000000', '10am', '10pm', 9, 'RM61', 'Enjoy the breathtaking bird’s eye view of Penang Island from an open-air platform at the highest point in George Town, The Top Komtar Tower.'),
(12, 'Wild Immersion Virtual Reality Experience', 'Indoor, Scenery, Technology', 'Jalan Stesen, Bukit Bendera Air Itam, 11500 George Town, Pulau Pinang', '0.000000000000000', '0.000000000000000', '10am', '7pm', 9, 'RM25', 'Endorsed by Jane Goodall, the Wild Immersion VR experience is the world’s first virtual nature reserve. Discover wild animals in their habitat and be fascinated by our planet’s biodiversity through an immersive virtual reality experience.'),
(13, 'Wonderfood Museum', 'Indoor, Museum, Foodie, Art', '49, Lebuh Pantai, GeorgeTown, 10200 George Town, Pulau Pinang, Malaysia', '0.000000000000000', '0.000000000000000', '9am', '6pm', 9, 'Malaysian Adult - RM20\r\nMalaysian Child - RM12\r\nNon-Malaysian Adult - RM30\r\nNon-Malaysian Child - RM18', 'Visit a unique museum in the heart of Penang featuring oversized replicas of traditional Malaysian dishes. Discover interesting delicacies arising from Malaysia\'s multi-cultural background at the museum\'s three galleries.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personas`
--

CREATE TABLE `tbl_personas` (
  `persona_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `persona_type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prefered_activity` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personas`
--

INSERT INTO `tbl_personas` (`persona_id`, `name`, `persona_type`, `description`, `prefered_activity`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'Jack Sparrow', 'Adventure Seeker', 'Likes adrenaline-pumping activities such as bungee jumping and skydiving', 'Rock climbing\nWhite-water rafting\nSkydiving\nBungee jumping\nScuba diving\nZip-lining\nHiking\nSurfing', 'https://images.unsplash.com/photo-1625587997931-545e4561ada5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=425&q=80', '2022-01-01 12:00:00', '2022-01-01 12:00:00'),
(2, 'Jane Doe', 'Culture Enthusiast', 'Interested in exploring local customs, traditions, and historical landmarks', 'Visiting museums and art galleries\r\nAttending theater performances and musicals\r\nExploring historic sites and landmarks\r\nTaking walking tours of cities or neighborhoods\r\nParticipating in cultural festivals and events\r\nTrying local cuisine and beverages', 'https://images.unsplash.com/photo-1546603999-24fbcb911bee?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80', '2022-01-01 12:00:00', '2022-01-01 12:00:00'),
(3, 'Miley Cyrus', 'Beach Lover', 'Enjoys spending time in warm, tropical environments with sandy beaches and clear waters', 'Swim in the ocean\r\nSunbathe on the sand\r\nBuild sandcastles\r\nWalk or jog along the shore\r\nSnorkel or scuba dive\r\nSurf or bodyboard\r\nPlay beach sports\r\nRelax under an umbrella\r\nHave a beach picnic or barbecue with family and friends.', 'https://images.unsplash.com/photo-1611028798900-9040e442808c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-01 12:00:00', '2022-01-01 12:00:00'),
(4, 'Kim Kardahshians', 'Luxury Traveler', 'Enjoys high-end amenities, fine dining, and exclusive experiences', 'Stay in luxury hotels and resorts\r\nDine at high-end restaurants\r\nEnjoy spa treatments\r\nTake private tours and experiences\r\nShop at luxury boutiques and malls\r\nAttend exclusive events\r\nTravel by private jet, yacht, or helicopter', 'https://images.unsplash.com/photo-1611682060613-597ef6d1464b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=327&q=80', '2022-01-02 09:00:00', '2022-01-02 09:00:00'),
(5, 'Christine Latin', 'Budget Backpacker', 'Prefers low-cost travel and accommodation, with a focus on exploring local cultures and meeting new people', 'Stay in hostels or budget lodging\r\nCook meals in a shared kitchen or eat street food\r\nUse public transportation or walk\r\nVisit free or low-cost attractions and museums\r\nHike and camp in national parks and wilderness', 'https://images.unsplash.com/photo-1607957159870-61bd258a1c92?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=327&q=80', '2022-01-02 09:00:00', '2022-01-02 09:00:00'),
(6, 'Peter Parker', 'Family Vacationer', 'Travels with children and seeks family-friendly activities and amenities', 'Visiting theme parks and amusement parks\r\nRelaxing on family-friendly beaches and resorts\r\nGoing on outdoor adventures such as hiking, camping, and kayaking\r\nParticipating in cultural and educational activities such as museums and historic sites', 'https://images.unsplash.com/photo-1518725522904-4b3939358342?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-02 09:00:00', '2022-01-02 09:00:00'),
(7, 'Robert Downey Jr.', 'Foodie', 'Enjoys trying local cuisine and exploring culinary traditions and food culture', 'Trying local street food and food markets\r\nDining at highly-rated restaurants and cafes\r\nParticipating in cooking classes and food tours\r\nTasting regional wines, beers, and spirits\r\nVisiting food festivals and events', 'https://images.unsplash.com/flagged/photo-1558764646-0c1bed17c001?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-03 14:30:00', '2022-01-03 14:30:00'),
(8, 'Tarzan Boy', 'Nature Lover', 'Seeks outdoor adventures and experiences in natural environments such as mountains, forests, and national parks', 'Hiking and trekking in mountains and forests\r\nWildlife watching and safaris\r\nCamping and backpacking in national parks and wilderness areas\r\nExploring caves, canyons, and other natural formations\r\nBirdwatching and nature photography', 'https://images.unsplash.com/photo-1614796777166-850631f4091c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=435&q=80', '2022-01-03 14:30:00', '2022-01-03 14:30:00'),
(9, 'Galileo Galiley', 'History Buff', 'Interested in exploring historical sites, landmarks, and museums', 'Visiting historical landmarks and monuments\r\nExploring museums and art galleries\r\nTaking guided tours of historic cities and neighborhoods\r\nLearning about the history of a place through its architecture and art\r\nReading historical novels and biographies', 'https://images.unsplash.com/photo-1602077422495-c8733eb58c34?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=464&q=80', '2022-01-03 14:30:00', '2022-01-03 14:30:00'),
(10, 'Van Gogh', 'Art Connoisseur', 'Enjoys visiting art galleries, museums, and exhibitions, and appreciates various art forms', 'Visiting art museums and galleries\r\nParticipating in guided tours of art collections\r\nAttending art shows and auctions\r\nMeeting artists and attending artist talks\r\nTaking art classes and workshops\r\nVisiting public art installations and sculptures', 'https://images.unsplash.com/photo-1618151313441-bc79b11e5090?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-04 20:15:00', '2022-01-04 20:15:00'),
(11, 'Stephan Curry', 'Sports Fan', 'Enjoys attending or participating in sports events and activities', 'Attending live sports events such as games and matches\r\nVisiting sports museums and halls of fame\r\nParticipating in sports activities such as golfing, skiing, and surfing\r\nWatching sports events on TV and streaming services\r\nPlaying sports with friends', 'https://images.unsplash.com/photo-1618393649689-c997c7455ef5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-04 20:15:00', '2022-01-04 20:15:00'),
(12, 'Steve Jobs', 'Digital Nomad', 'Works remotely and travels frequently, seeking destinations with good internet connectivity and co-working spaces', 'Working remotely from a laptop or mobile device\r\nTraveling to different locations while working\r\nStaying in accommodations with reliable Wi-Fi and workspace\r\nExploring new destinations during free time', 'https://plus.unsplash.com/premium_photo-1674639437824-771a65f1738b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2022-01-04 20:15:00', '2022-01-04 20:15:00'),
(13, 'Jisoo', 'Romantic Getaway', 'Travels with a significant other and seeks romantic experiences such as sunset views, candlelit dinners, and couples', 'Taking a sunset or sunrise walk on the beach\r\nEnjoying a candlelit dinner for two at a fancy restaurant\r\nGoing on a romantic cruise or boat ride\r\nRelaxing at a spa or hot springs\r\nWatching a romantic movie or show together\r\nGoing on a scenic hike or walk', 'https://images.unsplash.com/photo-1597957602900-97e95de20028?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80 ', '2023-04-10 12:40:28', '2023-04-10 12:42:28'),
(14, 'Jason', 'Random Guy', 'Testing', 'Running around like crazy.', 'https://images.unsplash.com/photo-1618641986557-1ecd230959aa?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80', '2023-04-11 20:35:53', '2023-04-11 22:17:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_states`
--

CREATE TABLE `tbl_states` (
  `state_id` int(11) NOT NULL,
  `state_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_states`
--

INSERT INTO `tbl_states` (`state_id`, `state_name`) VALUES
(1, 'Johor'),
(2, 'Kedah'),
(3, 'Kelantan'),
(4, 'Melaka'),
(5, 'Negeri Sembilan'),
(6, 'Pahang'),
(7, 'Perak'),
(8, 'Perlis'),
(9, 'Penang'),
(10, 'Sabah'),
(11, 'Sarawak'),
(12, 'Selangor'),
(13, 'Terengganu');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_trips`
--

CREATE TABLE `tbl_trips` (
  `trip_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trip_name` varchar(255) NOT NULL,
  `trip_desc` varchar(255) NOT NULL,
  `trip_location` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_trips`
--

INSERT INTO `tbl_trips` (`trip_id`, `user_id`, `trip_name`, `trip_desc`, `trip_location`, `start_date`, `end_date`) VALUES
(2, 1, 'Penang Trip', 'This is a short trip to go with friends', 'Penang', '2023-04-12', '2023-04-21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_gender` varchar(20) NOT NULL,
  `user_bio` varchar(50) NOT NULL,
  `user_password` char(40) NOT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_datereg` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp` int(6) DEFAULT NULL,
  `isProfileComplete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `user_email`, `user_name`, `user_gender`, `user_bio`, `user_password`, `user_phone`, `user_address`, `user_datereg`, `otp`, `isProfileComplete`) VALUES
(1, 'shyv@gmail.com', 'Shyvonne', 'Female', 'I like to travel alone and explore new things', '997ade576976b31e106a0913915a7d877cb7f882', '0164181487', 'Georgetown Penang', '2023-04-04 16:29:11', 22084, 1);

-- --------------------------------------------------------

--
-- Table structure for table `trip_attraction`
--

CREATE TABLE `trip_attraction` (
  `trip_id` int(11) NOT NULL,
  `att_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_persona_preferences`
--

CREATE TABLE `user_persona_preferences` (
  `user_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  `interests` varchar(255) DEFAULT NULL,
  `accommodation` varchar(50) NOT NULL,
  `budget` int(11) NOT NULL,
  `travel_style` varchar(50) NOT NULL,
  `destination_preferences` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_persona_preferences`
--

INSERT INTO `user_persona_preferences` (`user_id`, `persona_id`, `interests`, `accommodation`, `budget`, `travel_style`, `destination_preferences`, `created_at`, `updated_at`) VALUES
(1, 11, 'Culture', 'Hostel', 3300, 'Luxury', 'Kedah', '0000-00-00 00:00:00', '2023-04-12 12:03:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `personas_trip`
--
ALTER TABLE `personas_trip`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `persona_id` (`persona_id`),
  ADD KEY `att_id` (`att_id`);

--
-- Indexes for table `plan_cost`
--
ALTER TABLE `plan_cost`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `fk_state_id` (`state_id`);

--
-- Indexes for table `tbl_attraction`
--
ALTER TABLE `tbl_attraction`
  ADD PRIMARY KEY (`att_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD PRIMARY KEY (`persona_id`);

--
-- Indexes for table `tbl_states`
--
ALTER TABLE `tbl_states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `tbl_trips`
--
ALTER TABLE `tbl_trips`
  ADD PRIMARY KEY (`trip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`user_email`);

--
-- Indexes for table `trip_attraction`
--
ALTER TABLE `trip_attraction`
  ADD PRIMARY KEY (`trip_id`,`att_id`),
  ADD KEY `att_id` (`att_id`);

--
-- Indexes for table `user_persona_preferences`
--
ALTER TABLE `user_persona_preferences`
  ADD PRIMARY KEY (`user_id`,`persona_id`),
  ADD KEY `persona_id` (`persona_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `personas_trip`
--
ALTER TABLE `personas_trip`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_attraction`
--
ALTER TABLE `tbl_attraction`
  MODIFY `att_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_personas`
--
ALTER TABLE `tbl_personas`
  MODIFY `persona_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_states`
--
ALTER TABLE `tbl_states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_trips`
--
ALTER TABLE `tbl_trips`
  MODIFY `trip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `personas_trip`
--
ALTER TABLE `personas_trip`
  ADD CONSTRAINT `personas_trip_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `tbl_personas` (`persona_id`),
  ADD CONSTRAINT `personas_trip_ibfk_2` FOREIGN KEY (`att_id`) REFERENCES `tbl_attraction` (`att_id`);

--
-- Constraints for table `plan_cost`
--
ALTER TABLE `plan_cost`
  ADD CONSTRAINT `plan_cost_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `personas_trip` (`plan_id`);

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `fk_state_id` FOREIGN KEY (`state_id`) REFERENCES `tbl_states` (`state_id`);

--
-- Constraints for table `tbl_attraction`
--
ALTER TABLE `tbl_attraction`
  ADD CONSTRAINT `tbl_attraction_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `tbl_states` (`state_id`);

--
-- Constraints for table `tbl_trips`
--
ALTER TABLE `tbl_trips`
  ADD CONSTRAINT `tbl_trips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);

--
-- Constraints for table `trip_attraction`
--
ALTER TABLE `trip_attraction`
  ADD CONSTRAINT `trip_attraction_ibfk_1` FOREIGN KEY (`trip_id`) REFERENCES `tbl_trips` (`trip_id`),
  ADD CONSTRAINT `trip_attraction_ibfk_2` FOREIGN KEY (`att_id`) REFERENCES `tbl_attraction` (`att_id`);

--
-- Constraints for table `user_persona_preferences`
--
ALTER TABLE `user_persona_preferences`
  ADD CONSTRAINT `user_persona_preferences_ibfk_1` FOREIGN KEY (`persona_id`) REFERENCES `tbl_personas` (`persona_id`),
  ADD CONSTRAINT `user_persona_preferences_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
