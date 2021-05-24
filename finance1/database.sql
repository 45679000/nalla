SELECT users.id, users.is_admin, users.status, users.first_name, users.last_name, 
(CASE WHEN a.Application IS NULL THEN 0 ELSE a.Application END) AS Application,
(CASE WHEN a.Conditional IS NULL THEN 0 ELSE a.Conditional END) AS Conditional,
(CASE WHEN a.un_conditional IS NULL THEN 0 ELSE a.un_conditional END) AS un_conditional,
(CASE WHEN a.Deposit IS NULL THEN 0 ELSE a.Deposit END) AS Deposit,

(((CASE WHEN a.Deposit IS NULL THEN 0 ELSE a.Deposit END)*3) + (((CASE WHEN a.Conditional IS NULL THEN 0 ELSE a.Conditional END)+
(CASE WHEN a.un_conditional IS NULL THEN 0 ELSE a.un_conditional END))*2) + ((CASE WHEN a.Application IS NULL THEN 0 ELSE a.Application END)*1)) AS points
FROM
(SELECT assigned_user_id,  leads_audit.date_created, 
                                            Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application'
                                              end) AS `application`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry'
                                              end) AS `enquiry`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional'
                                              end) AS `conditional`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional'
                                              end) AS `un_conditional`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled'
                                              end) AS `enrolled`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted'
                                              end) AS `granted`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit'
                                              end) AS `deposit`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'Visa Processing'
                                              end) AS `visa_processing`
        FROM `users`
        RIGHT JOIN leads ON users.id = leads.assigned_user_id
        LEFT JOIN leads_audit ON leads.id = leads_audit.parent_id
        WHERE field_name = 'status' AND ((`after_value_string` = 'In Process') OR 
        (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') OR (`after_value_string` = 'Deposit')) AND users.status = 'Active' 
        AND ((leads.date_entered BETWEEN '12/03/2021' AND '12/18/2021') OR (leads_audit.date_created BETWEEN '12/03/2021' AND '12/18/2021') OR (leads.date_modified BETWEEN '12/03/2021' AND '12/18/2021')
        GROUP BY leads.assigned_user_id) AS a
        RIGHT JOIN users ON a.assigned_user_id = users.id
        WHERE users.status = 'Active' AND is_admin = 0 ORDER BY points DESC



        SELECT assigned_user_id, users.first_name, leads_audit.date_created, 
                                            Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application'
                                              end) AS `application`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry'
                                              end) AS `enquiry`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional'
                                              end) AS `conditional`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional'
                                              end) AS `un_conditional`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled'
                                              end) AS `enrolled`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted'
                                              end) AS `granted`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit'
                                              end) AS `deposit`,
                                          Count(
                                              CASE
                                              WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'Visa Processing'
                                              end) AS `visa_processing`
        FROM `users`
        RIGHT JOIN leads ON users.id = leads.assigned_user_id
        LEFT JOIN leads_audit ON leads.id = leads_audit.parent_id
        WHERE field_name = 'status' AND ((`after_value_string` = 'In Process') OR 
        (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') OR (`after_value_string` = 'Deposit')) AND users.status = 'Active'
        AND ((leads.date_entered BETWEEN '2021-04-15' AND '2021-04-22') OR (leads_audit.date_created BETWEEN '2021-04-15' AND '2021-04-22') OR 						(leads.date_modified BETWEEN '2021-04-15' AND '2021-04-22'))
        GROUP BY leads.assigned_user_id, leads.id





Count (CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' end) AS `application`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry' end) AS `enquiry`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' end) AS `conditional`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled' end) AS `enrolled`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted' end) AS `granted`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' end) AS `deposit`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'Visa Processing' end) AS `visa_processing`






SELECT assigned_user_id, users.first_name, leads_audit.date_created, 
Count (CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' end) AS `application`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry' end) AS `enquiry`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' end) AS `conditional`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled' end) AS `enrolled`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted' end) AS `granted`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' end) AS `deposit`,
Count( CASE WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'Visa Processing' end) AS `visa_processing`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
LEFT JOIN leads_audit ON leads.id = leads_audit.parent_id
WHERE (field_name = 'status' AND ((`after_value_string` = 'In Process') OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
OR (`after_value_string` = 'Deposit')) AND (leads_audit.date_created BETWEEN '2021-04-14' AND '2021-04-23'))
GROUP BY leads.assigned_user_id

UNION

SELECT assigned_user_id, users.first_name, leads.date_entered, 
Count(CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' end) AS `application`,
Count( CASE WHEN `leads`.`status` = 'New' THEN 'Enquiry' end) AS `enquiry`,
Count(CASE WHEN `leads`.`status` = 'Converted' THEN 'Conditional' end) AS `conditional`,
Count(CASE WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
Count( CASE WHEN `leads`.`status` = 'Enrolled' THEN 'Enrolled' end) AS `enrolled`,
Count(CASE WHEN `leads`.`status` = 'Granted' THEN 'Granted' end) AS `granted`,
Count(CASE WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' end) AS `deposit`,
Count(CASE WHEN `leads`.`status` = 'Dead' THEN 'Visa Processing' end) AS `visa_processing`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
WHERE ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') 
OR (`leads`.`status` = 'Deposit')) AND (leads.date_entered BETWEEN '2021-04-14' AND '2021-04-23')
GROUP BY leads.assigned_user_id




SELECT a.assigned_user_id, first_name, sum(application) Application, sum(conditional)+ sum(un_conditional) AS offers, sum(enrolled) AS enrolled, sum(deposit) AS deposit
FROM(
SELECT assigned_user_id, users.first_name,  
Count(CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' end) AS `application`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' end) AS `conditional`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled' end) AS `enrolled`,
Count(CASE WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' end) AS `deposit`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
LEFT JOIN leads_audit ON leads.id = leads_audit.parent_id
WHERE (field_name = 'status' AND ((`after_value_string` = 'In Process') OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
OR (`after_value_string` = 'Deposit')) AND (leads_audit.date_created BETWEEN '2021-04-14' AND '2021-04-23'))
GROUP BY leads.assigned_user_id

UNION

SELECT assigned_user_id, users.first_name,
Count(CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' end) AS `application`,
Count(CASE WHEN `leads`.`status` = 'Converted' THEN 'Conditional' end) AS `conditional`,
Count(CASE WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
Count(CASE WHEN `leads`.`status` = 'Enrolled' THEN 'Enrolled' end) AS `enrolled`,
Count(CASE WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' end) AS `deposit`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
WHERE ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') 
OR (`leads`.`status` = 'Deposit')) AND (leads.date_entered BETWEEN '2021-04-14' AND '2021-04-23')
GROUP BY leads.assigned_user_id) AS a
GROUP BY a.assigned_user_id




SELECT a.assigned_user_id, a.first_name, 
Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`,
`leads_cstm`.`intake_c`      AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`,
`leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`,
`vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`
FROM(
SELECT assigned_user_id, users.first_name,
CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' end) AS `application`,
CASE WHEN `leads`.`status` = 'Converted' THEN 'Conditional' end) AS `conditional`,
CASE WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
CASE WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' end) AS `deposit`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id
LEFT JOIN `vw_leads_accounts`.`id` = `leads`.`id`
WHERE ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') 
OR (`leads`.`status` = 'Deposit')) AND (leads.date_entered BETWEEN '2021-04-14' AND '2021-04-22')
GROUP BY leads.assigned_user_id, leads.id
    
    EXCEPT
    
SELECT a.assigned_user_id, a.first_name, 
Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`,
`leads_cstm`.`intake_c`      AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`,
`leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`,
`vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id` 
CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' end) AS `application`,
CASE WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' end) AS `conditional`,
CASE WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' end) AS `un_conditional`,
CASE WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' end) AS `deposit`
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
RIGHT JOIN leads_audit ON leads.id = leads_audit.parent_id
INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id
LEFT JOIN `vw_leads_accounts`.`id` = `leads`.`id`

WHERE (field_name = 'status' AND ((`after_value_string` = 'In Process') OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
OR (`after_value_string` = 'Deposit')) AND (leads_audit.date_created BETWEEN '2021-04-14' AND '2021-04-22'))
GROUP BY leads.assigned_user_id, leads.id) AS a












SELECT *
FROM(
SELECT assigned_user_id,  
Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`,
`leads_cstm`.`intake_c`      AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`,
`leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`,
`vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`,  

 CASE
     WHEN `leads`.`status` = 'In Process' THEN
    'Application'
    WHEN `leads`.`status` = 'New' THEN 'Enquiry'
    WHEN `leads`.`status` = 'Converted' THEN
    'Conditional'
    WHEN `leads`.`status` = 'Recycled' THEN
    'un_conditional'
    WHEN `leads`.`status` = 'Enrolled' THEN 'Enrolled'
    WHEN `leads`.`status` = 'Granted' THEN 'Granted'
    WHEN `leads`.`status` = 'Deposit' THEN 'Deposit'
    WHEN `leads`.`status` = 'Dead' THEN
    'visa_processing'
end   AS `status` 
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id
LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id`
WHERE ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') 
OR (`leads`.`status` = 'Deposit')) AND (leads.date_entered BETWEEN '2021-04-14' AND '2021-04-22')
GROUP BY leads.assigned_user_id, leads.id
    
    EXCEPT
    
SELECT assigned_user_id,  
Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`,
`leads_cstm`.`intake_c`      AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`,
`leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`,
`vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`, 

 CASE
     WHEN `leads_audit`.`after_value_string` = 'In Process' THEN
    'Application'
    WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry'
    WHEN `leads_audit`.`after_value_string` = 'Converted' THEN
    'Conditional'
    WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN
    'un_conditional'
    WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled'
    WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted'
    WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit'
    WHEN `leads_audit`.`after_value_string` = 'Dead' THEN
    'visa_processing'
end   AS `status` 
FROM `users`
RIGHT JOIN leads ON users.id = leads.assigned_user_id
RIGHT JOIN leads_audit ON leads.id = leads_audit.parent_id
INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id
LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id`

WHERE (field_name = 'status' AND ((`after_value_string` = 'In Process') OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') 
OR (`after_value_string` = 'Deposit')) AND (leads_audit.date_created BETWEEN '2021-04-14' AND '2021-04-22'))
GROUP BY leads.assigned_user_id, leads.id) AS a


































SELECT * FROM( SELECT assigned_user_id, Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`, `leads_cstm`.`intake_c` AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`, `leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`, `vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`, CASE WHEN `leads`.`status` = 'In Process' THEN 'Application' WHEN `leads`.`status` = 'New' THEN 'Enquiry' WHEN `leads`.`status` = 'Converted' THEN 'Conditional' WHEN `leads`.`status` = 'Recycled' THEN 'un_conditional' WHEN `leads`.`status` = 'Enrolled' THEN 'Enrolled' WHEN `leads`.`status` = 'Granted' THEN 'Granted' WHEN `leads`.`status` = 'Deposit' THEN 'Deposit' WHEN `leads`.`status` = 'Dead' THEN 'visa_processing' end AS `status` FROM `users` RIGHT JOIN leads ON users.id = leads.assigned_user_id INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id` WHERE ((`leads`.`status` = 'In Process') OR (`leads`.`status` = 'Converted') OR (`leads`.`status` = 'Recycled') OR (`leads`.`status` = 'Deposit')) AND (leads.date_entered BETWEEN '2021-04-16' AND '2021-05-22') AND `leads`.`status` = 'Converted OR status = Recycled' AND `leads`.`assigned_user_id` = '7259be40-4548-98c3-cccc-5f48e989a6ee' GROUP BY leads.assigned_user_id, leads.id EXCEPT SELECT assigned_user_id, Concat(`leads`.`first_name`, ' ', `leads`.`last_name`) AS `student_name`,`leads_cstm`.`program_c` AS `program_c`, `leads_cstm`.`intake_c` AS `intake_c`, `leads_cstm`.`country_c` AS `country_c`, `leads_cstm`.`probability_c` AS `probability_c`, `leads_cstm`.`destination_c` AS `destination_c`, `vw_leads_accounts`.`university` AS `university`, `leads`.`id` AS `lead_id`, CASE WHEN `leads_audit`.`after_value_string` = 'In Process' THEN 'Application' WHEN `leads_audit`.`after_value_string` = 'New' THEN 'Enquiry' WHEN `leads_audit`.`after_value_string` = 'Converted' THEN 'Conditional' WHEN `leads_audit`.`after_value_string` = 'Recycled' THEN 'un_conditional' WHEN `leads_audit`.`after_value_string` = 'Enrolled' THEN 'Enrolled' WHEN `leads_audit`.`after_value_string` = 'Granted' THEN 'Granted' WHEN `leads_audit`.`after_value_string` = 'Deposit' THEN 'Deposit' WHEN `leads_audit`.`after_value_string` = 'Dead' THEN 'visa_processing' end AS `status` FROM `users` RIGHT JOIN leads ON users.id = leads.assigned_user_id RIGHT JOIN leads_audit ON leads.id = leads_audit.parent_id INNER JOIN leads_cstm ON leads_cstm.id_c = leads.id LEFT JOIN `vw_leads_accounts` ON `vw_leads_accounts`.`id` = `leads`.`id` WHERE (field_name = 'status' AND ((`after_value_string` = 'In Process') OR (`after_value_string` = 'Converted') OR (`after_value_string` = 'Recycled') OR (`after_value_string` = 'Deposit')) AND (leads_audit.date_created BETWEEN '2021-04-16' AND '2021-05-22')) AND `leads_audit`.`after_value_string` = 'Converted OR status = Recycled' AND `leads`.`assigned_user_id` = '7259be40-4548-98c3-cccc-5f48e989a6ee' GROUP BY leads.assigned_user_id, leads.id) AS a