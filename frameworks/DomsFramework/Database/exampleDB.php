<? include 'Database.php'; 

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php

        /* Creating the new Database object */
        $db = new Database("fcncmaindb.db.6441590.hostedresource.com", "fcncmaindb","FCnc915", "fcncmaindb");
     
        /******************************************************  
         *              CREATING A NEW TABLE                  *
         ******************************************************/
        
        /* The createTable() takes two paramaters, the 
         * name of the column and an array of columns to add to be added.
         * 
         * Create an array of column objects.
         *   Column object takes 3 parametes:
         *      1.) Name of the feild
         *      2.) Datatype of the field (checked)
         *      3.) The size of that field
         * 
         *  Finally call the create the table
         *      $obj->createTable('name',$array);
         */
    /*    $array = array(
            new column('field1','varchar',200),
            new column('field2','varchar',200),
        );
        $db->createTable('test1',$array);
        
        
        /******************************************************  
         *              GET RESULTS FROM TABLE                *
         ******************************************************/
        
        /*  To get results from a table, you must first select the 
         *  table that you would like to retrieve the results from.
         *  Then you can call the retrieve method to obtain your results.
         * 
         *  Manipulating Results:
         *      You can manipulate the results obtained from the retrieve method.
         *      1.) You can retrieve all of the results in an array.
         *              - Create a variable to hold the results and call retrieve().
         *      2.) You can retrieve only results from one row.
         *              - Create a variable to hold results, call retrieve() 
         *                and pass the row number (indexed 0-i).
         *      3.) You can omit certain fields from the result.
         *              - Create an array of the columns you would like to omit.
         *                then call the ignore method with the array of omitted columns.
         * 
         *  To display results, create a variable to hold the result from the 
         *  retrieve method. Next create a variable to hold the array of rows
         *  that is returned from the get rows method. Create a nested foreach
         *  loop, the inner loop will give access to the column name and its value.
         * 
         */
         $db->setTable("test1");
         $result = $db->retrieve();
         
         /* Obtain all results from a table.
          * Print all fields with thier value.
         */
         $tableRows = $result->getRow();     // Gets all rows from table
         foreach($tableRows as $row){          
            foreach($row as $field => $value){
                echo $field ." => ". $value ."</br>";
            }
         }
        
         /* Obtain results from certain row  in table.
          * Print all fields with thier value.
          */
         $tableRow = $result->getRow(0); // Get the first row from table
         foreach($tableRow as $field => $value){
             echo $field ." => ". $value ."</br>";
         }
        
         /* Get all results from table and ignore certain columns */
         $ignoreArray = array('id','field2');
         $tableRowS = $result->ignore($ignoreArray);
         $tableRows = $result->getRow();     // Gets all rows from table
         foreach($tableRows as $row){          
            foreach($row as $field => $value){
                echo $field ." => ". $value ."</br>";
            }
         }
         
         
         /******************************************************  
         *                 UPDATING A TABLE                    *
         ******************************************************/
        
         /*
          *  To update a table, it first must be selected. Then call the update 
          *  method, which takes four parameters
          *     1.) The column you want to update.
          *     2.) The value of that column you want.
          *     3.) An array of values coorisponding to each column. 
          *             - must match up with each column in the table.
          *     4.) (Optional) An array of columns you want to update 
          *             - each elemnt in the value array must match up
          *               with each element in the column array.
          */
      /*    $db->setTable("test1");
          
          /* Updating all columns in the table */
      /*    $rowValues = array('Column 1 Value','Column 2 Value');
          $db->update("id","1",$rows);
          
          /* Updating certain clolumns in the table */
      /*    $rowValues = array('Column 2 Value');
          $colNames  = array('field2');     // Name of the column you want to update
          $db->update("id","1",$rows,$colNames);
          
          
         /******************************************************  
         *             Removing a Row From A Table             *
         ******************************************************/
          
          /*
           *  To remove a row from a table, you must first select the table you
           *  want to manipulate. Then call the remove() which takes two parameters.
           *        1.) The column you want to select.
           *        2.) The value of that column you want to select.
           *    (the parameters are used for queryString "WHERE xxx = xxx")
           */
      /*    $db->setTable("test1");
          $db->remove('id','9');
        
          
          
          
         /******************************************************  
         *          Inserting a New Row Into A Table           *
         ******************************************************/
          
          /*
           *  To insert a new row into a table, you must first select the table 
           *  you would like to maniulate. Then call the insert() method which 
           *  takes one parameter.
           *        1.) An array of values to be inserted. In an order
           *            coorsponding to the fields in the table.
           */
      /*     $db->setTable("test1");
           $values = array('val5','val6');
           $db->insert($values);
        
        */
        
        

        
        
      
           
                
       
       
        
        
        
        ?>
    </body>
</html>
