<?php
namespace Casefile\Model;

use Zend\Db\TableGateway\TableGateway;

class CasefileTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCasefile($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCasefile(Casefile $casefile)
    {
        $data = array(
            'artist' => $casefile->artist,
            'title'  => $casefile->title,
        );

        $id = (int)$casefile->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCasefile($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCasefile($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}