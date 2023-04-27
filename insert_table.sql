insert into coverage values('hardware',15,100);
insert into coverage values('software',10,70);
insert into coverage values('peripheral',5,50);

insert into customer values(4087789435, 'Aishu', 'Santa Clara', 'California', 95051);
insert into customer values(6887439426, 'Poorni', 'Santa Clara', 'California', 95051);
insert into customer values(4260424115, 'Mani', 'Santa Clara', 'California', 95051);

insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2023-03-07',DATE '2024-03-07','active',4087789435);

insert into service_item(item_id, make, model, year, machine_tye)values(1,'make11','model1',2023,'Desktop');
insert into service_registered values(1,'hardware');
insert into service_registered values(1,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(2,'make12','model2',2022,'Printer');
insert into service_registered values(2,'peripheral');

insert into service_item(item_id, make, model, year, machine_tye)values(3,'make13','model3',2017,'Laptop');
insert into service_registered values(3,'software');


insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2022-12-02',DATE '2024-05-27','active',4087789435);

insert into service_item(item_id, make, model, year, machine_tye)values(4,'make21','mode21',2019,'Laptop');
insert into service_registered values(4,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(5,'make22','mode22',2020,'Laptop');
insert into service_registered values(5,'hardware');
insert into service_registered values(5,'software');

insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2022-05-20',DATE '2023-06-20','active',6887439426);

insert into service_item(item_id, make, model, year, machine_tye)values(6,'make31','mode31',2023,'Printer');
insert into service_registered values(6,'hardware');
insert into service_registered values(6,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(7,'make32','mode32',2023,'Laptop');
insert into service_registered values(7,'peripheral');

insert into service_item(item_id, make, model, year, machine_tye)values(8,'make33','mode33',2022,'Laptop');
insert into service_registered values(8,'hardware');
insert into service_registered values(8,'software');

insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2023-01-25',DATE '2023-12-29','active',6887439426);

insert into service_item(item_id, make, model, year, machine_tye)values(9,'make41','mode41',2023,'Desktop');
insert into service_registered values(9,'hardware');

insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2023-04-05',DATE '2024-09-28','active',4260424115);

insert into service_item(item_id, make, model, year, machine_tye)values(10,'make51','mode51',2022,'Laptop');
insert into service_registered values(10,'hardware');
insert into service_registered values(10,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(11,'make52','mode52',2021,'Laptop');
insert into service_registered values(11,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(12,'make53','mode53',2022,'Laptop');
insert into service_registered values(12,'hardware');
insert into service_registered values(12,'software');

insert into service_contract(start_date,end_date,status,phone_num)values(DATE '2022-02-14',DATE '2023-04-24','active',4260424115);

insert into service_item(item_id, make, model, year, machine_tye)values(13,'make61','mode6l',2018,'Desktop');
insert into service_registered values(13,'hardware');
insert into service_registered values(13,'software');

insert into service_item(item_id, make, model, year, machine_tye)values(14,'make62','mode62',2021,'Laptop');
insert into service_registered values(14,'hardware');
insert into service_registered values(14,'software');

insert into repair_item(item_id,service_type,phone_num)values(4,'software',4087789435);
insert into repair_charge_details(labor_cost,part_cost,total_repair_cost,date_of_service,rno)values(0,15,15, DATE '2023-03-20',1);

insert into repair_item(item_id,service_type,phone_num)values(4,'hardware',4087789435);
insert into repair_charge_details(labor_cost,part_cost,total_repair_cost,date_of_service,rno)values(100,10,110, DATE '2023-04-20',2);

insert into repair_item(item_id,service_type,phone_num)values(100,'peripheral',4260424115);
insert into repair_charge_details(labor_cost,part_cost,total_repair_cost,date_of_service,rno)values(50,10,60, DATE '2022-07-21',3);


commit;