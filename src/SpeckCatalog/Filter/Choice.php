<?php

namespace SpeckCatalog\Filter;

use Zend\Filter\ToNull;
use Zend\InputFilter\InputFilter;

class Choice extends Inputfilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'choice_id',
            'allow_empty' => true,
            'filters'   => array(
                new ToNull(ToNull::TYPE_STRING),
            ),
        ));
        $this->add(array(
            'name' => 'option_id',
        ));
        $this->add(array(
            'name' => 'product_id',
            'filters'    => array(array('name' => 'Null')),
            'allow_empty' => 'true',
        ));
        $this->add(array(
            'name' => 'override_name',
            'allow_empty' => 'true',
        ));
    }
}
