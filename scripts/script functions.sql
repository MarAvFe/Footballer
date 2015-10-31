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
