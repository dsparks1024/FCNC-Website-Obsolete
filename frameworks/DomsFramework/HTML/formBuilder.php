<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/frameworks/DomsFramework/CMS/htmlElement.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/frameworks/DomsFramework/Database/Database.php';


/**
 *  formBuilder bulids a bootstraped form. It will be paralled to be used with 
 *  json responcses and a jquery plugin to handle invalid responses. 
 *
 * @author Dominick Sparks
 */

/**
 * ** Must use an array for the option values.
 * 
 * @param type $fieldName
 * @param type $values
 * @param type $id
 * @param type $class 
 */

class formBuilder {

    private $form;
    private $customButton;
    private $buttonGroup;

    public function __construct($action, $id = '', $class = '', $database = null) {
        $this->form = "<form method='post' id='$id' class='$class form-horizontal' action='$action'>";
        $this->customButton = false;
        // ADD DATABASE IF IT IS NEEDED IM NOT SURE LOL ;)
    }
    
    public function addHeader($text,$id='',$class=''){
        $this->form .= "<h3 id='$id' class='$class'>$text</h3>";
    }

    public function addTextInput($fieldName, $placeHolder, $type='', $id = '', $class = '', $value = '') {
        $this->form .= "<div class='control-group'>";
        $this->form .= "<label class='control-label' for='$fieldName'>$fieldName</label>";
        $this->form .= "<div class='controls'>";
        $this->form .= "<input id='$id' name='$id' class='$class' type='$type' placeholder='$placeHolder' value='$value'/>";
        $this->form .= "<span id='".$id."Help' class='help-block'></span>";
        $this->form .= "</div></div>";
    }
    
    public function addTextInputAppendCal($fieldName, $placeHolder, $type='', $calID, $id = '', $class = '', $value = '') {
        $this->form .= "<div class='control-group'>";
        $this->form .= "<label class='control-label' for='$fieldName'>$fieldName</label>";
        $this->form .= "<div class='controls'>";
        $this->form .= "<div class='input-append'>";
        $this->form .= "<input type='text' id='$id' name='$id' class='$class' type='$type' placeholder='$placeHolder' value='$value'/>";
        $this->form .= "<button class='btn' id='$calID'><i class='icon icon-calendar'></i></button></div></div></div>";
    }

    public function addTextarea($fieldName, $placeHolder, $id = '', $class = '', $value = '') {
        $this->form .= "<div class='control-group'>";
        $this->form .= "<label class='control-label' for='$fieldName'>$fieldName</label>";
        $this->form .= "<div class='controls'>";
        $this->form .= "<textarea id='$id' name='$id' class='$class' placeholder='$placeHolder'>$value</textarea>";
        $this->form .= "</div></div>";
    }

    public function addSelect($fieldName, $values, $id = '', $class = '') {
        $this->form .= "<div class='control-group'>";
        $this->form .= "<label class='control-label' for='$fieldName'>$fieldName</label>";
        $this->form .= "<div class='controls'>";
        $this->form .= "<select id='$id' name='$id' class='$class'>";
        foreach ($values as $value) {
            $this->form .= "<option value='$value'>$value</option>";
        }
        $this->form .= "</select></div></div>";
    }
    
    public function addLinkText($text,$id,$href){
        $this->form .= "<div class='controls'>";
        $this->form .= "<span class='help-block'><a id='$id' href='$href'>$text</a></span>";
        $this->form .= "</div>";
    }
    
    public function addButton($text,$type,$id='',$class=''){
        $this->customButton = true;
        $this->buttonGroup .= "<button type='$type' name='$id' class='btn $class' id='$id'>$text</button>";
    }

    public function display($submit='') {
        if(!$this->customButton){
            $this->form .= "<div class='form-actions'><button type='submit' class='btn'>$submit</button></div></form>";
        }else{
            $this->form .= "<div class='form-actions'>".$this->buttonGroup."</div></form>";
        }
        echo $this->form;
    }

}

?>
