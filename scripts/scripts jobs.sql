CREATE EVENT test_event_03
ON SCHEDULE EVERY 2 second
STARTS CURRENT_TIMESTAMP
ENDS CURRENT_TIMESTAMP + INTERVAL 1 HOUR
DO
   call insertPlayer(100,curdate() ,'Jose' ,'Simple' ,'Ton', 169,75,2);

drop EVENT test_event_03

select * from Player;
select * from Person;
SHOW PROCESSLIST;
SET GLOBAL event_scheduler = ON

call insertPlayer(100,curdate() ,'Jose' ,'Simple' ,'Ton', 169,75,2);
drop EVENT test_event_02

#--------------------DASHBOARD----------------------
CREATE EVENT event_dashboard
  ON SCHEDULE
    EVERY 1 DAY
    STARTS '2015-11-08 11:00:00' ON COMPLETION PRESERVE ENABLE 
  DO
    # My query
#--------------------
    
    
    
    
    
    
    
    