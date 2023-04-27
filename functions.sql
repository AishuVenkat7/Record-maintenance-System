set serveroutput on;
CREATE OR REPLACE FUNCTION getAllContract(phoneNum IN NUMBER) RETURN SYS_REFCURSOR AS
      rc SYS_REFCURSOR;
BEGIN
      OPEN rc FOR select sc.contract_id,sc.start_date,sc.end_date,sc.status,sc.phone_num,
    si.item_id,si.make,si.model,si.year, si.machine_tye, sr.service_type,c.subscription_fee from 
    service_contract sc inner join service_item si on sc.contract_id = si.contract_id and sc.phone_num=phoneNum
    and sc.status = 'active' inner join service_registered sr on si.item_id = sr.item_id 
    inner join coverage c on sr.service_type = c.service_type;
    RETURN rc;
END;
/
CREATE OR REPLACE FUNCTION get_total_revenue_per_month(month IN NUMBER, year IN NUMBER) RETURN SYS_REFCURSOR AS
      rc SYS_REFCURSOR;
BEGIN
    OPEN rc FOR SELECT EXTRACT(MONTH FROM date_of_service) month, EXTRACT(YEAR FROM date_of_service) year, 
                SUM(total_repair_cost) AS total_revenue FROM repair_charge_details
				group by EXTRACT(MONTH FROM date_of_service),  EXTRACT(YEAR FROM date_of_service)
				having EXTRACT(MONTH FROM date_of_service) = month and  EXTRACT(YEAR FROM date_of_service)= year;
	RETURN rc;
END;
/