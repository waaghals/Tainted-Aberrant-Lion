<?php
namespace PROJ\Entities;

/** 
 * @Entity 
 */
class VoorbeeldEntitie2 {
     /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * @Column(type="string")
     */
    private $name;
    
    /**
     * @Column(type="integer")
     */
    private $INTwaarde;
    
    /**
     * @OneToOne(targetEntity="\PROJ\Entities\VoorbeeldEntitie1", mappedBy="OneToOneRelation")
     */
    private $OneToOneRelation;
    
    /**
     * @ManyToOne(targetEntity="\PROJ\Entities\VoorbeeldEntitie1", inversedBy="OneToManyRelation")
     */
    private $ManyToOneRelation;
    
    /**
     * @ManyToMany(targetEntity="\PROJ\Entities\VoorbeeldEntitie1", inversedBy="ManyToManyRelation")
     */
    private $ManyToManyRelation;
    


    public function getManyToManyRelation() {
        return $this->ManyToManyRelation;
    }
    
    
    public function setManyToManyRelation($ManyToManyRelation) {
        $this->ManyToManyRelation = $ManyToManyRelation;
    
        return $this;
    }


    public function get_ManyToOneRelation() {
        return $this->ManyToOneRelation;
    }
    
    public function set_ManyToOneRelation($ManyToOneRelation) {
        $this->ManyToOneRelation = $ManyToOneRelation;
    
        return $this;
    }


    public function getOneToOneRelation() {
        return $this->OneToOneRelation;
    }
    
    public function setOneToOneRelation($OneToOneRelation) {
        $this->OneToOneRelation = $OneToOneRelation;
    
        return $this;
    }


    public function getINTwaarde() {
        return $this->INTwaarde;
    }
    
    public function setINTwaarde($INTwaarde) {
        $this->INTwaarde = $INTwaarde;
    
        return $this;
    }


    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    
        return $this;
    }
}
?>
