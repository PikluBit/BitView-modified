-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2026 at 05:52 AM
-- Server version: 5.7.44-log
-- PHP Version: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bv2009`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_log`
--

CREATE TABLE `access_log` (
  `text` varchar(256) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `whodid` varchar(100) NOT NULL,
  `whatdid` varchar(200) NOT NULL,
  `dater` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(15) NOT NULL,
  `username` varchar(120) NOT NULL,
  `api_key` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `being_watched`
--

CREATE TABLE `being_watched` (
  `url` varchar(11) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `content` longtext NOT NULL,
  `submit_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bulletins`
--

CREATE TABLE `bulletins` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `content` varchar(1000) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bulletins_comments`
--

CREATE TABLE `bulletins_comments` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `content` varchar(500) NOT NULL,
  `bulletin_id` int(6) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bulletins_new`
--

CREATE TABLE `bulletins_new` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `content` varchar(250) NOT NULL,
  `url` varchar(11) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `channel_comments`
--

CREATE TABLE `channel_comments` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `content` varchar(500) NOT NULL,
  `on_channel` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `comment_votes`
--

CREATE TABLE `comment_votes` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `rating` smallint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `name` varchar(32) NOT NULL,
  `value` varchar(512) NOT NULL,
  `int_value` int(1) DEFAULT NULL,
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE `contest` (
  `id` int(11) NOT NULL,
  `datemonth` varchar(20) NOT NULL,
  `whatisthis` varchar(200) NOT NULL,
  `howtoenter` varchar(210) NOT NULL,
  `thismonth` varchar(200) NOT NULL,
  `lastcontestwinners` varchar(600) NOT NULL,
  `tag` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `converting`
--

CREATE TABLE `converting` (
  `url` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `updating` int(11) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `copyright_strikes`
--

CREATE TABLE `copyright_strikes` (
  `url` varchar(11) NOT NULL,
  `for_user` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL,
  `title` varchar(128) NOT NULL,
  `copyright_holder` varchar(200) NOT NULL DEFAULT 'The BitView Staff',
  `accepted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `username` varchar(20) NOT NULL,
  `vkey` varchar(20) NOT NULL,
  `vdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `failed_login_attempts`
--

CREATE TABLE `failed_login_attempts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempted_username` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` smallint(4) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `categories` smallint(2) DEFAULT '1',
  `created_by` varchar(20) NOT NULL,
  `creation_date` datetime NOT NULL,
  `instant_join` tinyint(1) NOT NULL DEFAULT '1',
  `instant_video` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups_members`
--

CREATE TABLE `groups_members` (
  `member` varchar(20) NOT NULL,
  `group_id` varchar(4) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '1',
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups_messages`
--

CREATE TABLE `groups_messages` (
  `id` int(11) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `submit_date` datetime NOT NULL,
  `topic_id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups_topics`
--

CREATE TABLE `groups_topics` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `creation_date` datetime NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `group_id` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `groups_videos`
--

CREATE TABLE `groups_videos` (
  `video` varchar(11) NOT NULL,
  `group_id` smallint(4) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT '1',
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `partner_applications`
--

CREATE TABLE `partner_applications` (
  `username` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(200) NOT NULL,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` varchar(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL DEFAULT '',
  `tags` varchar(256) NOT NULL DEFAULT '',
  `submit_date` datetime NOT NULL,
  `update_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `views` int(10) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `playlists_videos`
--

CREATE TABLE `playlists_videos` (
  `url` varchar(11) NOT NULL,
  `playlist_id` varchar(11) NOT NULL,
  `position` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `remember_me`
--

CREATE TABLE `remember_me` (
  `userid` varchar(250) NOT NULL,
  `userkey` varchar(250) NOT NULL,
  `createDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `response`
--

CREATE TABLE `response` (
  `id` int(1) NOT NULL,
  `response` smallint(2) DEFAULT '0',
  `last_update` datetime NOT NULL,
  `update_time` int(8) NOT NULL DEFAULT '4000',
  `ip` varchar(128) NOT NULL DEFAULT '',
  `title` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE `search` (
  `query` varchar(100) NOT NULL,
  `clicks` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spotlight`
--

CREATE TABLE `spotlight` (
  `title` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL DEFAULT 'SPOTLIGHTVIDEO',
  `description` varchar(1024) NOT NULL,
  `videos` varchar(1024) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscriber` varchar(20) NOT NULL,
  `subscription` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `displayname` varchar(120) NOT NULL,
  `email` varchar(60) NOT NULL,
  `vanity` varchar(255) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `registration_date` datetime NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `type` int(1) NOT NULL DEFAULT '1',
  `i_title` varchar(50) NOT NULL,
  `i_tags` varchar(256) NOT NULL,
  `i_name` varchar(30) NOT NULL DEFAULT '',
  `i_gender` int(1) NOT NULL DEFAULT '0',
  `i_relationship` int(1) NOT NULL DEFAULT '0',
  `i_desc` varchar(5000) NOT NULL,
  `i_about` varchar(2048) NOT NULL DEFAULT '',
  `i_books` varchar(128) NOT NULL DEFAULT '',
  `i_music` varchar(128) NOT NULL DEFAULT '',
  `i_hobbies` varchar(128) NOT NULL DEFAULT '',
  `i_movies` varchar(128) NOT NULL DEFAULT '',
  `i_website` varchar(128) NOT NULL DEFAULT '',
  `i_age` date NOT NULL DEFAULT '0000-00-00',
  `i_hometown` varchar(128) NOT NULL,
  `i_country` varchar(2) NOT NULL DEFAULT '',
  `i_occupation` varchar(128) NOT NULL,
  `i_companies` varchar(128) NOT NULL,
  `i_schools` varchar(128) NOT NULL,
  `i_info` varchar(128) NOT NULL DEFAULT '1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1',
  `s_age` tinyint(1) NOT NULL DEFAULT '0',
  `e_subscriptions` tinyint(1) NOT NULL DEFAULT '0',
  `e_comments` tinyint(1) NOT NULL DEFAULT '0',
  `e_messages` tinyint(1) DEFAULT '0',
  `videos_watched` smallint(5) NOT NULL DEFAULT '0',
  `profile_views` mediumint(7) NOT NULL DEFAULT '0',
  `video_views` int(11) NOT NULL DEFAULT '0',
  `video_views_month` int(11) NOT NULL DEFAULT '0',
  `video_views_week` int(11) NOT NULL DEFAULT '0',
  `video_views_day` int(11) NOT NULL DEFAULT '0',
  `subscribers` int(11) NOT NULL DEFAULT '0',
  `subscribers_day` int(11) NOT NULL DEFAULT '0',
  `subscribers_week` int(11) NOT NULL DEFAULT '0',
  `subscribers_month` int(11) NOT NULL DEFAULT '0',
  `subscriptions` mediumint(5) NOT NULL DEFAULT '0',
  `channel_comments` mediumint(5) NOT NULL DEFAULT '0',
  `videos` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `private_videos` int(4) UNSIGNED NOT NULL DEFAULT '0',
  `converting_videos` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `favorites` int(4) NOT NULL DEFAULT '0',
  `friends` int(4) NOT NULL DEFAULT '0',
  `c_background` varchar(6) NOT NULL DEFAULT 'ffffff',
  `c_background_image` varchar(128) NOT NULL DEFAULT '',
  `c_background_image_position` int(1) NOT NULL DEFAULT '0',
  `c_background_image_repeat` int(1) NOT NULL DEFAULT '0',
  `c_background_image_fixed` int(1) NOT NULL DEFAULT '0',
  `c_banner_image` varchar(128) NOT NULL DEFAULT '',
  `c_mbanner_image` varchar(128) NOT NULL DEFAULT '',
  `c_sideimage` varchar(128) NOT NULL DEFAULT '',
  `c_normal_header` varchar(6) NOT NULL DEFAULT '3399cc',
  `c_normal_inner` varchar(6) NOT NULL DEFAULT 'ffffff',
  `c_highlight_header` varchar(6) NOT NULL DEFAULT '3399cc',
  `c_highlight_inner` varchar(6) NOT NULL DEFAULT 'ecf4fb',
  `c_link_color` varchar(6) NOT NULL DEFAULT '0033CC',
  `c_header_font` varchar(6) NOT NULL DEFAULT '222222',
  `c_title_font` varchar(6) NOT NULL DEFAULT 'ffffff',
  `c_normal_font` varchar(6) NOT NULL DEFAULT '222222',
  `c_font` varchar(20) NOT NULL DEFAULT 'Arial',
  `c_theme` varchar(30) NOT NULL DEFAULT 'Grey',
  `c_subscriptions_box` int(1) NOT NULL DEFAULT '1',
  `c_subscribers_box` int(1) NOT NULL DEFAULT '1',
  `c_friends_box` int(11) NOT NULL DEFAULT '1',
  `c_bulletins_box` int(1) NOT NULL DEFAULT '1',
  `c_all` int(11) NOT NULL DEFAULT '1',
  `c_videos_box` int(1) NOT NULL DEFAULT '1',
  `c_favorites_box` int(1) NOT NULL DEFAULT '1',
  `c_playlists_box` int(11) NOT NULL DEFAULT '1',
  `c_comments_box` int(1) NOT NULL DEFAULT '1',
  `c_ratings_box` int(1) NOT NULL DEFAULT '1',
  `c_bigvideo_box` int(1) NOT NULL DEFAULT '1',
  `c_custom_box` int(11) NOT NULL DEFAULT '0',
  `c_blips_box` int(1) NOT NULL DEFAULT '0',
  `s_blips_username` varchar(45) DEFAULT NULL,
  `c_autoplay` int(11) NOT NULL,
  `c_featured_video` varchar(20) NOT NULL,
  `c_modules_l` varchar(100) NOT NULL DEFAULT 'recentactivity,subscriptions,blips',
  `c_modules_r` varchar(100) NOT NULL DEFAULT 'custombox,subscribers,friends,otherchannels,comments',
  `c_subscribers_rows` int(11) NOT NULL DEFAULT '2',
  `c_subscriptions_rows` int(11) NOT NULL DEFAULT '2',
  `c_friends_rows` int(11) NOT NULL DEFAULT '2',
  `c_blips_module` int(1) DEFAULT NULL,
  `custom_box_title` varchar(60) NOT NULL,
  `custom_box` varchar(1024) NOT NULL,
  `h_spotlight` int(1) NOT NULL DEFAULT '1',
  `h_subscriptions` int(1) NOT NULL DEFAULT '1',
  `h_recommended` int(1) NOT NULL DEFAULT '1',
  `h_featured` int(1) NOT NULL DEFAULT '1',
  `h_beingwatched` int(1) NOT NULL DEFAULT '1',
  `h_mostpop` int(1) NOT NULL DEFAULT '1',
  `h_activity` int(1) NOT NULL DEFAULT '1',
  `h_inbox` int(1) NOT NULL DEFAULT '1',
  `h_modules` varchar(100) NOT NULL DEFAULT 'h_subscriptions,h_recommended,h_activity,h_beingwatched,h_featured,h_mostpop',
  `h_beingwatched_limit` int(11) NOT NULL DEFAULT '4',
  `h_featured_limit` int(11) NOT NULL DEFAULT '4',
  `h_recommended_limit` int(11) NOT NULL DEFAULT '8',
  `h_subscriptions_limit` int(11) NOT NULL DEFAULT '8',
  `h_activity_limit` int(11) NOT NULL DEFAULT '4',
  `h_beingwatched_style` varchar(20) NOT NULL DEFAULT 'bigthumb',
  `h_featured_style` varchar(20) NOT NULL DEFAULT 'grid',
  `h_recommended_style` varchar(20) NOT NULL DEFAULT 'grid',
  `h_subscriptions_style` varchar(20) NOT NULL DEFAULT 'grid',
  `avatar` varchar(42) DEFAULT NULL,
  `is_avatar_video` int(1) NOT NULL DEFAULT '0',
  `is_verified` int(11) NOT NULL DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_moderator` tinyint(1) NOT NULL DEFAULT '0',
  `is_partner` tinyint(1) NOT NULL DEFAULT '0',
  `is_reuploader` int(11) NOT NULL DEFAULT '0',
  `has_terminated` tinyint(4) NOT NULL DEFAULT '0',
  `failed_login_attempt` datetime DEFAULT '0000-00-00 00:00:00',
  `ip_address` varchar(45) DEFAULT NULL,
  `failed_login_ip` varchar(45) DEFAULT NULL,
  `h_feed` tinyint(1) NOT NULL DEFAULT '0',
  `channels` varchar(125) NOT NULL DEFAULT ',',
  `channels_title` varchar(60) NOT NULL,
  `banner_link` varchar(128) NOT NULL DEFAULT '',
  `sideimage_link` varchar(128) NOT NULL DEFAULT '',
  `channel_new` int(11) NOT NULL DEFAULT '1',
  `moved_to` varchar(255) DEFAULT NULL COMMENT 'basically redirects the profile of this user to another profile',
  `username_change` datetime NOT NULL,
  `rank` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_block`
--

CREATE TABLE `users_block` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blocker` varchar(255) NOT NULL,
  `blocked` varchar(255) NOT NULL,
  `blocked_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_flags`
--

CREATE TABLE `users_flags` (
  `reason` int(1) NOT NULL DEFAULT '0',
  `username` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_friends`
--

CREATE TABLE `users_friends` (
  `id` int(10) NOT NULL,
  `friend_1` varchar(20) NOT NULL,
  `friend_2` varchar(20) NOT NULL,
  `submit_on` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_messages`
--

CREATE TABLE `users_messages` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `for_user` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` varchar(7500) NOT NULL,
  `attach_url` varchar(20) NOT NULL,
  `submit_on` datetime NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Message 1 = Shared videos 2 = Comments 3 = Video Responses 4 = Mentions (video) 5 = Mentions (channel)',
  `is_notification` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_themes`
--

CREATE TABLE `users_themes` (
  `by_user` varchar(20) NOT NULL,
  `background_repeat_check` int(11) NOT NULL,
  `box_opacity` decimal(11,1) NOT NULL,
  `wrapper_opacity` decimal(11,1) NOT NULL,
  `font` varchar(20) NOT NULL,
  `body_text_color` varchar(10) NOT NULL,
  `link_color` varchar(10) NOT NULL,
  `title_text_color` varchar(10) NOT NULL,
  `box_background_color` varchar(10) NOT NULL,
  `wrapper_link_color` varchar(10) NOT NULL,
  `wrapper_text_color` varchar(10) NOT NULL,
  `wrapper_color` varchar(10) NOT NULL,
  `background_color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `url` varchar(11) NOT NULL,
  `file_url` varchar(20) NOT NULL,
  `hd` tinyint(1) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `tags` varchar(128) NOT NULL,
  `uploaded_by` varchar(20) NOT NULL,
  `uploaded_on` datetime NOT NULL,
  `privacy` int(1) NOT NULL DEFAULT '1',
  `category` smallint(2) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `favorites` int(11) NOT NULL DEFAULT '0',
  `uploaded_by_banned` tinyint(1) NOT NULL DEFAULT '0',
  `length` int(4) NOT NULL DEFAULT '0',
  `file_name` varchar(128) NOT NULL DEFAULT '',
  `delete_id` varchar(12) NOT NULL DEFAULT '',
  `address` varchar(100) NOT NULL DEFAULT '',
  `country` varchar(2) NOT NULL DEFAULT '',
  `date_recorded` date NOT NULL DEFAULT '0000-00-00',
  `1stars` smallint(4) NOT NULL DEFAULT '0',
  `2stars` smallint(4) NOT NULL DEFAULT '0',
  `3stars` smallint(4) NOT NULL DEFAULT '0',
  `4stars` smallint(4) NOT NULL DEFAULT '0',
  `5stars` smallint(4) NOT NULL DEFAULT '0',
  `e_comments` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = None, 1 = Everyone, 2 = Only friends',
  `e_ratings` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = None, 1 = Everyone',
  `reupload` int(11) NOT NULL DEFAULT '0',
  `is_deleted` text,
  `age_restricted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_comments`
--

CREATE TABLE `videos_comments` (
  `id` int(11) NOT NULL,
  `url` varchar(11) NOT NULL,
  `content` varchar(500) NOT NULL,
  `by_user` varchar(20) NOT NULL,
  `submit_on` datetime NOT NULL,
  `likes` smallint(6) NOT NULL DEFAULT '0',
  `dislikes` smallint(6) NOT NULL DEFAULT '0',
  `spam` int(11) NOT NULL DEFAULT '0',
  `attach_url` varchar(11) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_favorites`
--

CREATE TABLE `videos_favorites` (
  `username` varchar(20) NOT NULL,
  `url` varchar(11) NOT NULL,
  `submit_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_flags`
--

CREATE TABLE `videos_flags` (
  `url` varchar(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `submit_date` datetime NOT NULL,
  `number` int(11) DEFAULT NULL,
  `additional_info` mediumtext,
  `resolved` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_links`
--

CREATE TABLE `videos_links` (
  `link` varchar(312) NOT NULL,
  `url` varchar(11) NOT NULL,
  `clicks` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_ratings`
--

CREATE TABLE `videos_ratings` (
  `url` varchar(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `rating` tinyint(1) NOT NULL,
  `submit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_responses`
--

CREATE TABLE `videos_responses` (
  `id` int(11) NOT NULL,
  `vid_id` varchar(64) NOT NULL,
  `basevid_id` varchar(140) NOT NULL,
  `from_user` varchar(120) NOT NULL,
  `by_user` varchar(120) NOT NULL,
  `is_added` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_spam`
--

CREATE TABLE `videos_spam` (
  `id` int(11) NOT NULL,
  `by_user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `videos_uploads`
--

CREATE TABLE `videos_uploads` (
  `iuvid` int(11) NOT NULL,
  `vid` binary(8) NOT NULL,
  `fileName` varchar(512) NOT NULL,
  `fileSize` varchar(16) NOT NULL DEFAULT '0',
  `createDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(32) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'0',
  `updateDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `views_day`
--

CREATE TABLE `views_day` (
  `url` varchar(11) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `submit_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_log`
--
ALTER TABLE `access_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `being_watched`
--
ALTER TABLE `being_watched`
  ADD UNIQUE KEY `url` (`url`),
  ADD KEY `url_2` (`submit_date`,`url`) USING BTREE;

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `bulletins`
--
ALTER TABLE `bulletins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulletins_comments`
--
ALTER TABLE `bulletins_comments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `by_user` (`by_user`,`bulletin_id`);

--
-- Indexes for table `bulletins_new`
--
ALTER TABLE `bulletins_new`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `channel_comments`
--
ALTER TABLE `channel_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `converting`
--
ALTER TABLE `converting`
  ADD PRIMARY KEY (`url`);

--
-- Indexes for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_date` (`ip_address`,`date`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_members`
--
ALTER TABLE `groups_members`
  ADD UNIQUE KEY `member` (`member`,`group_id`);

--
-- Indexes for table `groups_messages`
--
ALTER TABLE `groups_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_topics`
--
ALTER TABLE `groups_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_videos`
--
ALTER TABLE `groups_videos`
  ADD UNIQUE KEY `video` (`video`,`group_id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists_videos`
--
ALTER TABLE `playlists_videos`
  ADD UNIQUE KEY `url` (`url`,`playlist_id`);

--
-- Indexes for table `response`
--
ALTER TABLE `response`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `search`
--
ALTER TABLE `search`
  ADD PRIMARY KEY (`query`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD UNIQUE KEY `subscriber` (`subscriber`,`subscription`) USING BTREE,
  ADD KEY `submit_date` (`submit_date`,`subscriber`,`subscription`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `username` (`username`) USING BTREE,
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `displayname` (`displayname`),
  ADD KEY `video_views` (`video_views`,`username`) USING BTREE,
  ADD KEY `video_views_month` (`video_views_month`),
  ADD KEY `video_views_week` (`video_views_week`),
  ADD KEY `video_views_day` (`video_views_day`),
  ADD KEY `is_partner` (`is_partner`),
  ADD KEY `subscribers` (`subscribers`),
  ADD KEY `subscribers_day` (`subscribers_day`),
  ADD KEY `subscribers_week` (`subscribers_week`),
  ADD KEY `subscribers_month` (`subscribers_month`),
  ADD KEY `is_reuploader` (`is_reuploader`),
  ADD KEY `is_banned` (`is_banned`,`username`) USING BTREE;

--
-- Indexes for table `users_block`
--
ALTER TABLE `users_block`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_block_pair` (`blocker`,`blocked`),
  ADD KEY `idx_blocker` (`blocker`),
  ADD KEY `idx_blocked` (`blocked`);

--
-- Indexes for table `users_flags`
--
ALTER TABLE `users_flags`
  ADD UNIQUE KEY `reason` (`reason`,`username`);

--
-- Indexes for table `users_friends`
--
ALTER TABLE `users_friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `friend_1` (`friend_1`,`friend_2`) USING BTREE,
  ADD KEY `submit_on` (`submit_on`),
  ADD KEY `friend_1_3` (`status`,`friend_1`,`friend_2`,`submit_on`) USING BTREE;

--
-- Indexes for table `users_messages`
--
ALTER TABLE `users_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `for_user` (`for_user`);

--
-- Indexes for table `users_themes`
--
ALTER TABLE `users_themes`
  ADD PRIMARY KEY (`by_user`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`url`);
ALTER TABLE `videos` ADD FULLTEXT KEY `idx_fulltext_title` (`title`);
ALTER TABLE `videos` ADD FULLTEXT KEY `idx_fulltext_title_description` (`title`,`description`);
ALTER TABLE `videos` ADD FULLTEXT KEY `idx_fulltext_title_description_tags` (`title`,`description`,`tags`);
ALTER TABLE `videos` ADD FULLTEXT KEY `idx_fulltext_tags` (`tags`);

--
-- Indexes for table `videos_comments`
--
ALTER TABLE `videos_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submit_on` (`submit_on`),
  ADD KEY `id` (`id`,`url`,`content`,`by_user`) USING BTREE,
  ADD KEY `content` (`content`);

--
-- Indexes for table `videos_favorites`
--
ALTER TABLE `videos_favorites`
  ADD UNIQUE KEY `username` (`username`,`url`),
  ADD KEY `submit_on` (`submit_on`);

--
-- Indexes for table `videos_flags`
--
ALTER TABLE `videos_flags`
  ADD UNIQUE KEY `url` (`url`,`username`);

--
-- Indexes for table `videos_links`
--
ALTER TABLE `videos_links`
  ADD UNIQUE KEY `link` (`link`,`url`),
  ADD KEY `clicks` (`clicks`);

--
-- Indexes for table `videos_ratings`
--
ALTER TABLE `videos_ratings`
  ADD UNIQUE KEY `url` (`url`,`username`) USING BTREE,
  ADD KEY `url_2` (`url`,`username`,`rating`,`submit_date`) USING BTREE;

--
-- Indexes for table `videos_responses`
--
ALTER TABLE `videos_responses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos_uploads`
--
ALTER TABLE `videos_uploads`
  ADD PRIMARY KEY (`iuvid`),
  ADD UNIQUE KEY `vid_2` (`vid`),
  ADD KEY `vid` (`vid`),
  ADD KEY `fileName` (`fileName`),
  ADD KEY `status` (`status`),
  ADD KEY `ipid` (`username`),
  ADD KEY `fileSize` (`fileSize`);

--
-- Indexes for table `views_day`
--
ALTER TABLE `views_day`
  ADD UNIQUE KEY `url` (`url`,`submit_date`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_log`
--
ALTER TABLE `access_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulletins`
--
ALTER TABLE `bulletins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulletins_comments`
--
ALTER TABLE `bulletins_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bulletins_new`
--
ALTER TABLE `bulletins_new`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `channel_comments`
--
ALTER TABLE `channel_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contest`
--
ALTER TABLE `contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_login_attempts`
--
ALTER TABLE `failed_login_attempts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` smallint(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups_messages`
--
ALTER TABLE `groups_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups_topics`
--
ALTER TABLE `groups_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `response`
--
ALTER TABLE `response`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_block`
--
ALTER TABLE `users_block`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_friends`
--
ALTER TABLE `users_friends`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_messages`
--
ALTER TABLE `users_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos_comments`
--
ALTER TABLE `videos_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos_responses`
--
ALTER TABLE `videos_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `videos_uploads`
--
ALTER TABLE `videos_uploads`
  MODIFY `iuvid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
