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

getGoalsPerMatch

#GOALS PER MATCH
select (count(go.idGoal) / te.teams) goals 
from Goal go inner join Game ga on ga.idEvent = pIdEvent and ga.idGame = go.idGame,
(select count(1) teams from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and gr.idGroup = te.idGroup) te

#EXPULSIONS PER MATCH
select (count(ca.color) / te.teams) expulsions
from Card ca inner join Game ga on ga.idEvent = pIdEvent and ga.idGame = ca.idGame,
(select count(1) teams from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and gr.idGroup = te.idGroup) te    
where ca.color = 1
 
#CAUTIONS PER MATCH
select (count(ca.color) / te.teams) caution
from Card ca inner join Game ga on ga.idEvent = pIdEvent and ga.idGame = ca.idGame,
(select count(1) teams from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and gr.idGroup = te.idGroup) te    
where ca.color = 0
    
#SHOTS PER TEAM
select (count(att.idAttempt) / te.teams) attempts
from Attempt att inner join Game ga on ga.idEvent = pIdEvent and ga.idGame = att.idGame,
(select count(1) teams from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent  and gr.idGroup = te.idGroup) te    

#TOTAL DE PARTIDOS
Select count(1) from Game ga where
ga.idEvent = 2




DELIMITER //
CREATE PROCEDURE insertDashboard()
 BEGIN
	select ev.nameEvent, ev.idEvent , ga.idGame , vis.nameTeam , hom.nameTeam
    from Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent
    where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome
    group by idGame , vis.NameTeam , hom.NameTeam;
 END //
DELIMITER ;




select getAvergeGoals(2)

AttemptTypeDELIMITER //
CREATE FUNCTION `getAvergeGoals` (pIdEvent int)
RETURNS INTEGER
BEGIN
declare returnValue int;
	select (count(go.idGoal) / te.teams) goals 
    into returnValue
	from Goal go inner join Game ga on ga.idEvent = pIdEvent and ga.idGame = go.idGame,
	(select count(1) teams from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and gr.idGroup = te.idGroup) te;
RETURN returnValue;
 END //
DELIMITER ;





show full columns from Goal;


    