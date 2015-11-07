DELIMITER //
CREATE PROCEDURE insertContinent(in pNameContinent VARCHAR(45))
 BEGIN
 insert into Continent(nameContinent) 
 values (pNameContinent);
 END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertCity(in pNameCity VARCHAR(45), in pIdCountry INT)
 BEGIN
 insert into City(nameCity,idCountry) 
 values (pNameCity,pIdCountry);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertCountry(in pNameCountry VARCHAR(45), in pFlag VARCHAR(45),
in pIdContinent int)
 BEGIN
 insert into Country(nameCountry,flag,idContinent) 
 values (pNameCountry, pFlag, pIdContinent);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertPerson(in pDni int ,in pBirthdate date ,in pFirstName VARCHAR(45) ,
in pSecondName VARCHAR(45) ,in pLastName VARCHAR(45),in pIdCountry INT)
 BEGIN
 insert into person(dni,birthdate,firstName,secondName,lastName,idCountry) 
 values (pDni ,pBirthdate ,pFirstName, pSecondName, pLastName,pIdCountry);
 END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertPlayer(in pDni int ,in pBirthdate date ,in pFirstName VARCHAR(45) ,
in pSecondName VARCHAR(45) ,in pLastName VARCHAR(45), in pHeight int, in pWeight int,
 in pShirtNumber int, in pIdCountry int)
 BEGIN
 call insertPerson(pDni, pBirthdate, pFirstName, pSecondName, pLastName,pIdCountry);
 insert into player(height,weight,shirtNum,idPerson) 
 values (pHeight,pWeight,pShirtNum,LAST_INSERT_ID());
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertCoach(in pDni int ,in pBirthdate date ,in pFirstName VARCHAR(45) ,
in pSecondName VARCHAR(45) ,in pLastName VARCHAR(45),in pIdCountry int)
 BEGIN
 call insertPerson(pDni, pBirthdate, pFirstName, pSecondName, pLastName,pIdCountry);
 insert into Coach(idPerson) 
 values (LAST_INSERT_ID());
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertCoach(in pDni int ,in pBirthdate date ,in pFirstName VARCHAR(45) ,
in pSecondName VARCHAR(45) ,in pLastName VARCHAR(45),in pIdCountry int)
 BEGIN
 call insertPerson(pDni, pBirthdate, pFirstName, pSecondName, pLastName,pIdCountry);
 insert into Coach(idPerson) 
 values (LAST_INSERT_ID());
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertAwardPerson(in pNameAward VARCHAR(45), in pDateAwardPerson date)
 BEGIN
 insert into AwardPerson(nameAwardPerson, dateAward) 
 values (pNameAward,pDateAwardPerson);
 END //
DELIMITER ;

drop procedure insertAwardTeam;
DELIMITER //
CREATE PROCEDURE insertAwardTeam(in pNameAward VARCHAR(45),in pIdEventStructure INT)
 BEGIN
 insert into AwardTeam(nameAward,idEventStructure) 
 values (pNameAward,pIdEventStructure);
 END //
DELIMITER ;


drop procedure insertAwardPerson;
DELIMITER //
CREATE PROCEDURE insertAwardPerson(in pNameAward VARCHAR(45),in pIdEventStructure INT)
 BEGIN
 insert into AwardPerson(nameAwardPerson,idEventStructure) 
 values (pNameAward,pIdEventStructure);
 END //
DELIMITER ;



DELIMITER //
CREATE PROCEDURE insertTeam(in pNameTeam VARCHAR(45),in pIdCaptain INT, in pIdCountry int,
in pIdGroup INT)
 BEGIN
 insert into Team(nameTeam,captain,idCountry,idGroup) 
 values (pNameTeam,pIdCaptain, pIdCountry,pIdGroup);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertGroup(in pNameGroup VARCHAR(45), in pIdEvent INT)
 BEGIN
 insert into mydb.Group(nameGroup,idEvent) 
 values (pNameGroup , pIdEvent);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertEventStructure( in pNameEventStructure VARCHAR(45), in pQuantityTeam INT,
in pQuantityGroup INT)
 BEGIN
 insert into EventStructure( nameEventStructure,quantityTeam,quantityGroup)
 values (pNameEventStructure , pQuantityTeam , pQuantityGroup );
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertParameterTable( in pNameTag VARCHAR(45), in pValueParameter INT)
 BEGIN
 insert into ParameterTable(nameTag,valueParameter)
 values (pNameTag , pValueParameter);
 END //
DELIMITER ;

drop procedure insertParameterTableGroup;
DELIMITER //
CREATE PROCEDURE insertParameterTableGroup( in pNumberTag int, in pNameGroup VARCHAR(45))
 BEGIN
 insert into ParameterTableGroup(numberTag,nameGroup)
 values (pNumberTag , pNameGroup );
 END //
DELIMITER ;



drop procedure insertEvent;
DELIMITER //
CREATE PROCEDURE insertEvent(in pNameEvent VARCHAR(45), in pDateStart date,in pDateEnd date,
in pIdEventStructure INT)
 BEGIN
 declare totalGroups int;
 declare currEvent int;
 declare i int default 0; 
 
 insert into Event(nameEvent,dateStartEvent,dateEndEvent,idEventStructure)
 values (pNameEvent,pDateStart,pDateEnd,pIdEventStructure);
 
 set currEvent = LAST_INSERT_ID();
 select  floor(quantityTeam / quantityGroup)
 into totalGroups
 from EventStructure 
 where idEventStructure = pIdEventStructure;

 while i < totalGroups do
		call insertGroup(getNameGroup(i),currEvent);
        set i = i + 1;
 end While;
 
 END //
DELIMITER ;




DELIMITER //
CREATE PROCEDURE insertOffside(in pIdPlayer int, in pIdGame int)
 BEGIN
 insert into Offside(idPlayer,idGame)
 values (pIdPlayer, pIdGame);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertSave(in pIdPlayer int, in pIdGame int)
 BEGIN
 insert into Save(idPlayer,idGame)
 values (pIdPlayer, pIdGame);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertGoal(in pIdPlayer int, in pIdGame int, in pMinute int, in pIsPenalty bool)
 BEGIN
 insert into Goal(idPlayer,idGame,minute,isPenalty)
 values (pIdPlayer, pIdGame,pMinute,pIsPenalty);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertFoul(in pIdPlayer int, in pIdGame int)
 BEGIN
 insert into Foul(idPlayer,idGame)
 values (pIdPlayer, pIdGame);
 END //
DELIMITER ;

drop procedure insertCard;
DELIMITER //
CREATE PROCEDURE insertCard(in pIdPlayer int, in pIdGame int, in pColor BOOL, in pMinute int)
 BEGIN
 insert into Card(idPlayer,idGame,color,minute)
 values (pIdPlayer, pIdGame,pColor,pMinute);
 END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertAttempyType(in pNameAttemptType VARCHAR(45))
 BEGIN
 insert into AttemptType(nameAttemptType)
 values (pNameAttemptType);
 END //
DELIMITER ;

drop procedure insertAttempt;
DELIMITER //
CREATE PROCEDURE insertAttempt(in pIdPlayer int, in pIdGame int,in pIdAttemptType int)
 BEGIN
 insert into Attempt(idPlayer,idGame,idAttemptType)
 values (pIdPlayer, pIdGame,pIdAttemptType);
 END //
DELIMITER ;


drop procedure insertCorner;
DELIMITER //
CREATE PROCEDURE insertCorner(in pIdPlayer int, in pIdGame int)
 BEGIN
 insert into Corner(idPlayer,idGame)
 values (pIdPlayer, pIdGame);
 END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertBallPossesion(in pIdGame int, in pPercentage INT)
 BEGIN
 insert into BallPossesion(idGame, percentage)
 values (pIdGame,pPercentage);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertStadium(in pNameStadium VARCHAR(45), in pCapacity INT,in pIdCity int)
 BEGIN
 insert into Stadium(nameStadium, capacity,idCity)
 values (pNameStadium ,pCapacity,pIdCity);
 END //
DELIMITER ;


DROP PROCEDURE insertPenalty;
DELIMITER //
CREATE PROCEDURE insertPenalty(in pIdShooter int, in pIdGoalie INT,in pScore int,in pIdGame int)
 BEGIN
 insert into Penalty(idShooter,idGoalie,score,idGame)
 values (pIdShooter , pIdGoalie ,pScore,pIdGame);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertSoccerUser(in pUsername varchar(45), in pPassword varchar(45),
in pIdEmployee int)
 BEGIN
 insert into SoccerUser(username,soccerPassword,idEmployee)
 values (pUsername,pPassword,pIdEmployee);
 END //
DELIMITER ;



DELIMITER //
CREATE PROCEDURE insertPosition(in pNamePosition varchar(45))
 BEGIN
 insert into mydb.Position(namePosition)
 values (pNamePosition);
 END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE insertPlayer_Team(in pIdPlayer int, in  pIdTeam int, in pShirtNum int)
 BEGIN
 insert into Player_team(idPlayer,idTeam,shirtNum)
 values (pIdPlayer, pIdTeam, pShirtNum);
 END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE insertPlayer_LineUp(in pIdPlayer int, in  pIdLineUp int,in  pIdPosition int)
 BEGIN
 insert into Player_LineUp(idPlayer,idLineUp,idPosition)
 values (pIdPlayer, pIdLineUp,pIdPosition);
 END //
DELIMITER ;




