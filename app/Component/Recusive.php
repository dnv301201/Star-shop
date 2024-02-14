<?php
namespace App\Component;

 class Recusive{

    private $data;
    private $addSelect='';
    public function __construct($data){

        $this -> data = $data;

    }

    public function categoryRecusive($parentId,$id = 0,$text='')
    {
        foreach($this -> data as $value){
            if($value['parent_id']==$id)
            {
                if (!empty($parentId) && $parentId == $value['id'])
                {
                $this->addSelect .= "<option selected value='" . $value['id']."'>" . $text . $value['name']. "</option>";
                }
                else{
                
                    $this->addSelect .= "<option value='" . $value['id']."'>" . $text  . $value['name']. "</option>";
                }
                $this->categoryRecusive($parentId, $value['id'], $text. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
            }
            
        }
        return $this->addSelect;
    }
}
