CREATE TABLE `banned_users` (
  `user_id` int,
  `reason` varchar(250),
  `date_of_ban` date,
  `date_of_unban` date,
  PRIMARY KEY (`user_id`)
);
CREATE TABLE `user` (
  `user_id` int AUTO_INCREMENT,
  `first_name` varchar(50),
  `last_name` varchar(50),
  `date_of_birth` date,
  `gender` enum('Male', 'Female', 'Prefer not to say'),
  `profession` varchar(50),
  `current_location` varchar(50),
  `profile_picture` varchar(250),
  `description` varchar(250),
  `email` varchar(50),
  `password` varchar(15),
  `mobile_number` int,
  `type` enum('administrator', 'personal use'),
  PRIMARY KEY (`user_id`)
);
CREATE TABLE `organisation` (
  `org_id` int AUTO_INCREMENT,
  `name` varchar(50),
  `date_established` date,
  `description` varchar(250),
  `profile_picture` varchar(50),
  `user_id` int,
  `email` varchar(50),
  `contact_number` int,
  PRIMARY KEY (`org_id`)
);
CREATE TABLE `user_skills` (
  `u_skill_id` int AUTO_INCREMENT,
  `user_id` int,
  `skill_id` int,
  PRIMARY KEY (`u_skill_id`)
);
CREATE TABLE `vacancy` (
  `vacancy_id` int AUTO_INCREMENT,
  `title` varchar(50),
  `description` varchar(250),
  `date_created` date,
  `org_id` int,
  `required_experience` varchar(250),
  PRIMARY KEY (`vacancy_id`)
);
CREATE TABLE `skills` (
  `skill_id` int AUTO_INCREMENT,
  `title` varchar(50),
  `description` varchar(250),
  PRIMARY KEY (`skill_id`)
);
CREATE TABLE `user_qualification` (
  `u_qualification_id` int AUTO_INCREMENT,
  `user_id` int,
  `qualification_id` int,
  `date_obtained` date,
  PRIMARY KEY (`u_qualification_id`)
);
CREATE TABLE `org_astrological` (
  `org_id` int,
  `star_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  `moon_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  `rising_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  PRIMARY KEY (`org_id`)
);
CREATE TABLE `qualification` (
  `qualification_id` int AUTO_INCREMENT,
  `description` varchar(250),
  `title` varchar(50),
  `institute` varchar(250),
  `level` int,
  PRIMARY KEY (`qualification_id`)
);
CREATE TABLE `employment_history` (
  `emp_his_id` int AUTO_INCREMENT,
  `user_id` int,
  `org_id` int,
  `start_date` date,
  `end_date` date,
  `position` varchar(50),
  PRIMARY KEY (`emp_his_id`)
);
CREATE TABLE `vacancy_skills` (
  `v_skill_id` int AUTO_INCREMENT,
  `skill_id` int,
  `vacancy_id` int,
  PRIMARY KEY (`v_skill_id`)
);
CREATE TABLE `connection` (
  `connection_id` int AUTO_INCREMENT,
  `user_inviter` varchar(5),
  `user_invited` varchar(5),
  `state` enum('accepted', 'pending'),
  PRIMARY KEY (`connection_id`)
);
CREATE TABLE `user_astrological` (
  `user_id` int,
  `star_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  `moon_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  `rising_sign` enum(
    'Aries',
    'Taurus',
    'Gemini',
    'Cancer',
    'Leo',
    'Virgo',
    'Libra',
    'Scorpio',
    'Sagittarius',
    'Capricorn',
    'Aquarius',
    'Pisces'
  ),
  PRIMARY KEY (`user_id`)
);
CREATE TABLE `posts` (
  `post_id` int AUTO_INCREMENT,
  `user_id` int,
  `post` varchar(250),
  `attached_photo` varchar(250),
  `date_of_post` date,
  `time_of_post` timestamp,
  PRIMARY KEY (`post_id`)
);