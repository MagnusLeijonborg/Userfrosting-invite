<?php
/*

UserFrosting Version: 0.2.1 (beta)
By Alex Weissman
Copyright (c) 2014

Based on the UserCake user management system, v2.0.2.
Copyright (c) 2009-2012

UserFrosting, like UserCake, is 100% free and open-source.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the 'Software'), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

CREATE TABLE IF NOT EXISTS `uf_invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inviterId` int(11) NOT NULL,
  `invitedEmail` text NOT NULL,
  `status` int(11) NOT NULL,
  `inviteToken` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `uf_user_invites` (
  `userId` int(11) NOT NULL,
  `invitesLeft` int(11) NOT NULL,
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

*/

?>

<!DOCTYPE html>
<html lang="en">
 
  <?php
  require_once("../../../models/config.php");
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Account Settings"));
  ?>

  <body>

<?php

   try {       
		$db = pdoConnect();
        $sqlVars = array();
  
        $query ="CREATE TABLE IF NOT EXISTS `uf_invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inviterId` int(11) NOT NULL,
  `invitedEmail` text NOT NULL,
  `status` int(11) NOT NULL,
  `inviteToken` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `accepted` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;" ;  
	
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        
        echo "table uf_invites created<br>";
       
    } catch (PDOException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
          echo " failed to create table";
    } catch (ErrorException $e) {
            echo " failed to create table";
    } catch (RuntimeException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
            echo " failed to create table";
    }
   
   
   try {       
        $db = pdoConnect();
        $sqlVars = array();
  
        $query ="CREATE TABLE IF NOT EXISTS `uf_user_invites` (
  `userId` int(11) NOT NULL,
  `invitesLeft` int(11) NOT NULL,
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;" ;  
	
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        
         echo "second table created<br>";
       
    } catch (PDOException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
            echo " failed to create table";
    } catch (ErrorException $e) {
            echo " failed to create table";
    } catch (RuntimeException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
            echo " failed to create table";
    }
    
    
    // add menu
       try {       
        $db = pdoConnect();
        $sqlVars = array();
  
        $query ="INSERT INTO uf_nav (menu,page,name,position,class_name,icon,parent_id) VALUES ('left','modules/invite/account/invite.php','Invite friends',11,'invite','fa fa-user',0)" ;  
	
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        
         echo "inserted menu<br>";
       
    } catch (PDOException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
           echo "failed to insert menu<br>";
    } catch (ErrorException $e) {
           echo "failed to insert menu<br>";
    } catch (RuntimeException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
            echo "failed to insert menu<br>";
    }
    
    // add page
    
 
   try {       
        $db = pdoConnect();
        $sqlVars = array();
        $query ="select id from uf_nav where class_name='invite'" ; 
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);    
    	if ($row)
       		$id=$row['id'];
        else {
        	$id=0;
        } 
	
        $query ="INSERT INTO uf_nav_group_matches (menu_id,group_id) VALUES (".$id.",1)" ; 
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        
        
        
        
         echo "created nav_group_match<br>";
       
    } catch (PDOException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
          echo "failed to create nav_group_match<br>";
    } catch (ErrorException $e) {
           echo "failed to create nav_group_match<br>";
    } catch (RuntimeException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
           echo "failed to create nav_group_match<br>";
    }
    
     try {       
        $db = pdoConnect();
        $sqlVars = array();
  
        $query ="INSERT INTO uf_pages (page,private) VALUES ('modules/invite/account/invite.php',1)" ;  
	
        $stmt = $db->prepare($query);
        $stmt->execute($sqlVars);
        
         echo "inserted page<br>";
       
    } catch (PDOException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
           echo "failed to insert page<br>";
    } catch (ErrorException $e) {
          echo "failed to insert page<br>";
    } catch (RuntimeException $e) {
          error_log("Error in " . $e->getFile() . " on line " . $e->getLine() . ": " . $e->getMessage());
           echo "failed to insert page<br>";
    }
    
    
?>
</body>
</html>
