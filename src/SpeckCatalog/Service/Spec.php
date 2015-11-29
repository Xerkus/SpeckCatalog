<?php

namespace SpeckCatalog\Service;

class Spec extends AbstractService
{
    protected $entityMapper = 'speckcatalog_spec_mapper';

    public function find(array $data, $populate = false, $recursive = false)
    {
        $spec = $this->getEntityMapper()->find($data);
        if ($populate) {
            $this->populate($spec, $recursive);
        }
        return $spec;
    }

    public function getByProductId($productId)
    {
        return $this->getEntityMapper()->getByProductId($productId);
    }

    public function insert($spec)
    {
        $id = parent::insert($spec);
        $spec = $this->find(['spec_id' => $id]);

        return $spec;
    }
}
