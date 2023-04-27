create table customer(phone_num number(10) primary key, name varchar2(30) not null, city_name varchar2(40) not null,
state_name varchar2(40) not null, zip_code number(5) not null);

create table service_contract(contract_id int primary key, start_date date, end_date date, status varchar2(8), 
phone_num number(10) references customer(phone_num) on delete cascade);

create table service_item(item_id int primary key, make varchar2(10) not null, model varchar2(10) not null, 
year int, machine_tye varchar2(25), contract_id int references service_contract(contract_id) on delete cascade);

-- create table monitor(make varchar2(10) not null, model varchar2(10) not null, year int, 
-- size_inch number(5,2) not null, item_id int references service_item(item_id) on delete cascade, 
-- primary key(item_id));

create table coverage(service_type varchar2(10) primary key, subscription_fee number(10,2) not null, 
labor_charge number(10,2) not null);

create table service_registered(item_id int references service_item(item_id) on delete cascade, 
service_type varchar2(10) references coverage(service_type), primary key(item_id,service_type));

create table repair_item(rno int primary key,item_id int, service_type varchar2(10),
phone_num number(10) references customer(phone_num) on delete cascade, 
constraint un_repaircolumns unique(item_id,service_type,phone_num));

create table repair_charge_details(tracking_number int primary key, labor_cost number(10,2), part_cost number(10,2), 
total_repair_cost number(12,2), date_of_service date, rno int references repair_item(rno) on delete cascade);

create table del_customer(contract_id int primary key, phone_num number(10) not null, name varchar2(20) not null, 
city_name varchar2(40) not null, state_name varchar2(40) not null, zip_code number(5) not null, cancel_date date not null);
