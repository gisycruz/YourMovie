<?php 
namespace Models;

class Role{
    private $id_role;
    private $priority;

    public function __construct($id_role , $priority){
        $this->id_role = $id_role;
        $this->priority = $priority;
    }


    public function getId_role()
    {
        return $this->id_role;
    }

    public function setId_role($id_role)
    {
        $this->id_role = $id_role;

    }


    public function getPriority()
    {
        return $this->priority;
    }


    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}