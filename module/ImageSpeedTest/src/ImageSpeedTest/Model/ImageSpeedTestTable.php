<?php
namespace ImageSpeedTest\Model;

use Zend\Db\TableGateway\TableGateway;

class ImageSpeedTestTable
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

    public function getImageSpeedTest($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveImageSpeedTest(ImageSpeedTest $imagespeedtest)
    {
        $data = array(
            'artist' => $imagespeedtest->artist,
            'title'  => $imagespeedtest->title,
        );

        $id = (int)$imagespeedtest->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getImageSpeedTest($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteImageSpeedTest($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}