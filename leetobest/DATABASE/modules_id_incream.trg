create or replace trigger modules_id_incream
  before insert on modules  
  for each row
declare
  -- local variables here
begin
  select modules_id_seq.nextval into:new.modules_id from dual;
end modules_id_incream;
/
