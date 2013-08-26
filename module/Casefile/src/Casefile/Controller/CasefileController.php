<?php

/* Finally, weÕll update each action to use Doctrine 
and the Casefile class instead of Zend_Db and the CasefileTable class.*/

namespace Casefile\Controller;

use Zend\View\Model\ViewModel, 
    Casefile\Form\CasefileForm,
    Doctrine\ORM\EntityManager,
    Casefile\Entity\Casefile;
use Zend\Mvc\Controller\AbstractActionController;



class CasefileController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
 
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    } 

    public function indexAction()
    {
        return new ViewModel(array(
            'casefiles' => $this->getEntityManager()->getRepository('Casefile\Entity\Casefile')->findAll() 
        ));
    }

    public function addAction()
    {
        $form = new CasefileForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $casefile = new Casefile();
            
            $form->setInputFilter($casefile->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) { 
                $casefile->populate($form->getData()); 
                $this->getEntityManager()->persist($casefile);
                $this->getEntityManager()->flush();

                // Redirect to list of casefiles
                return $this->redirect()->toRoute('casefile'); 
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('casefile', array('action'=>'add'));
        } 
        $casefile = $this->getEntityManager()->find('Casefile\Entity\Casefile', $id);

        $form = new CasefileForm();
        $form->setBindOnValidate(false);
        $form->bind($casefile);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();

                // Redirect to list of casefiles
                return $this->redirect()->toRoute('casefile');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('casefile');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                //$id = (int)$request->getPost()->get('id');
                $casefile = $this->getEntityManager()->find('Casefile\Entity\Casefile', $id);
                
                if ($casefile) {
                	
                    $this->getEntityManager()->remove($casefile);
                    $this->getEntityManager()->flush();
                }
            }

            // Redirect to list of casefiles
            //return $this->redirect()->toRoute('casefile');
            
            return $this->redirect()->toRoute('casefile', array(
                'controller' => 'casefile',
                'action'     => 'index',
            ));
            
        }

        return array(
            'id' => $id,
            'casefile' => $this->getEntityManager()->find('Casefile\Entity\Casefile', $id)->getArrayCopy()
        );
    }
}