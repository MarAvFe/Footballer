alter table SoccerUserSoccerUser drop column soccerPassword;
alter table SoccerUser add column soccerPassword varchar(45) not null;
alter table SoccerUser add unique(username);




alter table Person add column idCountry int not null;
ALTER TABLE Person
ADD FOREIGN KEY (idCountry)
REFERENCES Country(idCountry);


alter table Player drop foreign key fk_Player_idCountry;
alter table Player drop column idCountry;

alter table Coach drop foreign key fk_coach_idCountry;
alter table Coach drop column idCountry;

alter procedure insertContinent;

call insertContinent("America");

select * from Continent;
delete from Continent where idContinent = 9;


drop procedure insertContinent;


drop procedure insertPerson;

drop procedure insertPlayer;

drop procedure insertContinent;





alter table AwardTeam drop foreign key fk_AwardTeam_idTeam;
alter table AwardPerson drop foreign key fk_AwardPerson_idPlayer;

alter table AwardTeam drop column dateAward;
alter table AwardTeam add column idEventStructure VARCHAR(45) not null;

alter table AwardPerson drop column dateAward;
alter table AwardPerson add column idEventStructure VARCHAR(45) not null;



alter table AwardPerson drop foreign key fk_AwardPerson_idPlayer_idx;
alter table AwardTeam drop foreign key fk_AwardTeam_idTeam;

alter table AwardPerson drop column idPlayer;
alter table AwardTeam drop column idTeam;


alter table EventStructure add column nameEventStructure VARCHAR(45) not null;
ALTER TABLE TABLE_NAME ADD CONSTRAINT constr_ID UNIQUE (user_id, game_id, date, time)

ALTER TABLE TABLE_NAME ADD CONSTRAINT constr_ID UNIQUE (user_id, game_id, date, time)


drop function getNameGroup;
DELIMITER //
CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getNameGroup`(pNumberTag int) RETURNS varchar(45)
BEGIN
	DECLARE returnValue varchar(44);
	select nameGroup
	into returnValue
	from ParameterTableGroup
	where numberTag = pNumberTag;
RETURN returnValue;

END
DELIMITER ;


ALTER TABLE `BallPossesion` CHANGE COLUMN `porcentage` `percentage` int NOT NULL;


alter table BallPossesion rename porcentage;


call insertParameterTableGroup(0,'Grupo A');
call insertParameterTableGroup(1,'Grupo B');
call insertParameterTableGroup(2,'Grupo C');
call insertParameterTableGroup(3,'Grupo D');
call insertParameterTableGroup(4,'Grupo E');
call insertParameterTableGroup(5,'Grupo F');
call insertParameterTableGroup(6,'Grupo G');
call insertParameterTableGroup(7,'Grupo H');

SoccerUser
select * from EventStructure;
select * from mydb.Group;
select * from mydb.Event;

call insertEvent('Copa Meh', STR_TO_DATE('01/01/1995','%d/%m/%Y'),
STR_TO_DATE('05/01/1995','%d/%m/%Y'),5);


delete from
select * from Player_team;
ALTER TABLE `Player_LineUp` drop column shirtNum;
ALTER TABLE `Player_team` add column `shirtNum` int NOT NULL;


select getIdTeam(idPlayer,pIdGame)
select * from Player_team
select getIdTeam(4,1)

select * from Attempt











