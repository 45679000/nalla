INSERT INTO `vs_centers` (`CenterId`, `CenterName`, `CohortID`, `Efid`,   `isDeleted`, `SubCountyId`, `created_at`) 
VALUES 
(234,'DAABA 1',3,763,0,4,CURRENT_TIMESTAMP),
(235,'ARIAMAOI',3,764,0,4,CURRENT_TIMESTAMP),
(236,'ATTAN 1',3,765,0,4,CURRENT_TIMESTAMP),
(237,'LOWANGILA',3,766,0,4,CURRENT_TIMESTAMP),
(238,'DAABA 2',3,767,0,4,CURRENT_TIMESTAMP),
(239,'CHUMVIERE',3,768,0,4,CURRENT_TIMESTAMP),
(240,'KORBESA',3,769,0,4,CURRENT_TIMESTAMP),
(241,'MATAARBA 1',3,770,0,4,CURRENT_TIMESTAMP),
(242,'BILIQI SERICHO',3,771,0,4,CURRENT_TIMESTAMP),
(243,'BILIQI CHERAB',3,772,0,4,CURRENT_TIMESTAMP),
(244,'NGAREMARA CENTRAL',3,773,0,4,CURRENT_TIMESTAMP),
(245,'NASURUOI 2',3,774,0,4,CURRENT_TIMESTAMP),
(246,'MWANGAZA',3,775,0,4,CURRENT_TIMESTAMP),
(247,'SALETI 1',3,776,0,4,CURRENT_TIMESTAMP),
(248,'MATAARBA 2',3,777,0,4,CURRENT_TIMESTAMP),
(249,'ATTAN 2',3,778,0,4,CURRENT_TIMESTAMP),
(250,'MALKAMANSA',3,779,0,4,CURRENT_TIMESTAMP),
(251,'GUBATU',3,780,0,4,CURRENT_TIMESTAMP),
(252,'NASURUOI 1',3,781,0,4,CURRENT_TIMESTAMP),
(253,'AGAGARA',3,782,0,4,CURRENT_TIMESTAMP),
(254,'MULANDA',3,783,0,4,CURRENT_TIMESTAMP),
(255,'AUKOT',3,784,0,4,CURRENT_TIMESTAMP);


INSERT INTO `vs_staff` (`id`, `name`, `position`, `county_id`, `center_id`, `phone_number`,  `active`) 
VALUES 
(763,'CELINA AKAI',2,4,234,'0745239784',1),
(764,'ROSEMINA EYANAE',2,4,235,'0705706948',1),
(765,'JANET EKURA',2,4,236,'0768733915',1),
(766,'JANET EREGAE',2,4,237,'0727894332',1),
(767,'EMILY EPEYON',2,4,238,'0758816286',1),
(768,'LUCIA NARUI',2,4,239,'0710429469',1),
(769,'ASILI JATTANI',2,4,240,'0727174267',1),
(770,'AISHA HUKA',2,4,241,'0718033112',1),
(771,'DAHABO JALDESA',2,4,242,'0724164127',1),
(772,'HAWO HERSI',2,4,243,'0115009629',1),
(773,'VERONICA EYANAE',2,4,244,'0702670436',1),
(774,'MARTHA NAMOIT',2,4,245,'0794183197',1),
(775,'HAKIMA MOHAMED',2,4,246,'0725538772',1),
(776,'RUKIA MOHAMED',2,4,247,'0704766542',1),
(777,'LANA BAGAJO',2,4,248,'0799122490',1),
(778,'STELLA KINYA',2,4,249,'0757937931',1),
(779,'KALTUMA MOLU',2,4,250,'0796653671',1),
(780,'BARWAKO ABDIRIZACK',2,4,251,'0758166303',1),
(781,'MERCELINA MUSA',2,4,252,'0702552365',1),
(782,'AMRAN SANTUR',2,4,253,'0792199866',1),
(783,'SHUKRI ADAN',2,4,254,'0796234504',1),
(784,'JOSPHINE NAJUMA',2,4,255,'0706315611',1);





INSERT INTO `user`(`UserId`, `Username`, `Password`, `UserType`, `first_password`, `StaffId`, `fullname`) 
VALUES 
(764,'0705706948',MD5('ISIOLOEF'),'1','ISIOLOEF',764,'ROSEMINA EYANAE'),
(765,'0768733915',MD5('ISIOLOEF'),'1','ISIOLOEF',765,'JANET EKURA'),
(766,'0727894332',MD5('ISIOLOEF'),'1','ISIOLOEF',766,'JANET EREGAE'),
(767,'0758816286',MD5('ISIOLOEF'),'1','ISIOLOEF',767,'EMILY EPEYON'),
(768,'0710429469',MD5('ISIOLOEF'),'1','ISIOLOEF',768,'LUCIA NARUI'),
(769,'0727174267',MD5('ISIOLOEF'),'1','ISIOLOEF',769,'ASILI JATTANI'),
(770,'0718033112',MD5('ISIOLOEF'),'1','ISIOLOEF',770,'AISHA HUKA'),
(771,'0724164127',MD5('ISIOLOEF'),'1','ISIOLOEF',771,'DAHABO JALDESA'),
(772,'0115009629',MD5('ISIOLOEF'),'1','ISIOLOEF',772,'HAWO HERSI'),
(773,'0702670436',MD5('ISIOLOEF'),'1','ISIOLOEF',773,'VERONICA EYANAE'),
(774,'0794183197',MD5('ISIOLOEF'),'1','ISIOLOEF',774,'MARTHA NAMOIT'),
(775,'0725538772',MD5('ISIOLOEF'),'1','ISIOLOEF',775,'HAKIMA MOHAMED'),
(776,'0704766542',MD5('ISIOLOEF'),'1','ISIOLOEF',776,'RUKIA MOHAMED'),
(777,'0799122490',MD5('ISIOLOEF'),'1','ISIOLOEF',777,'LANA BAGAJO'),
(778,'0757937931',MD5('ISIOLOEF'),'1','ISIOLOEF',778,'STELLA KINYA'),
(779,'0796653671',MD5('ISIOLOEF'),'1','ISIOLOEF',779,'KALTUMA MOLU'),
(780,'0758166303',MD5('ISIOLOEF'),'1','ISIOLOEF',780,'BARWAKO ABDIRIZACK'),
(781,'0702552365',MD5('ISIOLOEF'),'1','ISIOLOEF',781,'MERCELINA MUSA'),
(782,'0792199866',MD5('ISIOLOEF'),'1','ISIOLOEF',782,'AMRAN SANTUR'),
(783,'0796234504',MD5('ISIOLOEF'),'1','ISIOLOEF',783,'SHUKRI ADAN'),
(784,'0706315611',MD5('ISIOLOEF'),'1','ISIOLOEF',784,'JOSPHINE NAJUMA');
(785,'0745239784',MD5('ISIOLOEF'),'1','ISIOLOEF',763,'CELINA AKAI'),



UPDATE  `user` SET access_token = md5(CONCAT(Username,Password)) WHERE UserId > 763



INSERT INTO `vs_centers` (`CenterId`, `CenterName`, `CohortID`, `Efid`,   `isDeleted`, `SubCountyId`, `created_at`, `Status`) 
VALUES 
(268,'BADANA 1',3,786,0,4,CURRENT_TIMESTAMP, 1),
(267,'SALETI 2',3,787,0,4,CURRENT_TIMESTAMP, 1);


INSERT INTO `vs_staff` (`id`, `name`, `position`, `county_id`, `center_id`, `phone_number`,  `active`) 
VALUES 
(786,'CELINA AKAI',2,4,266,'0712118648',1),
(787,'ROSEMINA EYANAE',2,4,267,'0713968833',1);


	

INSERT INTO `user`(`UserId`, `Username`, `Password`, `UserType`, `first_password`, `StaffId`, `fullname`, `access_token`) 
VALUES 
(786,'0712118648',MD5('ISIOLOEF'),'2','ISIOLOEF',764,'ROSEMINA EYANAE', MD5(CONCAT('0712118648', MD5('ISIOLOEF'))),
(787,'0713968833',MD5('ISIOLOEF'),'2','ISIOLOEF',765,'JANET EKURA', MD5(CONCAT('0713968833', MD5('ISIOLOEF'));

