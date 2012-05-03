<?php

namespace Catalog\Model\Mapper;
use Catalog\Model\Choice,
    ArrayObject;

class ChoiceMapper extends ModelMapperAbstract
{
    protected $parentOptionLinkerTable;
    protected $childOptionLinkerTable;
    
    public function getModel($constructor = null)
    {
        return new Choice($constructor);
    }

    public function getChoicesByParentOptionId($optionId)
    {
        $linkerName = $this->getParentOptionLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.' . $this->getIdField() . ' = ' . $linkerName . '.' . $this->getIdField())
            ->where(array('option_id' => $optionId));
        //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);   
    }

    public function old_getChoicesByParentOptionId($optionId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->join('catalog_option_choice_linker', 'catalog_option_choice_linker'.'.choice_id = '.$this->getTableName().'.choice_id') 
                  ->where('option_id = ?', $optionId)
                  ->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }

    public function getChoicesByChildProductId($productId)
    {
        $select = $this->newSelect();
        $select->from($this->getTable()->getTableName())
            ->where(array('product_id' => $productId));
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);  
    }

    public function old_getChoicesByChildProductId($productId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
                  ->from($this->getTableName())
                  ->where('product_id = ?', $productId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);
    }

    public function linkParentOption($optionId, $choiceId)
    {
        $table = $this->getParentOptionLinkerTable();
        $row = array(
            'choice_id' => $choiceId,
            'option_id' => $optionId,
        );
        return $this->insertLinker($table, $row); 
    }
    public function getChoicesByChildOptionId($optionId)
    {
        $linkerName = $this->getChildOptionLinkerTable()->getTableName();
        $select = $this->newSelect();
        $select->from($this->getTableName())
            ->join($linkerName, $this->getTableName() . '.' . $this->getIdField() . ' = ' . $linkerName . '.' . $this->getIdField())
            ->where(array('option_id' => $optionId));
            //->order('sort_weight DESC');
        $this->events()->trigger(__FUNCTION__, $this, array('select' => $select));   
        $rowset = $this->getTable()->selectWith($select);

        return $this->rowsetToModels($rowset);  
    }



    //note: this was wrong!  look at the prop.
    public function old_getChoicesByChildOptionId($choiceId)
    {
        $db = $this->getReadAdapter();
        $sql = $db->select()
            ->from('catalog_choice_option_linker')
            ->join($this->getTableName(), 'catalog_choice_option_linker.choice_id = ' . $this->getTableName() . '.choice_id')
            ->where('choice_id = ?', $choiceId);
        $this->events()->trigger(__FUNCTION__, $this, array('query' => $sql));
        $rows = $db->fetchAll($sql);

        return $this->rowsToModels($rows);   
    } 

    public function updateOptionChoiceSortOrder($order)
    {
        return $this->updateSort('catalog_option_choice_linker', $order);
    }   

    public function removeLinker($linkerId)
    {
        return $this->deleteLinker('catalog_option_choice_linker', $linkerId);
    }     

    public function getParentOptionLinkerTable()
    {
        return $this->parentOptionLinkerTable;
    }

    public function setParentOptionLinkerTable($parentOptionLinkerTable)
    {
        $this->parentOptionLinkerTable = $parentOptionLinkerTable;
        return $this;
    }

    public function getChildOptionLinkerTable()
    {
        return $this->childOptionLinkerTable;
    }

    public function setChildOptionLinkerTable($childOptionLinkerTable)
    {
        $this->childOptionLinkerTable = $childOptionLinkerTable;
        return $this;
    }
}
