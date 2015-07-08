<?php

class form{
    
    private $form;
    
    public function __construct($id='',$class='',$formAction=''){
        $this->form = "<form id='".$id."' class='".$class." method='post' action='".$formAction."'>";   
    }
    
    public function addElement($text,$value,$type='',$id='',$class=''){
        $label = new html_element('label');
        $label->set('text', $this->clean($text));
        
        $element = new html_element('input');
        $element->set('id',$id);
        $element->set('class',$class);
        $element->set('value',$value);
        if($type!='')
            $element->set('type',$type);
        $this->form .= $label->build().$element->build();
    }  
    
    public function buildForm(){        
     return $this->form .= "<input type='submit' value='Submit'/></form>";
    }

    private function clean($text){        
        $text = strtolower($text);
        $text = ucfirst($text);
        return $text;
    }

    


}

?>
