/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cfg` (
  `name` varchar(64) NOT NULL default '',
  `value` text,
  PRIMARY KEY  (`name`)
);
CREATE TABLE `omts` (
  `rid` int(10) unsigned NOT NULL,
  `time` datetime default '0000-00-00 00:00:00',
  `username` varchar(32) default NULL,
  `pcname` varchar(32) default NULL,
  `targetname` varchar(32) default NULL,
  `action` int(11) default '0',
  `text` text,
  `file` text,
  `pid` int(11) default NULL,
  `done` datetime default NULL,
  `result` int(11) default NULL,
  `time2` datetime default NULL,
  `saprname` varchar(32) default NULL,
  `username2` varchar(32) default NULL,
  `cid` int(11) default NULL,
  `curator` varchar(32) default NULL,
  `comment` text,
  PRIMARY KEY  (`rid`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_omts_insert` AFTER INSERT ON `omts` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM omts
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM omts
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   INSERT INTO search_omts (id, text) VALUES (NEW.rid, stext);
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_omts SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_omts_update` AFTER UPDATE ON `omts` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM omts
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM omts
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_omts SET text=stext WHERE id=NEW.rid;
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_omts SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pdm` (
  `rid` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `username` varchar(32) NOT NULL default '',
  `pcname` varchar(32) default NULL,
  `targetname` varchar(32) default NULL,
  `action` int(11) NOT NULL default '0',
  `text` text,
  `file` text,
  `pid` int(11) default NULL,
  `done` datetime default NULL,
  `result` int(11) default NULL,
  `time2` datetime default NULL,
  `saprname` varchar(32) default NULL,
  `username2` varchar(32) default NULL,
  `cid` int(11) default NULL,
  `curator` varchar(32) default NULL,
  `comment` text,
  PRIMARY KEY  (`rid`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_pdm_insert` AFTER INSERT ON `pdm` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM pdm
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM pdm
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   INSERT INTO search_pdm (id, text) VALUES (NEW.rid, stext);
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_pdm SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_pdm_update` AFTER UPDATE ON `pdm` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM pdm
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM pdm
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_pdm SET text=stext WHERE id=NEW.rid;
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_pdm SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

DELIMITER ;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `rid` int(10) unsigned NOT NULL,
  `time` datetime NOT NULL default '0000-00-00 00:00:00',
  `username` varchar(32) NOT NULL default '',
  `pcname` varchar(32) default NULL,
  `targetname` varchar(32) default NULL,
  `action` int(11) NOT NULL default '0',
  `text` text,
  `file` text,
  `pid` int(11) default NULL,
  `done` datetime default NULL,
  `result` int(11) default NULL,
  `time2` datetime default NULL,
  `saprname` varchar(32) default NULL,
  `username2` varchar(32) default NULL,
  `cid` int(16) unsigned default NULL,
  `curator` varchar(32) default NULL,
  `comment` text,
  PRIMARY KEY  (`rid`),
  KEY `req_time` (`time`),
  KEY `req_result` (`result`),
  KEY `requestsUsername` (`username`),
  KEY `requestsTargetname` (`targetname`),
  KEY `requestsSaprname` (`saprname`),
  KEY `requestsPID` (`pid`),
  FULLTEXT KEY `req_ft_text_comment` (`text`,`comment`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

/*!50003 SET @SAVE_SQL_MODE=@@SQL_MODE*/;

DELIMITER ;;
/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_search_insert` AFTER INSERT ON `requests` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM requests
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM requests
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   INSERT INTO search_requests (id, text) VALUES (NEW.rid, stext);
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_requests SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

/*!50003 SET SESSION SQL_MODE="" */;;
/*!50003 CREATE */ /*!50017 DEFINER=`root`@`localhost` */ /*!50003 TRIGGER `move_to_search_update` AFTER UPDATE ON `requests` FOR EACH ROW BEGIN
  DECLARE stext TEXT;
  DECLARE ttext TEXT;
  DECLARE done INT;
  DECLARE selectByRid CURSOR FOR 
   SELECT text
   FROM requests
   WHERE pid=NEW.rid OR rid=NEW.rid;
  DECLARE selectByPid CURSOR FOR 
   SELECT text
   FROM requests
   WHERE pid=NEW.pid OR rid=NEW.pid;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF NEW.pid=0 OR NEW.pid=NULL THEN
  BEGIN
   SET stext = "";
   OPEN selectByRid;
   REPEAT
    FETCH selectByRid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_requests SET text=stext WHERE id=NEW.rid;
   CLOSE selectByRid;
  END;
  ELSE
  BEGIN
   SET stext = "";
   OPEN selectByPid;
   REPEAT
    FETCH selectByPid INTO ttext;
    SET stext = CONCAT(stext, " ", ttext);
   UNTIL done END REPEAT;
   UPDATE search_requests SET text=stext WHERE id=NEW.pid;
   CLOSE selectByPid;
  END;
  END IF;
 END */;;

DELIMITER ;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search` (
  `location` varchar(32) NOT NULL,
  `path` varchar(256) NOT NULL default '',
  `id` int(10) unsigned NOT NULL default '0',
  `data` text,
  FULLTEXT KEY `search_data` (`data`)
);
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_omts` (
  `id` int(11) NOT NULL,
  `text` text,
  PRIMARY KEY  (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_pdm` (
  `id` int(11) NOT NULL,
  `text` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `fts_pdm` (`text`)
);
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_requests` (
  `id` int(11) NOT NULL,
  `text` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `search_requests_fts` (`text`)
);
DELIMITER ;
/*!50003 SET SESSION SQL_MODE=@SAVE_SQL_MODE*/;
