<?php

/**
 * Description of StickynotesTable
 *
 * @author Arian Khosravi <arian@bigemployee.com>, <@ArianKhosravi>
 */
// module/Stickynotes/src/Stickynotes/Model/StickynotesTable.php

namespace Stickynotes\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class StickynotesTable extends AbstractTableGateway {

    protected $table = 'stickynotes';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }

    public function fetchAll() {
        $resultSet = $this->select(function (Select $select) {
                    $select->order('created ASC');
                });
        $entities = array();
        foreach ($resultSet as $row) {
            $entity = new Entity\Stickynote();
            $entity->setId($row->id)
                    ->setNote($row->note)
                    ->setCreated($row->created);
            $entities[] = $entity;
        }
        return $entities;
    }

    public function getStickynote($id) {
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row)
            return false;

        $stickyNote = new Entity\Stickynote(array(
                    'id' => $row->id,
                    'note' => $row->note,
                    'created' => $row->created,
                ));
        return $stickyNote;
    }

    public function saveStickynote(Entity\Stickynote $stickyNote) {
        $data = array(
            'note' => $stickyNote->getNote(),
            'created' => $stickyNote->getCreated(),
        );

        $id = (int) $stickyNote->getId();

        if ($id == 0) {
            $data['created'] = date("Y-m-d H:i:s");
            if (!$this->insert($data))
                return false;
            return $this->getLastInsertValue();
        }
        elseif ($this->getStickynote($id)) {
            if (!$this->update($data, array('id' => $id)))
                return false;
            return $id;
        }
        else
            return false;
    }

    public function removeStickynote($id) {
        return $this->delete(array('id' => (int) $id));
    }

}