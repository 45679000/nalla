--add your changes to the database here
SELECT sale_no, broker, category, 
(CASE WHEN comment IS NULL THEN '' ELSE comment END) AS comment, 
(CASE WHEN rp IS NULL THEN '' ELSE 'RP' END) AS rp, 
(CASE WHEN ra IS NULL THEN '' ELSE 'RA' END) AS ra, 
(CASE WHEN type IS NULL THEN '' ELSE type END) AS type, 
lot, a.mark, a.grade, manf_date, value, ra, rp, invoice, standard,
type, net, pkgs, kgs, sale_price, buyer_package, b.maxval, b.minval, brokers.name AS brokername,
DATE('1899-12-30') + INTERVAL manf_date DAY AS manf_date 
FROM closing_cat a
LEFT JOIN brokers ON brokers.code = a.broker
LEFT JOIN (SELECT min(value) AS minval, max(value) AS maxval, mark, grade
FROM `closing_cat`
WHERE sale_no ='2021-12'
GROUP BY grade, mark) AS b
ON b.grade = a.grade AND b.mark = a.mark
WHERE sale_no = '2021-12' AND broker = 'ANJL'  



ORDER BY `manf_date`  DESC


  SELECT a.assigned_user_id as id, a.first_name, sum(application) Application,
  sum(conditional)+ sum(un_conditional) AS offers, 
  sum(deposit) AS Deposit, 
  ((sum(application)*1 + (sum(conditional)+ sum(un_conditional))*2) + (sum(deposit) * 3)) AS points
  FROM( SELECT assigned_user_id, users.first_name, 
  Count(CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' end) AS `application`, 
  Count(CASE WHEN `leads`.`status` = 'Converted' THEN 'Conditional' end) AS `conditional`, 
  Count(CASE WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`, 
  Count(CASE WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' end) AS `deposit` 
  FROM `users` RIGHT JOIN leads ON users.id = leads.assigned_user_id 
  WHERE leads.deleted = 0 AND ((`leads`.`status` = 'In Process') 
  OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') OR (`leads`.`status` = 'Deposit')) 
  AND (CAST(leads.date_entered AS DATE) BETWEEN '2021-05-01' AND '2021-06-30') 
  GROUP BY leads.assigned_user_id 

  UNION 
  SELECT assigned_user_id, users.first_name, 
  Count(CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' end) AS `application`, 
  Count(CASE WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' end) AS `conditional`, 
  Count(CASE WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`, 
  Count(CASE WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' end) AS `deposit` 
  FROM `users` 
  RIGHT JOIN leads ON users.id = leads.assigned_user_id RIGHT JOIN leads_audit ON leads.id = leads_audit.parent_id 
  WHERE leads.deleted = 0 AND (field_name = 'status' AND ((`after_value_string` = 'In Process') 
  OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
  OR (`after_value_string` = 'Deposit')) AND (CAST(leads_audit.date_created AS DATE) 
  BETWEEN '2021-05-01' AND '2021-06-30')) GROUP BY leads.assigned_user_id

  UNION 
  SELECT users.id, users.first_name, 0,0,0,0 
  FROM users WHERE users.status = 'Active' AND users.is_admin = false ) AS a 
  GROUP BY a.assigned_user_id ORDER BY points DESC;


SELECT leads.first_name, leads.last_name 
FROM leads_audit 
INNER JOIN leads ON leads.id = leads_audit.parent_id
WHERE leads_audit.created_by='4b963ed5-01b5-4b3b-7ccf-5f48e818367e' AND leads_audit.date_created > '2021-05-01'
AND (leads_audit.`after_value_string` = 'Converted' OR leads_audit.after_value_string = 'Recycled');



SELECT * FROM( SELECT assigned_user_id, Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,
`leads_cstm`.`program_c` AS `program_c`, `leads_cstm`.`term_c` AS `term_c`, `leads_cstm`.`country_c` AS 
`country_c`, `leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`, 
`vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`,
 CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' WHEN `leads`.`status` = 'New' THEN 'Enquiry' 
 WHEN `leads`.`status` = 'Converted' THEN 'Conditional' WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional'
WHEN `leads`.`status` = 'Enrolled' THEN 'Enrolled' WHEN `leads`.`status` = 'Granted' THEN 'Granted' 
WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' WHEN `leads`.`status` = 'Dead' THEN 'visa_processing' end AS `status`
FROM `users` 
RIGHT JOIN leads ON users.id = leads.assigned_user_id 
INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id 
LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id`
WHERE leads.deleted = 0 AND ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') 
OR (`leads`.`status` = 'Recycled') OR (`leads`.`status` = 'Deposit')) AND (CAST(leads.date_entered AS DATE)
 BETWEEN '2021-05-01' AND '2021-06-30') AND `leads`.`assigned_user_id` = '1ee041a7-9b96-9f5c-e0a3-60d42201daec' 
 AND (`leads`.`status` = 'Converted' OR `leads`.`status` = 'Recycled') 
 GROUP BY leads.assigned_user_id, leads.id 
 UNION 
 SELECT assigned_user_id, Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,
 `leads_cstm`.`program_c` AS `program_c`, `leads_cstm`.`term_c` AS `term_c`, `leads_cstm`.`country_c` AS `country_c`, 
 `leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`, 
 `vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`, 
 CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' WHEN 
 `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry' WHEN `leads_audit`.`after_value_string` = 'Converted' 
 THEN 'Conditional' WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' 
 WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled' 
 WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted' 
 WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' 
 WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'visa_processing' end AS `status` 
 FROM `users` RIGHT JOIN leads ON users.id = leads.assigned_user_id 
 RIGHT JOIN leads_audit ON leads.id = leads_audit.parent_id 
 INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id 
 LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id` 
 WHERE leads.deleted = 0 AND (field_name = 'status' AND ((`after_value_string` = 'In Process') 
 OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
 OR (`after_value_string` = 'Deposit')) AND (CAST(leads_audit.date_created AS DATE) 
 BETWEEN '2021-05-01' AND '2021-06-30')) AND `leads`.`assigned_user_id` = '1ee041a7-9b96-9f5c-e0a3-60d42201daec' 
 AND (`leads_audit`.`after_value_string` = 'Converted' OR `leads_audit`.`after_value_string` = 'Recycled' ) 
 GROUP BY leads.assigned_user_id, leads.id) AS a
