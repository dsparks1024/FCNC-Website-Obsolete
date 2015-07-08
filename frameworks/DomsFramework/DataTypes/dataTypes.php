<?php

/**
 * These DataTypes are used to represent objects that will be 
 * used in an SQL database.
 *
 * @author dsparks1024
 */

/**
 * Column: Represents a column that will make up a new table in an SQL Database
 */
class column {
    
    public $name;
    public $type;
    public $size;
    private $validType;
            
    public function __construct($name,$dataType,$size) {
        $this->name = $name;
        $this->size =$size;
        
        $this->validType = array('varchar','tinyint','text','date','smallint','mediumint','int','bigint','float',
        'double','decimal','datetime','timestamp','time','year','char','tinyblob','blob',
        'tinytext','mediumblob','mediumtext','longblob','longtext','enum','set','bool','binary','varbinary');
        
        if(in_array($dataType, $this->validType)){
            $this->type = $dataType;
        }else{
            exit("ERROR: Invalid data type. Check datatype of column values.");
        }   
    }
}


/**
 * Row: Represents a row obtained from a SQL Database. It contains the rows 
 * fields and well as the value associated to each field.
 * 
 */

class row {
    
    public $rowArray;
    
    public function __construct() {
        $this->rowArray = array();
    }
    
    public function addItem($item){
        array_push($this->rowArray, $item);
        
        //echo $item['id'];       <===== Nice note... could be useful...
    }
        
    /**
     *  Returns the result from a SQL query. Each row from the query is stored
     *  in an associatve array. The method returns an array of of rows from 
     *  the query. When no parameter is passed, the entire result with all
     *  of its associated rows will be returned in one large array.
     *      Implimentation: 
     *          $tableRow = $test->getRow();       
     *          foreach($tableRow as $row){
     *              foreach($row as $field => $value){...}
     *         }
     * 
     * @param int $i Get specified row.
     * @return array 
     */
    
    public function getRow($i=null){
        if($i===null){
            return $this->rowArray;
        }else{
            return $this->rowArray[$i];
        }
    }
    
    /**
     * Removes the given column's values from the SQL query result. 
     *
     * @param array(string) $array 
     */
    
    public function ignore($array){
        foreach($array as $keyToCheck){
            if(array_key_exists($keyToCheck, $this->rowArray[0])){                 
                foreach($this->rowArray as $row => $subArray){
                    unset($this->rowArray[$row][$keyToCheck]);
                }      
            }    
        }     
    }
    
}


/**
 *  Represents a link to be used in a navigation list. 
 *  The navLink gets its attributes from a database page and its
 *  parent CMSNavigation. The CMS Navigation uses instances of
 *  navLink to build its navigation list. 
 */

class navLink{
    
    public $category;
    public $tag;
    public $pageName;
    public $subCategory;
    public $pageType;
    public $parentName;
    
    private $subNavList;
    
    public function __construct($category) {
        $this->category = $category;
    }
    
    public function setTag($tagName){
        $this->tag = $tagName;
    }
    
    public function setName($pageName){
        $this->pageName = $pageName;
    }
    
    public function setSubCategory($subCategory){
        $this->subCategory = $subCategory;
    }
    
    public function setPagetype($pageType){
        $this->pageType = $pageType;
    }
    
    public function setParentName($parentName){
        $this->parentName = $parentName;
    }
    
    public function appendSubNav($subNavItem){
        $this->subNavList[] = $subNavItem;
    }
    
    public function getName(){
        return $this->pageName;
    }
    
    public function display(){
        $result = $this->toLink($this->pageName);
        if(count($this->subNavList) > 0){
            $subNav ='<ul>';
            foreach($this->subNavList as $link){
                $subNav .= $this->toLink($link);
            }
            $subNav .= "</ul>";
            $result .= $subNav;
        }
        
        return $result;
        
    }
    
    private function clean($text){
        $result = strtolower($text);
        $result = str_replace('_', ' ', $result);
        $result = ucwords($result);
        return $result;
    }
    
    private function toLink($page){
        return "<li><a href='?category=".$this->category."&page=$page'>".$this->clean($page)."</a></li>";
    }
 
}

?>
