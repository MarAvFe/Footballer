CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerAge`(pidPlayer int) RETURNS int(4)
BEGIN
	DECLARE returnValue int(4);
	select year(curdate()) - year(birthdate)
	into returnValue
	from Person
	where idPerson=(select idPerson from Player where idPlayer=pidPlayer);
	RETURN returnValue;
END;


CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerCountry`(pidPlayer int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select nameCountry
	into returnValue
	from Country
	where idCountry=(select idCountry from Person where idPerson=(select idPerson from Player where idPerson = pidPlayer));
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerHeight`(pidPlayer int) RETURNS int(11)
BEGIN
	DECLARE returnValue int;
	select height
	into returnValue
	from Player
	where idPlayer=pidPlayer;
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerDNI`(pidPlayer int) RETURNS int(11)
BEGIN
	DECLARE returnValue int;
	select dni
	into returnValue
	from Person
	where idPerson=(select idPerson from Player where idPerson = pidPlayer);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerFirstName`(pIdPlayer Int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select firstName
	into returnValue
	from Person
	where idPerson=(select idPerson from Player where idPerson = pidPlayer);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerLastName`(pidPlayer int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(25);
	select lastName
	into returnValue
	from Person
	where idPerson=(select idPerson from Player where idPerson = pidPlayer);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerSecondName`(pidPlayer int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select secondName
	into returnValue
	from Person
	where idPerson=(select idPerson from Player where idPerson = pidPlayer);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getPlayerWeight`(pidPlayer int) RETURNS int(11)
BEGIN
	DECLARE returnValue int;
	select weight
	into returnValue
	from Player
	where idPlayer=pidPlayer;
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getNameGroup`(pNumberTag int) RETURNS varchar(45) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(44);
	select nameGroup
	into returnValue
	from ParameterTableGroup
	where numberTag = pNumberTag;
RETURN returnValue;

END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachCountry`(pidCoach int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select nameCountry
	into returnValue
	from Country
	where idCountry=(select idCountry from Person where idPerson=(select idPerson from Coach where idCoach = pidCoach));
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachAge`(pidCoach int) RETURNS int(11)
BEGIN
	DECLARE returnValue int(4);
	select year(curdate()) - year(birthdate)
	into returnValue
	from Person
	where idPerson=(select idPerson from Coach where idCoach=pidCoach);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachLastName`(pidCoach int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select lastName
	into returnValue
	from Person
	where idPerson=(select idPerson from Coach where idCoach = pidCoach);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachSecondName`(pidCoach int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select SecondName
	into returnValue
	from Person
	where idPerson=(select idPerson from Coach where idCoach = pidCoach);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachFirstName`(pidCoach int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select firstName
	into returnValue
	from Person
	where idPerson=(select idPerson from Coach where idCoach = pidCoach);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCoachDNI`(pidCoach int) RETURNS int(11)
BEGIN
	DECLARE returnValue int;
	select dni
	into returnValue
	from Person
	where idPerson=(select idPerson from Coach where idCoach = pidCoach);
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getContinentName`(pidContinent int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select nameContinent
	into returnValue
	from Continent
	Where idContinent=pidContinent;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCountryName`(pidCountry int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select nameCountry
	into returnValue
	from Country
	Where idCountry=pidCountry;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCityName`(pidCity int) RETURNS varchar(20) CHARSET utf8
BEGIN
	DECLARE returnValue varchar(20);
	select nameCity
	into returnValue
	from Country
	Where idCity=pidCity;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getGoalsTeam`(pIdGame int, pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Goal go
	where go.idGame =  pIdGame and getIdTeam(idPlayer,pIdGame) = pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCardsTeam`(pidGame int,pIdTeam int,pColor int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Card go
	where go.idGame =  pIdGame and color=pColor and getIdTeam(idPlayer,pIdGame) = pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getAttemptsTeam`(pIdGame int,pIdTeam int, pIdAttempt int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Attempt go
	where go.idGame = pIdGame  and idTeam= pIdTeam and idAttemptType=pIdAttempt;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getTotalAttemptsTeam`(pIdGame int,pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Attempt go
	where go.idGame = pIdGame  and idTeam= pIdTeam;
	return returnValue;
END;


CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getCornersTeam`(pIdGame int, pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Corner go
	where go.idGame = pIdGame  and idTeam= pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getSavesTeam`(pIdGame int, pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Save go
	where go.idGame =  pIdGame and getIdTeam(idPlayer,pIdGame) = pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getOffsidesTeam`(pIdGame int, pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Offside go
	where go.idGame = pIdGame  and idTeam= pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getFoulsTeam`(pIdGame int, pIdTeam int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select count(1)
	into returnValue
	from Foul go
	where go.idGame = pIdGame  and idTeam= pIdTeam;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getBallPossesionHome`(pIdGame int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select homePercentage
	into returnValue
	from BallPossesion
	where idGame = pIdGame;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getBallPossesionVisit`(pIdGame int) RETURNS int(11)
BEGIN
	declare returnValue int(11);
	select (100 - homePercentage)
	into returnValue
	from BallPossesion
	where idGame = pIdGame;
	return returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getTeamName`(pIdTeam int) RETURNS varchar(20) CHARSET utf8
BEGIN
	declare returnValue varchar(20);
	select nameTeam
	into returnValue
	from Team
	where idTeam=pIdTeam;
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getTeamCaptain`(pidTeam int) RETURNS varchar(40) CHARSET utf8
BEGIN
	declare returnValue varchar(40);
	select CONCAT(firstName,' ',secondName,' ',lastName)
	into returnValue
	from Person
	where idPerson= (select idPerson from Player where idPlayer = (select captain from Team where idTeam=pidTeam));
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` FUNCTION `getTeamCoach`(pIdTeam int) RETURNS varchar(40) CHARSET utf8
BEGIN
	declare returnValue varchar(40);
	select CONCAT(firstName,' ',secondName,' ',lastName)
	into returnValue
	from Person
	where idPerson= (select idPerson from Coach where idCoach = (select idCoach from Team where idTeam=pIdTeam));
	RETURN returnValue;
END;

CREATE DEFINER=`mainSoccer`@`%` PROCEDURE `getAwardsTeam`()
BEGIN
	select idAwardTeam,nameAwardTeam,idEventStructure
	from AwardPerson;
END;

CREATE DEFINER=`mainSoccer`@`%` PROCEDURE `getAwardsPerson`()
BEGIN
	select idAwardPerson,nameAwardPerson,idEventStructure
	from AwardPerson;
END;

CREATE DEFINER=`mainSoccer`@`%` PROCEDURE `insertAwardxTeam`(in pIdAwardTeam int, in pIdTeam int, in pIdEvent int)
BEGIN
	insert into Award_Team(IdAwardTeam,IdTeam,IdEvent)
	values (pIdAwardTeam,pIdTeam,pIdEvent);
END;

CREATE PROCEDURE `insertStadium` (in pNameStadium varchar(40), in pCapacity int, in pIdCity int)
BEGIN
	insert into Stadium(nameStadium,capacity,idCity) 
    values (pNameStadium,pCapacity,pIdCity);
END;

CREATE FUNCTION `getTeamContinent` (pIdTeam int)
RETURNS varchar(20)
BEGIN
	declare returnValue varchar(20);
	select nameContinent 
    into returnValue
    from Continent
    where idContinent=(select idContinent from Country where idCountry=(select idCountry from Team where idTeam=pIdTeam));
RETURN returnValue;
END;


