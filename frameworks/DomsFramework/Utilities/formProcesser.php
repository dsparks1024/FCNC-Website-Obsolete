<?php
    

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Constructs an object that allows different operations to be preformed on 
 * a submitted form. 
 * 
 * NOTE: setValidatedFields() or removeValidation must be called before submitting.
 *
 * @author Dominick Sparks
 */
class formProcesser {
    
    
    
    /* Impliment a write to a file function */
    
    
    
    private $formData;
    private $validationArray;
    private $isValidArray;
    
    public function __construct($formData) {
        $this->formData = $formData;
        unset($this->formData['submit']);
        $this->isValidArray = array();
    }
    
    /**
     *  Sets the fields of a from that are to be validated. Validation will
     *  check to see if the required fields are not blank, and will make sure
     *  the email field is of a valid form.
     * 
     * @param array[string](optional) $validatedFields An array that includes 
     * field names of a form that are to be validated. 
     * 
     */
    
    public function setValidatedFields($validatedFields=null){
        if($validatedFields == null){
            foreach($this->formData as $field => $value){
                $this->validationArray[$field] = true;
                $this->isValidArray[$field] = false;
            }        
        }else{
            foreach($validatedFields as $field=>$value){
                $this->validationArray[$value] = true;
                $this->isValidArray[$value] = false;
            }
        }
   }
   
   public function removeValidation(){
       foreach($this->isValidArray as $field=>$value){
           $this->isValidArray[$value] = true;
       }
   }
    
   /**
    * Checks to see if all of the required fields are valid.
    * 
    * @param string(optional) $field Checks if the given field is valid.
    * @return bool Returns true if the data is valid. 
    */
   
    public function isValid($field=null){
        if($field!=null){
            return $this->isValidArray[$field] === true;
        }else{
            return !(in_array(false, $this->isValidArray));
        }
    }
    
    /**
     * Prepares a form submission to be sent out as an email.
     * 
     * @param string $formName Name of the form, NO OTHER WORDS.
     * @param string $sendToAdress A string of the email address form is to be sent to.
     * For multiple addresses, seperate each address with a comma.
     * @param string $fromAddress Address that will apprear on recipents email client.
     * use the format, <DESIRED NAME>server@example.com. 
     */
    
    public function emailFormData($formName,$sendToAdress,$fromAddress){
        $this->validate(); // Validate the data.       
        $headers = "From: $fromAddress\r\nContent-type: text/html\r\n";
       
        $body = "<div style='font-family:arial;font-size:14pt;'>";
        $body .= "<h2 style='margin:0px'>".$formName." Form Results:</h2>";
        $body .= "<div style='font-size:10pt'><i>Form submitted on</i>: " . date('M j, Y')." at ". date('g:s a'). "</div><br/>";  
        $formName = $formName." Results";

        foreach($this->formData as $field => $value){
        /* Add a string formatter to clean up the field names */
            if(stristr($field,'phone'))
                $value = $this->formatPhone ($value);
            $body .= $this->formatString($field) .": <b>". ucfirst($value) ."</b></br>";
        }
        
        $body .= "</div>";
        echo $body;
       // if(!mail($sendToAdress, $formName, $body, $headers))
         //   exit("Results Failed to Send.");
    }
    
    public function postToDatabase(){
        $this->validate(); // Validate the Data.
    }
    
    /**
     * Prints the results of a form. 
     */
    
    public function displayResults(){
        foreach($this->formData as $field => $value){
            echo $field ."  :  ". $value ."</br>";
        }
    }
    
    /**
     * Gets the names of the fields that are not valid.
     * 
     * @return array Array contains the names of the invalid fields.  
     */
    
    public function getInvalidFields(){
        $invalidArray = array();
        foreach($this->isValidArray as $field => $value){
           if(!$value) array_push($invalidArray, $field);
        }   
        return $invalidArray;
    }
    
    
    /* Private Utility Functions */
    
    private function validate(){
        /* First check that all requried fields are filled in */
        if(!isset($this->validationArray)){
            exit("ERROR: Validation array has not been set.");
        }       
        foreach($this->validationArray as $field => $value){
            //echo $this->isValidArray[$field];
            $this->isValidArray[$field] = $this->formData[$field] != '';
        }
        if(!filter_var($this->formData['email'],FILTER_VALIDATE_EMAIL)){
            $this->isValidArray['email'] = false;
        }
        
        if(!$this->isValid()){
            echo "Please fill in the required field(s).<br/>";
            foreach($this->getInvalidFields() as $field){
                echo "<b>".$field."</b><br/>";
            }
            exit();
        }
    }
    
    private function formatString($text){
        $text = preg_replace('/([a-z])([A-Z])/','$1 $2', $text);
        return ucwords($text);
    }
    
   private function formatPhone($phone){
	$phone = preg_replace("/[^0-9]/", "", $phone);
 
	if(strlen($phone) == 7)
            return preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
	elseif(strlen($phone) == 10)
            return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
	else
            return $phone;
    }
}


/* Used in a different php file... that includeds the formProcesser,
 * to  allow for customized form processing options such as validation 
 * email formatting, database posting etc... */

//if(isset($_POST['submit'])){
  //  $data = new formProcesser($_POST);
    //$data->setValidatedFields();
    
    /*if($data->isValid())
        echo 'valid';
    else
     print_r($data->getInvalidFields());
    */
    //$data->displayResults();
    
   // $data->emailFormData("Contact", "test", "test");
    
//}

?>
