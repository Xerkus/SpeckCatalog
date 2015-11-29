<?php

namespace SpeckCatalog\Mapper;

use SpeckCatalog\Model\AbstractModel;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Option extends AbstractMapper
{
    protected $tableName = 'catalog_option';
    protected $model = '\SpeckCatalog\Model\Option\Relational';
    protected $tableKeyFields = ['option_id'];
    protected $tableFields = ['option_id', 'name', 'instruction', 'required', 'builder', 'option_type_id'];

    public function find(array $data)
    {
        return parent::find(['option_id' => $data['option_id']]);
    }

    public function getByProductId($productId, array $fields = [])
    {
        $linker = 'catalog_product_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect()
            ->join($linker, $joinString)
            ->where(['product_id' => (int) $productId])
            ->order('sort_weight', 'ASC');
        foreach ($fields as $key => $val) {
            $select->where([$key => $val]);
        }
        return $this->selectManyModels($select);
    }

    public function getByParentChoiceId($choiceId)
    {
        $linker = 'catalog_choice_option';
        $table = $this->getTableName();
        $joinString = $linker . '.option_id = ' . $table . '.option_id';

        $select = $this->getSelect()
            ->join($linker, $joinString)
            ->where([$linker . '.choice_id' => (int) $choiceId])
            ->order('sort_weight', 'ASC');
        return $this->selectManyModels($select);
    }

    public function sortChoices($optionId, $order)
    {
        $table = 'catalog_choice';
        foreach ($order as $i => $choiceId) {
            $where = ['option_id' => $optionId, 'choice_id' => $choiceId];
            $select = $this->getSelect($table)->where($where);
            $row = $this->queryOne($select);
            $row['sort_weight'] = $i;
            $this->update($row, $where, $table);
        }
    }

    public function insert($option, $tableName = null, HydratorInterface $hydrator = null)
    {
        $optionId = parent::insert($option, $tableName, $hydrator);
        $option = $this->find(['option_id' => $optionId]);

        return $option;
    }
}
