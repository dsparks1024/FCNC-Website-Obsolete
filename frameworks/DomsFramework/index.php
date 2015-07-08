<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->

<?php
    require_once 'CMS/CMSComponents.php';
    
    require_once 'HTML/formbuilder.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $db = new Database("fcncmaindb.db.6441590.hostedresource.com", "fcncmaindb","FCnc915", "fcncmaindb");

        $array = array(
            new column('pageName', 'varchar',255),
            new column('category', 'varchar',255),
            new column('tags', 'varchar',255),
            new column('type', 'varchar',255),
            new column('headImage', 'varchar',255),
            new column('headText', 'varchar',255),
            new column('body', 'varchar',7000)   
            );
        
        //$db->createTable('pages',$array);
        
        $array1 = array('admission information','info','','page','/images/test.png','Test Image Text','Some text for the main info page.');
        
        
        $db->setTable('pages');
        
        //$db->insert($array1);
        
        //$db->remove('id', '2');
        

        
       $db->displayDatabase();   
        

        
        ?>
        
        
        
    </body>
</html>
