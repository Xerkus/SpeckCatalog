<?php

namespace SpeckCatalog\Mapper;

class Uom extends AbstractMapper
{
    protected $tableName = 'ansi_uom';
    protected $model = '\SpeckCatalog\Model\Uom\Relational';
    protected $tableKeyFields = ['uom_code'];
}
