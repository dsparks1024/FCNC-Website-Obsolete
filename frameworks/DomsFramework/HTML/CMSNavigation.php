<?php

/**
 * Description of navBuilder
 *
 * @author dsparks1024
 */

/**
 *  CMSNavigation builds a navigation list from a group of selected
 *  pages in a database. All the pages must have the same category to 
 *  be placed in the navigation list. The class will search for all pages
 *  and subPages and will construct an unordered list. 
 */

class CMSNavigation {

    public $category;
    private $db;
    private $mainList;
    private $subList;
    private $categories;
    private $subNavExists;

    public function __construct($db, $category) {
        $this->db = $db;
        $this->category = $category;
    }

    // 1. Gather all pages that of relevent category
    // 2. Create navItems for each of the "Main Menu" links

    private function gatherPages() {  // MAKE PRIVATE
        $this->db->setTable('pages');
        $result = $this->db->retrieve('category', $this->category);

        $results = $result->getRow();

        // Set up the "Main" navigation

        foreach ($results as $row) {
            
            
            $link = new navLink($this->category);

            $link->setName($row['pageName']);
            $link->setSubCategory($row['subCategory']);
            $this->categories[] = $row['subCategory'];
            if ($row['type'] == 'page') {
                $this->mainList[] = $link;
            }

            if ($row['type'] == 'subPage') {
                $this->subList[] = $link;
                $link->setParentName($row['parent']);
                $this->subNavExists = true;
            }
        }
        
        $this->seperateCategories();
    }

    // 3. Sepereate items into catorgories
    private function seperateCategories() {
        $categories = array_unique($this->categories);
        $this->categories = array_values($categories);
    }

    // 4. Go through the "type" subPages and append them to their "Main Menu" parents
    private function appendSubNavs() {   
        foreach ($this->subList as $subLink) {
            for ($i = 0; $i < count($this->mainList); $i++) {
                if ($this->mainList[$i]->pageName == $subLink->parentName) {
                    $this->mainList[$i]->appendSubNav($subLink->pageName);
                }
            }
        }        
    }
    

    // 5. Print out the compiled unordered list

    public function display() {

        $this->gatherPages();
        if ($this->subNavExists)
            $this->appendSubNavs();

        $result = '<ul>';
         
        foreach ($this->categories as $category) {

            $result .= "<h3> " . $category . "</h3>";

            for ($i = 0; $i < count($this->mainList); $i++) {
                if ($this->mainList[$i]->subCategory == $category && $this->mainList[$i]->pageName != 'main') {
                    $result .= $this->mainList[$i]->display();
                }
            }
        }
        
        $result .= "</ul>";

        echo $result;
    }

}

?>
