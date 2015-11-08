

select pt.idTeam 
from Player_Team pt ,
(select idEvent from mydb.Event ev inner join Game ga on ga.idEvent = pIdEvent) evt
inner join mydb.Group gr on gr.idEvent = pIdEvent)
inner join Team te on gr.idGroup = te.idGroup
where pt.idPlayer = pIdPlayer and pt.idTeam = te.idTeam


select pt.idTeam
from Player_Team pt , Game ga
where (ga.visit = pt.idTeam and pIdGame = ga.idGame and pIdPlayer = pt.idPlayer)
 or (ga.home = pt.idTeam and pIdGame = ga.idGame and pIdPlayer = pt.idPlayer)
 
 

DELIMITER //
CREATE PROCEDURE getIdTeam(in pIdPlayer INT, in pIdGame INT)
 BEGIN
	select pt.idTeam
	from Player_team pt inner join Game ga on ga.idGame = pIdGame and (pt.idTeam = ga.idVisitor or pt.idTeam = ga.idHome)
	where pt.idPlayer = pIdPlayer;
 END //
DELIMITER ;

 
DELIMITER //
CREATE PROCEDURE getGroupsTeams(in pIdEvent INT)
 BEGIN
	select idGroup , nameGroup, idTeam, nameTeam
    from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and te.idGroup = gr.idGroup;
 END //
DELIMITER ;

 
DELIMITER //
CREATE PROCEDURE getAwardsPerCountry(in pIdCountry INT)
 BEGIN
	select aw.idAward , aw.nameAward 
	from AwardTeam aw, Country co inner join Team te
    on co.idCountry = te.idCountry
    where aw.idTeam = te.idTeam;
 END //
DELIMITER ;
 
DELIMITER //
CREATE PROCEDURE getCountry()
 BEGIN
	select idCountry , nameCountry
    from Country;
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE getCity()
 BEGIN
	select idCity, nameCity
    from City;
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE getTeamsPerGroup(in pIdGroup INT)
 BEGIN
	select nameTeam , idTeam
	from Team te
    where te.idGroup = pIdGroup;
 END //
DELIMITER ;


select * from Person

DELIMITER //
CREATE PROCEDURE getPlayer(in pIdCountry int)
 BEGIN
	select pl.idPlayer , pe.firstName, pe.secondName, pe.lastName, pl.height, pl.weight, getPlayerAge()
	from Player pl, Person pe
    inner join Country co on co.idCountry = pe.idCountry
    where pl.idPerson = pe.idPerson;
 END //
DELIMITER ;

drop procedure getGamePerEvent;
DELIMITER //
CREATE PROCEDURE getGamePerEvent()
 BEGIN
	select ev.nameEvent, ev.idEvent , ga.idGame , vis.nameTeam , hom.nameTeam
    from Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent
    where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome
    group by idGame , vis.NameTeam , hom.NameTeam;
 END //
DELIMITER ;

call getGamePerEvent();








 