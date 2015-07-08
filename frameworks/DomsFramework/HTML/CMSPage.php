<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMSPage
 *
 * @author Dominick Sparks
 */
class CMSPage {
    
    public $pageName;
    public $category;
    
    private $db;
    private $page;

    public function __construct($db,$pageName,$category) {
        $this->pageName = $pageName;
        $this->category = $category;
        $this->db = $db;
        $this->getPage();
    }
    
    public function getBody(){
        
        switch($this->page['structureType']){
            
            case "formCenter":{
                echo "<h2>".$this->getTitle()."</h2>";
                echo "<p>".$this->page['body']."</p>";
                echo "<div class='form' style='width:500px;margin:auto;'>";
                eval($this->page['code']);
                echo "</div>";
                break;
            }
            case "custom":{
                echo 'this is a custom page';
                break;
            }
            case "employeeMain":{
                $db2 = $this->db;
                $db2->setTable('announcements');
                $data = $db2->retrieve();
                $array = $data->getRow();
                $array = array_reverse($array);
                    foreach($array as $row){  
                        echo "<dl><dt>".$row['title']."<i class='pull-right muted'>".$row['date']."</i></dt>";
                        echo "<dd>".$row['body']."</dd></dl>";
                    }
                break;
            }
            default:{
                if(!$this->imageExists()&& strcasecmp($this->pageName, 'main'))
                echo "<h2>".$this->getTitle()."</h2>";
                echo $this->page['body'];
            }
            
            
        }
        
    }
    
    public function getImage($h='',$w=''){
        if($this->imageExists()){
            echo "<div id='headImage'><img src='".$this->page['headImage']."' height='$h' width='$w'/></div>";
        }
    }
    
    public function getImageText(){
        if($this->imageExists()){
            echo "<div id='headImageText'>".$this->page['headText']."</div>";
        }
    }
    
    public function getImageAndText($h='',$w=''){
        if($this->imageExists()){
        echo "<div id='headImage'><img src='".$this->page['headImage']."' height='$h' width='$w'/>
               <div id='headImageText'>".$this->page['headText']."</div></div>";
        }
        else{
            echo "<style>#leftNav{position:static;float:left;}#pageContent{margin-top:50px;}</style>";
        }
    }

    private function getPage(){
        $this->db->setTable('pages');
        $this->page = $this->db->retrieveStrict(array('pageName'=>$this->pageName,'category'=>$this->category));
        $this->page = $this->page->getRow(0);
    }  
    
    private function imageExists(){
        return $this->page['headImage'] != '';
    }
    
    private function textExists(){
        return $this->page['headText'] != '';
    }
    
    private function getTitle(){
        $string = $this->pageName;
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);
        
        return $string;
    }
}
?>
