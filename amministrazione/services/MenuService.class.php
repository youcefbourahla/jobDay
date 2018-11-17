<?php
$path = $_SERVER['DOCUMENT_ROOT']."/site/";
include_once $path.'amministrazione/classes/Menu.class.php';

class MenuService
{
	private $db;

	function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
    public function getAll() {

        $menus = array();
        try
        {
            $sql =  'SELECT * FROM menu';
            if ($res =  $this->db->query($sql)) {
                if ($res->fetchColumn() > 0) {
                    foreach  ($this->db->query($sql) as $menuRow) {
                        $menu = new Menu($menuRow['id'], $menuRow['title'], $menuRow['description'], $menuRow['parent_id'], $menuRow['active']);
                        
                        array_push($menus, $menu);
                    };
                }
            }
            return $menus;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
    
    public function getAllTree() {

    	$menus = array();
		try
        {
	    	$sql =  'SELECT * FROM menu where parent_id=0';
	     	if ($res =  $this->db->query($sql)) {
	        	if ($res->fetchColumn() > 0) {
	        		foreach  ($this->db->query($sql) as $menuRow) {
                        $menu = new Menu($menuRow['id'], $menuRow['title'], $menuRow['description'], $menuRow['parent_id'], $menuRow['active']);
                        $item = array();
						$item['menu'] = $menu;
                        $item['children'] = $this->getChildren($menuRow['id']);
                        array_push($menus, $item);
	                };
                }
	        }
	        return $menus;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function save($menu) {
    	try {
            $stmt = $this->db->prepare("INSERT INTO menu (title, description, parent_id,active) VALUES (:title,:description,:parentid,:active)");
            $result = $stmt->execute(array(
              ':title'   => $menu->getTitle(),
              ':description' => $menu->getDescription(),
              ':parentid'   => $menu->getParentId(),
              ':active' => $menu->getActive()
            ));
            return $result;
        }
        catch(PDOException $e)
        {
           echo $e->getMessage();
        }
    }

    public function getRootMenu($menu) {
        $menus = array();
        try
        {
            $sql =  'SELECT * FROM menu where parent_id=0';
            if ($res =  $this->db->query($sql)) {
                if ($res->fetchColumn() > 0) {
                    foreach  ($this->db->query($sql) as $menuRow) {
                        $menu = new Menu($menuRow['id'], $menuRow['title'], $menuRow['description'], $menuRow['parent_id'], $menuRow['active']);
                        array_push($menus, $menu);
                    };
                }
            }
            return $menus;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }

    public function getChildren($parentId) {

        $menus = array();
        try
        {
            $sql =  'SELECT * FROM menu where parent_id='.$parentId;
            if ($res =  $this->db->query($sql)) {
                if ($res->fetchColumn() > 0) {
                    foreach  ($this->db->query($sql) as $menuRow) {

                        $child = new Menu($menuRow['id'], $menuRow['title'], $menuRow['description'], $menuRow['parent_id'], $menuRow['active']);
                        array_push($menus, $child);
                    };
                }
            }
            return $menus;
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }
    }
}
