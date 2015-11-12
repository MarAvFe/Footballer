

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

select * from mydb.Event;

call getGroupsTeams(2)
drop PROCEDURE getGroupsTeams
DELIMITER //
CREATE PROCEDURE getGroupsTeams(in pIdEvent INT)
 BEGIN
	select gr.idGroup , gr.nameGroup, te.idTeam, te.nameTeam
    from mydb.Group gr inner join Team te on gr.idEvent = pIdEvent and te.idGroup = gr.idGroup;
 END //
DELIMITER ;

select * from Team;
select * from Country;
call getAwardsPerCountry(4);


drop PROCEDURE getAwardsPerCountry;
DELIMITER //
CREATE PROCEDURE getAwardsPerCountry(in pIdCountry INT)
 BEGIN
	select awt.nameAward 
	from AwardTeam awt, Award_Team aw, Country co inner join Team te
    on co.idCountry = te.idCountry
    where aw.idTeam = te.idTeam and aw.idAwardTeam = awt.idAwardTeam;
 END //
DELIMITER ;

select * from Player;
select * from AwardPerson;
call insertAwardxPlayer(1,1,2);
select * from Award_Player;
call getAwardPerPerson(1);

drop PROCEDURE getAwardPerPerson;
DELIMITER //
CREATE PROCEDURE getAwardPerPerson(in pIdPlayer INT)
 BEGIN
	select awp.nameAwardPerson 
	from AwardPerson awp, Award_Player aw
    where aw.idPlayer = pIdPlayer and awp.idAwardPerson = aw.idAwardPerson;
 END //
DELIMITER ;




call getCountry(); 
DELIMITER //
CREATE PROCEDURE getCountry()
 BEGIN
	select idCountry , nameCountry
    from Country;
 END //
DELIMITER ;

call getCity()
DELIMITER //
CREATE PROCEDURE getCity()
 BEGIN
	select idCity, nameCity
    from City;
 END //
DELIMITER ;



call getTeamsPerGroup(1)
DELIMITER //
CREATE PROCEDURE getTeamsPerGroup(in pIdGroup INT)
 BEGIN
	select nameTeam , idTeam
	from Team te
    where te.idGroup = pIdGroup;
 END //
DELIMITER ;


drop procedure getPlayer;
DELIMITER //
CREATE PROCEDURE getPlayer(in pIdCountry int)
 BEGIN
	select pl.idPlayer , pe.firstName, pe.secondName, pe.lastName, pl.height, pl.weight, getPlayerAge(pe.birthdate)
	from Player pl, Person pe
    inner join Country co on co.idCountry = pe.idCountry and pe.idCountry = pIdCountry
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



DELIMITER //
CREATE PROCEDURE getGamePerEvent()
 BEGIN
	select ev.nameEvent, ev.idEvent , ga.idGame , vis.nameTeam , hom.nameTeam
    from Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent
    where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome
    group by idGame , vis.NameTeam , hom.NameTeam;
 END //
DELIMITER ;

call getPositions()

#------------------------


select getIdTeamWinner(4)
select * from Player_team;
select * from Player;
select * from Goal;
select * from Game;


drop function getIdTeamWinner;
CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getIdTeamWinner`(pIdGame int) RETURNS int(11)
BEGIN

declare returnValue int;
select te.idTeam
into returnValue
	from Team te, Game ga,
    (select count(idGoal) score
    from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
    where ga.idVisitor = getIdTeam(go.idPlayer,pIdGame)) vi,
    (select count(idGoal) score
    from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
    where ga.idHome = getIdTeam(go.idPlayer,pIdGame)) ho 
    where (vi.score > ho.score and te.idTeam = ga.idVisitor and ga.idGame = pIdGame) or 
    (vi.score < ho.score and te.idTeam = ga.idHome and ga.idGame = pIdGame);


RETURN returnValue;
END

select getIdTeamLoser(2)

CREATE FUNCTION `getIdTeamLoser`(pIdGame int)
RETURNS INTEGER
BEGIN
declare returnValue int;
select te.idTeam
into returnValue
	from Team te, Game ga,
    (select count(idGoal) score
    from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
    where ga.idVisitor = getIdTeam(go.idPlayer,pIdGame)) vi,
    (select count(idGoal) score
    from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
    where ga.idHome = getIdTeam(go.idPlayer,pIdGame)) ho 
    where (vi.score < ho.score and te.idTeam = ga.idVisitor and ga.idGame = pIdGame) or 
    (vi.score > ho.score and te.idTeam = ga.idHome and ga.idGame = pIdGame);

RETURN returnValue;
END

select * from mydb.Event;
select * from Team;
select getTeamWinsPerEvent(2,4)


drop function getTeamWinsPerEvent;

CREATE FUNCTION `getTeamWinsPerEvent` (pIdEvent int, pIdTeam int)
RETURNS INTEGER
BEGIN
	declare returnValue int;
	select count(ga.idGame)
    into returnValue
	from Game ga inner join mydb.Event ev
	on ga.idEvent = ev.idEvent and ev.idEvent = pIdEvent
	where getIdTeamWinner(ga.idGame) = pIdTeam;
	

RETURN returnValue;
END

select getTeamLosesPerEvent(2,3)

CREATE FUNCTION `getTeamLosesPerEvent` (pIdEvent int, pIdTeam int)
RETURNS INTEGER
BEGIN
	declare returnValue int;
	select count(ga.idGame)
    into returnValue
	from Game ga inner join mydb.Event ev
	on ga.idEvent = ev.idEvent and ev.idEvent = pIdEvent
	where getIdTeamLoser(ga.idGame) = pIdTeam;
	return returnValue;
END
 
 select * from Team;
 select * from Game;
 select * from Player_team;
 (in pIdPlayer int, in pIdGame int, in pMinute int, in pIsPenalty bool)
 call insertGoal(5,3,5,false);
 call insertGoal(5,1,5,false);
 select * from Goal;
 
 select checkTie(6);
 select * from Goal;
 select * from Team;
 select * from Game;
 select * from Player_team
 select getIdTeamWinner(2)
 
 select count(idGoal) score
	from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = 3
	where ga.idVisitor = getIdTeam(go.idPlayer,3)
 
 
 delete from Goal where idPlayer = 1 and idGame = 2
 
 drop function checkTie;
 
CREATE FUNCTION `checkTie` (pIdGame int)
RETURNS INTEGER
BEGIN
declare returnValue int;
	select count(1)
	into returnValue
	from
	(select count(idGoal) score
	from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
	where ga.idVisitor = getIdTeam(go.idPlayer,pIdGame)) vi,
	(select count(idGoal) score
	from Goal go inner join Game ga on go.idGame = ga.idGame and ga.idGame = pIdGame
	where ga.idHome = getIdTeam(go.idPlayer,pIdGame)) ho 
	where vi.score = ho.score;

	return returnValue;
END


 
 
 
 select getTeamTiesPerEvent(2,3)

drop function getTeamTiesPerEvent
CREATE FUNCTION `getTeamTiesPerEvent` (pIdEvent int, pIdTeam int)
RETURNS INTEGER
BEGIN
declare returnValue int;
	select count(ga.idGame)
    into returnValue
	from Game ga inner join mydb.Event ev
	on ga.idEvent = ev.idEvent and ev.idEvent = pIdEvent
	where checkTie(ga.idGame) = 1 and (pIdTeam = ga.idVisitor or pIdTeam = ga.idHome);
	return returnValue;
END


select * from mydb.Event;
select * from Team;
select * from Game;
select  getMatchesPlayed(2,10)

CREATE FUNCTION `getMatchesPlayed` (pIdEvent int, pIdTeam int)
RETURNS INTEGER
BEGIN
	declare returnValue int;
	select count(1)
    into returnValue
	from mydb.Event ev inner join Game ga 
	on ev.idEvent = pIdEvent and ev.idEvent = ga.idEvent
	where ga.idVisitor = pIdTeam or ga.idHome = pIdTeam;
RETURN returnValue;
END



#*------RESPALDO DE FUNCION---------
CREATE DEFINER=`mainSoccer`@`%` PROCEDURE `getGamePerEvent`()
BEGIN
	select ev.nameEvent, ev.idEvent , ga.idGame , vis.nameTeam , hom.nameTeam
    from Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent
    where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome
    group by idGame , vis.NameTeam , hom.NameTeam;
 END
 
 
 #FUNCION Q TRAE LOS EVENTOS 
 select ev.idEvent, concat(hom.nameTeam,'-', vis.nameTeam) teamNames, ga.idGame , go.nameGroup
    from mydb.Group go ,Team vis, Team hom,mydb.Event ev inner join Game ga on ga.idEvent = ev.idEvent
    where vis.idTeam = ga.idVisitor  and hom.idTeam = ga.idHome and go.idGroup = vis.idGroup
    group by idGame , teamNames;
 
 
#--------------
select * from Team;

select getTeamPoints(3 , 2)


CREATE FUNCTION `getTeamPoints` (pIdTeam int, pIdEvent int)
RETURNS INTEGER
BEGIN
	declare returnValue int;
	select ((getTeamWinsPerEvent(2,4) * 3) + getTeamTiesPerEvent(2,4)) points
    into returnValue
	from Team te
	where te.idTeam = 3;
RETURN returnValue;
END


select pl.idPlayer, concat(pe.firstName, ' ', pe.lastName)  from 
Person pe, Player pl, Player_team pt inner join Game ga
on (ga.idVisitor = pt.idTeam or ga.idHome = pt.idTeam) and ga.idGame = pIdGamewhere pl.idPlayer = pt.idPlayer and pe.idPerson = pl.idPerson


DELIMITER //
CREATE PROCEDURE getTeamsForEvent()
 BEGIN
	select te.idTeam , te.NameTeam from Team te where te.idGroup is null;
 END //
DELIMITER ;


call insertEvent('Copa test',curdate(),curdate(),7);
call insertEventStructure('Mighty 8',8,2)
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,1);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,2);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,3);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,4);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,5);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,6);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,7);
call insertPlayer(123,curdate(),'Bob','Simple','Ton',20,20,8);
select * from Player;

call insertPlayer_Team(1846,7,0,1);
call insertPlayer_Team(1847,8,0,1);
call insertPlayer_Team(1848,9,0,1);
call insertPlayer_Team(1849,10,0,1);
call insertPlayer_Team(1850,11,0,1);
call insertPlayer_Team(1851,12,0,1);
call insertPlayer_Team(1852,13,0,1);
call insertPlayer_Team(1853,14,0,1);
(in pIdPlayer int, in  pIdTeam int, in pShirtNum int,in pIdPosition int)

select * from mydb.Event;
select * from mydb.Group;
select * from Team
select * from Position
select * from Coach
call insertTeam('T1',1846,1,1);
call insertTeam('T2',1847,1,2);
call insertTeam('T3',1848,1,3);
call insertTeam('T4',1849,1,4);
call insertTeam('T5',1850,1,5);
call insertTeam('T6',1851,1,6);
call insertTeam('T7',1852,1,7);
call insertTeam('T8',1853,1,8);
(in pNameTeam VARCHAR(45),in pIdCaptain INT,in pIdCoach int,in pIdCountry int)

call updateTeamGroup(7,9);
call updateTeamGroup(8,9);
call updateTeamGroup(9,10);
call updateTeamGroup(10,10);
call updateTeamGroup(11,11);
call updateTeamGroup(12,11);
call updateTeamGroup(13,12);
call updateTeamGroup(14,12);

select * from Game;
select * from Game  limit 0,1;
select * from Game  limit 1,1;
select * from Game  limit 2,1;
select * from Game  limit 3,1;

#Trae los paises que no tienen equipos con idGROUP null
select co.idCountry , co.nameCountry
from Country co left outer join
(select idCountry from Team where idGroup is null) te on co.idCountry = te.idCountry



select * from mydb.Group;
select * from Game;
select * from Country;
select * from EventStructure
call generateFirstGames(4)
rollback
commit
delete from Game where idEvent = 4

drop procedure generateFirstGames;
DELIMITER //
CREATE PROCEDURE generateFirstGames(in pIdEvent int)
 BEGIN
	declare groupCount int;
    declare teamCount int;
    declare i int default 0;
    declare y int default 0;
    declare z int default 0;
    declare idTeamHome int;
    declare idTeamVisitor int;
    
    select evs.quantityTeam , evs.quantityGroup 
    into teamCount, groupCount  
    from EventStructure evs 
    inner join mydb.Event ev on ev.idEvent = pIdEvent  and ev.idEventStructure = evs.idEventStructure;
		
	create temporary table randomTeams as 
		select te.idTeam from mydb.Event ev
        inner join mydb.Group gr on ev.idEvent = gr.idEvent and ev.idEvent = pIdEvent
        inner join Team te on te.idGroup = gr.idGroup
        group by rand();
        
    while (i < teamCount) do
		set y = i;
        while (y < i + groupCount) do
			set z = y + 1;
			while (z < i + groupCount) do
				select idTeam into idTeamHome from randomTeams LIMIT y,1;
                select idTeam into idTeamVisitor from randomTeams LIMIT z,1;
                
				call insertGame(idTeamHome, idTeamVisitor, 0, curdate() ,90,pIdEvent);
				set z = z + 1;
			end while;
			set y = y + 1;
		end while;
		set i = i + GroupCount;
    end while;
    
    drop temporary table if exists randomTeams;
 END //
DELIMITER ;




pIdContinent
select * from Continent;
select * from Country;
select * from Player;
select * from Player_team;
select * from Team;

#SELECCION LOS PAISES CON UN GURPO SIN ASIGNAR
select te.idTeam, te.nameTeam , count(pt.idPlayer) from Country co 
inner join Team te on co.idContinent = 8 and co.idCountry = te.idCountry
left join Player_team pt on pt.idTeam = te.idTeam
where te.idGroup is null
group by nameTeam , idTeam;



 CREATE PROCEDURE `updateTeamGroup` (pIdTeam int, pIdGroup int)
BEGIN

	update Team te set te.idGroup = pIdGroup 
    where te.idTeam = pIdTeam;

END



drop procedure generateFirstGames;
DELIMITER //
CREATE PROCEDURE generateRound(in pIdEvent int)
 BEGIN
	declare groupCount int;
    declare teamCount int;
    declare i int default 0;
    declare y int default 0;
    declare z int default 0;
    declare idTeamHome int;
    declare idTeamVisitor int;
    declare currentRound int;
    
    select evs.quantityTeam , evs.quantityGroup 
    into teamCount, groupCount  
    from EventStructure evs 
    inner join mydb.Event ev on ev.idEvent = pIdEvent and ev.idEventStructure = evs.idEventStructure;
    
    select min(ga.matchJourney)
    into currentRound 
    from Game ga
    inner join mydb.Event ev on ev.idEvent = pIdEvent and ga.idEvent = ev.idEvent;
	
 END //
DELIMITER ;



drop procedure generateFirstGames;
DELIMITER //
CREATE PROCEDURE generateFinals(in pIdEvent int)
 BEGIN
	declare groupCount int;
    declare teamCount int;
    declare i int default 0;
    declare y int default 0;
    declare z int default 0;
    declare idTeamHome int;
    declare idTeamVisitor int;
    declare currentRound int;
    
    select evs.quantityTeam , evs.quantityGroup 
    into teamCount, groupCount  
    from EventStructure evs 
    inner join mydb.Event ev on ev.idEvent = pIdEvent and ev.idEventStructure = evs.idEventStructure;
    
    select min(ga.matchJourney)
    into currentRound 
    from Game ga
    inner join mydb.Event ev on ev.idEvent = pIdEvent and ga.idEvent = ev.idEvent;
    
    create temporary table randomTeams
    (idTeam int);
    
    
    
    select idTeam from Team te 
    
    select te.idGroup from Team te, Game ga 
		where ga.idEvent = 4 and ga.idVisitor = te.idTeam
    getTeamPoints()
    
	
 END //
DELIMITER ;



#SELECCIONA LOS PAISES QUE PUEDEN CREAR NUEVOS EQUIPOS PARA EVENTOS
select co.idCountry , co.nameCountry
from Country co
where co.idCountry not in  (select idCountry from Team where idGroup is null)




 