-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Maio-2020 às 06:49
-- Versão do servidor: 10.1.34-MariaDB
-- PHP Version: 5.6.37

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `lousaonline`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `complement` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `course_teacher_user_id` int(11) NOT NULL,
  `course_student_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_course` date NOT NULL,
  `hour_init` time NOT NULL,
  `hour_end` time NOT NULL,
  `description` text NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'I'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `courses`
--

INSERT INTO `courses` (`id`, `name`, `date_created`, `date_course`, `hour_init`, `hour_end`, `description`, `status`) VALUES
(2, 'História Contemporânea', '2020-05-12 03:57:51', '2020-05-20', '15:00:00', '16:00:00', 'Cras commodo vulputate dui. Duis suscipit massa. Vivamus tempor. Maecenas at diam. Mauris justo risus, consequat sed, condimentum a, hendrerit id, nisi.', 'A'),
(3, 'Matemática básica aplicada', '2020-05-12 03:48:19', '2020-05-19', '18:00:00', '19:30:00', 'Esta é a descrição do curso lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent faucibus. Mauris euismod. Nam commodo dolor pellentesque tellus. Proin sodales est id lorem. Phasellus sodales purus sit amet est. Phasellus sit amet nibh. Donec lobortis venenatis justo. Aenean scelerisque, quam sed aliquam scelerisque, nunc felis congue lectus, sed eleifend purus arcu nec sem. Praesent dolor. Nunc egestas laoreet quam.', 'A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `installments`
--

CREATE TABLE `installments` (
  `id` int(11) NOT NULL,
  `number_installments` int(11) DEFAULT NULL,
  ` due_date` date DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `payment_purchase_id` int(11) NOT NULL,
  `payment_purchase_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `institution`
--

CREATE TABLE `institution` (
  `user_id` int(11) NOT NULL,
  `cnpj` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `institution`
--

INSERT INTO `institution` (`user_id`, `cnpj`) VALUES
(13, '342342');

-- --------------------------------------------------------

--
-- Estrutura da tabela `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `forma` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `purchase_id` int(11) NOT NULL,
  `purchase_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `Curso` varchar(255) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `content` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `cpf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `students`
--

INSERT INTO `students` (`user_id`, `cpf`) VALUES
(15, '657657576');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers`
--

CREATE TABLE `teachers` (
  `user_id` int(11) NOT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `teachers`
--

INSERT INTO `teachers` (`user_id`, `institution_id`, `cpf`) VALUES
(14, 13, '24234242');

-- --------------------------------------------------------

--
-- Estrutura da tabela `teachers_courses`
--

CREATE TABLE `teachers_courses` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relação de professores com um curso';

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `registration` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lastupdate` timestamp NULL DEFAULT NULL,
  `lastaccess` timestamp NULL DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `sex` varchar(11) DEFAULT NULL,
  `datebirth` date NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `cell` varchar(25) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(2) NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `registration`, `lastupdate`, `lastaccess`, `name`, `lastname`, `sex`, `datebirth`, `telephone`, `cell`, `email`, `thumb`, `login`, `password`, `usertype`, `status`) VALUES
(13, '2020-05-11 17:36:43', '2020-05-12 03:58:33', NULL, 'Escola', 'João Ubaldino', NULL, '0000-00-00', '3232432', '242342423sdfsds', 'adsfds@kdfjds.com', NULL, 'sdfsdfsd', 'sdfsdds', 'I', 'A'),
(14, '2020-05-11 17:37:40', '2020-05-12 04:05:19', NULL, 'Geraldo', 'Passos', 'M', '2000-12-10', '242423', '2423423s', 'dssds@dsjs.com', NULL, 'dsfsdfsd', 'sdfsd', 'T', 'A'),
(15, '2020-05-11 19:36:46', '2020-05-11 19:49:01', NULL, 'sadasdas', 'asdasd', 'F', '1987-12-10', '76565775657', '68768768', 'terterterer@kjdfflk.com', NULL, 'gggfhg', '$1$Tm1.g55.$HR4h2ACOuc1pQ4s1u7JmR.', 'S', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`,`usuario_id`),
  ADD KEY `fk_Endereço_usuario1_idx` (`usuario_id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`,`course_id`) USING BTREE;

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`id`,`payment_id`,`payment_purchase_id`,`payment_purchase_user_id`),
  ADD KEY `fk_installments_payment1_idx` (`payment_id`,`payment_purchase_id`,`payment_purchase_user_id`);

--
-- Indexes for table `institution`
--
ALTER TABLE `institution`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`,`purchase_id`,`purchase_user_id`),
  ADD KEY `fk_payment_purchase1_idx` (`purchase_id`,`purchase_user_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `fk_purchase_user1_idx` (`user_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`,`course_id`),
  ADD KEY `fk_schedule_course1_idx` (`course_id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `teachers_courses`
--
ALTER TABLE `teachers_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_course_id` (`course_id`),
  ADD KEY `fk_teacher_user_id` (`teacher_user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers_courses`
--
ALTER TABLE `teachers_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `fk_Endereço_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `installments`
--
ALTER TABLE `installments`
  ADD CONSTRAINT `fk_installments_payment1` FOREIGN KEY (`payment_id`,`payment_purchase_id`,`payment_purchase_user_id`) REFERENCES `payment` (`id`, `purchase_id`, `purchase_user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `institution`
--
ALTER TABLE `institution`
  ADD CONSTRAINT `fk_estabelecimento_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_purchase1` FOREIGN KEY (`purchase_id`,`purchase_user_id`) REFERENCES `purchase` (`id`, `user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `fk_purchase_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `fk_teacher_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `teachers_courses`
--
ALTER TABLE `teachers_courses`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `fk_teacher_user_id` FOREIGN KEY (`id`) REFERENCES `teachers` (`user_id`);
COMMIT;
