
CREATE TABLE `b2c` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `conversation_id` varchar(60) NOT NULL,
  `request_code` varchar(10) NOT NULL,
  `result_code` varchar(10) DEFAULT '2',
  `description` text DEFAULT NULL,
  `trx_id` varchar(25) DEFAULT NULL,
  `trx_amount` varchar(10) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `invoice` varchar(10) NOT NULL,
  `receiver_name` varchar(60) DEFAULT NULL,
  `actual_data` text DEFAULT NULL,
  `date` date NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b2c`
--
ALTER TABLE `b2c`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trx_id` (`trx_id`,`invoice`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b2c`
--
ALTER TABLE `b2c`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
