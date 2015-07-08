<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/frameworks/DomsFramework/DataTypes/dataTypes.php';
//require_once 'CMS/CMSComponents.php';  // I dont think this connection is needed.

/**
 * Description of Database
 *  
 * This class provides a quick and easy way to make MYSQL queries.
 * General queries (create table, delete table) can be done w/o selection.
 * For specific queries(INSERT INTO, DELETE FROM, UPDATE,etc) require 
 * that table be selected before calling the repsected methods.
 * 
 * @author dsparks1024
 */
class Database extends mysqli{
    
    public $database;
    public $tableName;
    public $query;
    private $con;

    public function __construct($host,$user,$password,$dbName){
       
        parent::__construct($host,$user,$password,$dbName,null,null);
        $this->con = mysqli_connect($host,$user,$password,$dbName);
       
       if($this->connect_errno){
           exit("ERROR: Could not connected to requested server.");
       }     
    }
   
    /**
     *   Inserts a new table into a MYSQL database.
     *   It checks to see if the given table name exists 
     *   in the database, if it does not exist, the table 
     *   will be inserted with its given columns. Returns true on completion.
     * 
     *   USE: obj->createTable("tableName",$array);
     *   Where $array = array(new column('colName','colDataType','colSize'));
     *  
     *   @param string $tableName 
     *   @param array(column) $columnArray
     *   @return bool 
     */
    
    public function createTable($tableName,$columnArray){
        if($this->isTable("$tableName")){
            exit("ERROR: Table already exists");
        }
       
        $queryString = "CREATE TABLE $tableName (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,";
      
        foreach($columnArray as $value){
            $queryString .= $value->name . " " . $value->type ." (". $value->size."),"; 
        }
     
        /* String has been cleaned and ready for query */
        $queryString = substr_replace($queryString, ");", -1);
        $queryString = $this->escape_string($queryString);
                
        if(!(parent::query($queryString))){
            exit("ERROR: Table not inserted: " . $this->errno."<br/>MYSQL Error: ".$this->error);
        }else{
            return true;
        }      
    }
    
    /**
     *  Checks if the given table exists in the MYSQL database.
     *  If it exists, the table will be dropped. Returns true on completetion.
     *  
     *  @param string $tableName
     *  @return bool
     */
    
    public function dropTable($tableName){
        if($this->isTable($tableName)){
            $this->query("DROP TABLE $tableName");
            return true;
        }else{
            exit("ERROR: Table does not exist.");
        }
    }
    
    
    /**
     *  Sets the objects tableName (if it exists) for use on specific queries.
     * 
     *  @param string $tableName 
     */
    
    public function setTable($tableName){
        if($this->isTable($tableName)){
            $this->tableName = $tableName;
        }else{
            exit("ERROR: Could not set table, it does not exist.");
        }
    }
    
    /**
     *  Inserts the given array of row values into the objects' selected
     *  table. Checks to make sure the number of row items matches the number of 
     *  fields in the selected table. Returns true on completion.
     * 
     *  @param array $rowArray
     *  @return bool  
     */
    
    public function insert($rowArray){
        
        if(!$this->isTable($this->tableName) && $this->tableName!= null){
            exit("ERROR: Could not insert data, table does not exist");
        }
        if(count($rowArray) != $this->getFields()-1){
            exit("ERROR: Could not insert data, number of items does not
                match number of fields");
        }
        
        $queryString = "INSERT INTO ".$this->tableName." VALUES('',";
        foreach($rowArray as $value){
           $queryString .= "'".$value ."',";
        }
        
        $queryString = substr_replace($queryString, ")", -1);
        if(!(parent::query($queryString))){
            exit("ERROR: Data not inserted".$this->error);
        }else{
            return true;
        }   
    }
    
    /**
     *  Removes a the selected row from the objec's selected table.
     *  Returns true on completion.
     * 
     *  @param string $rowSelector
     *  @param string $rowSelectorValue;
     *  @return bool 
     */
    
    public function remove($rowSelector,$rowSelectorValue){
        
        if(!$this->validSelection($rowSelector, $rowSelectorValue)){
            exit("ERROR: No entry exists to perform action on.");
        }
        
        $queryString = "DELETE FROM ".$this->tableName." WHERE `".$rowSelector.
                            "`='".$rowSelectorValue."'";      
        if(!(parent::query($queryString))){
            exit("ERROR: Data not deleted, ".$this->error);
        }else{
            return true;
        }   
    }
    
    
    
    /**
     *  Updates the objects selected table with the given array of row
     *  values. An optional array of column vaules can be passed to 
     *  specify which fields to update. Returns true on completion.
     *  
     *  @param string $rowSelector
     *  @param string $rowSelectorValue
     *  @param array $rowValues
     *  @param (optional) array $colValues
     *  @return bool
     */
    
    public function update($rowSelector,$rowSelectorValue,$rowArray,$colVals = null){
        if(!$this->isTable($this->tableName) || $this->tableName== null){
            exit("ERROR: Could not update data, table does not exist");
        }
        if($colVals == null){
            $default = true;
            if(($query = parent::query("SELECT * FROM ".$this->tableName." WHERE `".
                                            $rowSelector."` = '".$rowSelectorValue."'"))){
                $colVals = $query->fetch_fields();
            }
            if(count($rowArray) != $this->getFields()-1 ){
                exit("ERROR: Could not insert data, number of items does not
                    match number of fields");
            }
        }else{
            $default = false;
            if(count($rowArray) != count($colVals)){
                 exit("ERROR: Could not insert data, number of items does not
                    match number of fields");
            }
        }       

       if(!$this->validSelection($rowSelector, $rowSelectorValue)){
            exit("ERROR: No entry exists to perform action on.");
        }
        
        if($default){
            $queryString = "UPDATE ".$this->tableName." SET ";  
            for($i=0;$i<count($rowArray);$i++){
                $queryString .= "`".$colVals[$i+1]->name . "`='". $rowArray[$i]."', "; 
            }
            $queryString = substr_replace($queryString, "", -2);
            $queryString .= " WHERE `".$rowSelector."`='".$rowSelectorValue."'";
            if(!(parent::query($queryString)))
                exit("ERROR: Data not updated.<br>".$this->error);
            else
                return true;
       }else{
            $queryString = "UPDATE ".$this->tableName." SET ";  
            for($i=0;$i<count($rowArray);$i++){
                $queryString .= "`".$colVals[$i] . "`='". $rowArray[$i]."', "; 
            }
            $queryString = substr_replace($queryString, "", -2);
            $queryString .= " WHERE `".$rowSelector."`='".$rowSelectorValue."'";
            if(!(parent::query($queryString)))
                exit("ERROR: Data not updated.<br>".$this->error);
            else 
                return true;
        }       
    }

    
    /**
     *   Gets all rows from the object's selected table and returns 
     *   the rows as an array of "row" objects. Row object allows 
     *   client to access each field value. 
     * 
     *   Implmentation:
     *     $tableRow = $obj->getRow(); //Retrieves all rows contained in a row Object
     *     foreach($tableRow as $row){
     *          foreach($row as $field => $value){
     *              echo $field ." => ". $value ."</br>";
     *          }
     *      }
     *  
     *   @param string(optional) $rowSelector
     *   @param string(optional) $rowSelectorValue
     *   @return array(row) 
     */
    
    public function retrieve($rowSelector=null,$rowSelectorValue=null){
        if($rowSelectorValue==null&&$rowSelector!=null){     // Needs to be changed if more parameters are added
            exit("ERROR: Missing an optional parameter");
        }
        if(!isset($this->tableName)){
            exit("ERROR: Choose a table to preform operations on!");
        }
        //assert: Both parameters are null, or have a value.
        
        /*Query String for optional params*/
        if($rowSelector==null){     //Default Case
            $queryString = "SELECT * FROM ".$this->tableName;
        }else{
            if(!$this->validSelection($rowSelector, $rowSelectorValue)){
                exit("ERROR: No entry exists to perform action on.");
            }
            $queryString = "SELECT * FROM ". $this->tableName ." WHERE `".
                               $rowSelector."` = '".$rowSelectorValue."'";    
        }        
        /*Execeute the query string*/
        $this->query = $queryString;
        if(!($result = parent::query($queryString)))
            echo 'ERROR: '.$this->error;
        
        /*We have the result, now create the array of row objects*/
        $fields = $result->fetch_fields();
        $rowObj = new row();
        
        while($row = $result->fetch_row()){   
            $rowArray = array();
            for($i=0;$i<count($row);$i++){
                $rowArray[$fields[$i]->name] = $row[$i];
            } 
            $rowObj->addItem($rowArray);
        }
        return $rowObj;   
    }
    
    /**
     *  Gets the result based on an array of field and 
     *  value combinationds. Returns a row object.
     * 
     *   Implmentation:
     *     $tableRow = $obj->getRow(); //Retrieves all rows contained in a row Object
     *     foreach($tableRow as $row){
     *          foreach($row as $field => $value){
     *              echo $field ." => ". $value ."</br>";
     *          }
     *      }
     *  
     *   @param array[feild=>value]
     *   @return array(row) 
     */
    
    public function retrieveStrict($array){
        if(!isset($array)){     // Needs to be changed if more parameters are added
            exit("ERROR: Missing a parameter");
        }
        if(!isset($this->tableName)){
            exit("ERROR: Choose a table to preform operations on!");
        }
        //assert: Both parameters are null, or have a value.
        
        $queryString = "Select * FROM ". $this->tableName ." WHERE ";
        $whereClause='';
        
        foreach($array as $field => $value){
            $whereClause .= "`$field` = '$value' AND ";
        } 
        $whereClause = substr($whereClause,0,-5);
        
        $queryString = $queryString.$whereClause;
        
        /*Execeute the query string*/
        $this->query = $queryString;
        if(!($result = parent::query($queryString)))
            echo 'ERROR: '.$this->error;
        
        /*We have the result, now create the array of row objects*/
        $fields = $result->fetch_fields();
        $rowObj = new row();
        
        while($row = $result->fetch_row()){   
            $rowArray = array();
            for($i=0;$i<count($row);$i++){
                $rowArray[$fields[$i]->name] = $row[$i];
            } 
            $rowObj->addItem($rowArray);
        }
        return $rowObj;   
    }
    
    
    /**
     *  Displays the selected database. Gives a  list of the tables in the database
     *  as links. Each link will then display the data the given table.
     *  
     */
    

    public function displayDatabase(){
       $query = mysqli_query($this->con,"SHOW TABLES");
       $tableName = array();
       while($cRow = mysqli_fetch_array($query)){
           $tableName[] = $cRow[0];
       }
       
       $table = "<table border='1'>";
       
       foreach($tableName as $name){
           $table .= "<tr><td><a href='?table=".$name."'>".$name."</a></td></tr>";
       }
       $table .= "</table>";
       
       if(!isset($_GET['table'])){
           echo $table;
       }else{
           $this->setTable($_GET['table']);
           $result = parent::query("SELECT * FROM ".$this->tableName);
           $tableHeader = "<tr>";
           $tableRows ='';
           while($row = $result->fetch_field()){
               $tableHeader .= "<th>".$row->name."</th>";
           }
           $rows = $this->retrieve();
           for($i=0;$i<$result->num_rows;$i++){
               $row = $rows->getRow($i);
               $tableRows .= "<tr>";
               
               foreach($row as $field => $value){
                   $tableRows .= "<td>".$value."</td>";
               }
               $tableRows .= "</tr>";
           }
           echo "<table border='1'>".$tableHeader."</tr>".$tableRows."</table>";
       }
       
       
       
    }







    /* Private Utility Methods */
    private function isTable($tableName){
        $result = parent::query("SELECT * FROM `$tableName`");
        return $result;
    }
    
    private function getFields(){
        $result = parent::query("SELECT * FROM ".$this->tableName);
        return $result->field_count;
    }
    
    private function validSelection($rowSelector,$rowSelectorValue){
        $queryString = "SELECT * FROM ".$this->tableName." WHERE `".$rowSelector.
                            "` = '".$rowSelectorValue."'";
        if(!($query = parent::query($queryString)))
            exit("ERROR: ". $this->error);
        else{
            return $query->num_rows > 0;
        }
    }
}

?>
