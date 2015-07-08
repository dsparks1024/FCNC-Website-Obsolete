<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/frameworks/DomsFramework/Database/Database.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/frameworks/DomsFramework/CMS/htmlElement.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/frameworks/DomsFramework/CMS/form.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMSComponents
 *
 * @author dsparks1024
 */
class CMSComponents {
    
    private $db;
    private $formAction;
    private $result;
    private $form;

    /**
     *  Constructs a CMS object that can be used to display certain CMS
     *  related elemnts. 
     * @param Database $db Database object that has a selected table for actions to 
     * be preformed on.
     */
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    
    /**
     * Creates a new html form. The createInput method must also be called 
     * followed by the displayForm method in order to display the form. 
     * 
     * @param string $id ID given to the form.
     * @param string $class Class given to the form.
     * @param string $formAction Overides default form action path.
     * @param string $rowSelector Used to select only on specific row.
     * @param string $rowSelectorValue  Used to select only on specific row.
     */
    
    public function createForm($id='',$class='',$formAction='',$rowSelector=null,$rowSelectorValue=null){   
        if($rowSelectorValue==null&&$rowSelector!=null){     // Needs to be changed if more parameters are added
            exit("ERROR: Missing an optional parameter");
        }        
        if($rowSelector==null){     //Default Case
            $this->result = $this->db->retrieve();
        }else{
            $this->result = $this->db->retrieve($rowSelector,$rowSelectorValue);    
        }
        $this->form = new form($id,$class,$formAction);
    }
    
    /**
     * Takes arguments to create each input element in the form, by setting their 
     * attributes. 
     * 
     * @param string $id ID given to each input element (general id will be distingusiable)
     * @param string $class Class given to each input element in the form.
     * @param string $type  The type given to each element.
     */
    
    public function createInput($id='',$class='',$type=''){
        /* if column type =longtext, display a textarea.... */
        
        $tableRows = $this->result->getRow();     // Gets all rows from table
        /* Do Something to make the id unique for each input */
         foreach($tableRows as $row){          
            foreach($row as $field => $value){
               if($field!='id')
               $this->form->addElement($field, $value,$type,$id,$class);
            }
         }
    }
    
    /**
     *  @return string  Displays the form. 
     */

    public function displayForm(){
        echo $this->form->buildForm();
    }
  
}

?>
