set serveroutput on;
create or replace procedure insert_service_contract( start_date IN DATE, end_date IN DATE, status IN VARCHAR, phone_number IN NUMBER) AS
begin
INSERT INTO service_contract(start_date,end_date,status,phone_num)values(start_date,end_date,status,phone_number);
end;
/
create or replace procedure insert_service_item(item_id IN INT ,make IN VARCHAR, model IN VARCHAR, year IN INT, machine_tye IN VARCHAR) AS
begin
INSERT INTO service_item(item_id,make,model,year,machine_tye)values(item_id,make, model, year, machine_tye);
end;
/
CREATE OR REPLACE PROCEDURE get_contract_by_id(contractId in service_contract.contract_id%type, 
p1 OUT SYS_REFCURSOR) AS
BEGIN
OPEN p1 FOR select sc.contract_id,sc.start_date,sc.end_date,sc.status,sc.phone_num,
    si.item_id,si.make,si.model,si.year,si.machine_tye,sr.service_type,c.subscription_fee from service_contract sc 
    inner join service_item si on sc.contract_id = si.contract_id and sc.contract_id=contractId 
    and sc.status = 'active' inner join service_registered sr on si.item_id = sr.item_id 
    inner join coverage c on sr.service_type = c.service_type;
END;
/
CREATE OR REPLACE PROCEDURE display_repair_details(rno1 in repair_item.rno%type, 
p1 OUT SYS_REFCURSOR) AS
BEGIN
OPEN p1 FOR select rc.tracking_number, ri.item_id, ri.service_type, ri.phone_num, 
			rc.labor_cost, rc.part_cost, rc.total_repair_cost, rc.date_of_service from repair_item ri inner join 
			repair_charge_details rc on ri.rno=rc.rno and ri.rno= rno1;
END;
/
CREATE OR REPLACE PROCEDURE display_all_repair_details(phoneNum in repair_item.phone_num%type, 
p1 OUT SYS_REFCURSOR) AS
BEGIN
OPEN p1 FOR select rc.tracking_number, ri.item_id, ri.service_type, ri.phone_num, 
			rc.labor_cost, rc.part_cost, rc.total_repair_cost, rc.date_of_service from repair_item ri inner join 
			repair_charge_details rc on ri.rno=rc.rno and ri.phone_num= phoneNum;
END;
/

