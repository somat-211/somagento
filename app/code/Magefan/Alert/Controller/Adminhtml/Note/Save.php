<?php

namespace Magefan\Alert\Controller\Adminhtml\Note;

use Magefan\Alert\Controller\Adminhtml\Note as NoteController;
use Magento\Framework\Registry;
use Magefan\Alert\Model\NoteFactory;
use Magento\Backend\Model\Session as BackendSession;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Request\DataPersistorInterface;



class Save extends NoteController
{
    /**
     * backend session
     *
     * @var BackendSession
     */
    protected $backendSession;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * constructor
     *
     * @param Registry $registry
     * @param BannersliderFactory $bannerFactory
     * @param BackendSession $backendSession
     * @param PageFactory $resultPageFactory
     * @param Context $context
     * @param RedirectFactory $resultRedirectFactory
     */
    protected $dataPersistor;
    public function __construct(
        Registry $registry,
        PageFactory $resultPageFactory,
        NoteFactory $noteFactory,
        DataPersistorInterface $dataPersistor,
        Context $context
    )
    {
        $this->backendSession = $context->getSession();
        $this->resultPageFactory = $resultPageFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($registry, $noteFactory,$context);
    }
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
     public function execute()
    {
       
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $model = $this->_objectManager->create('Magefan\Alert\Model\Note');
            $id = $this->getRequest()->getParam('id');
          
            if ($id) {
                  $model->load($id);
                    
              }
            if(empty($data['id']))
            {
                        $data['id'] = null;
            }    
           
       
         //echo '<pre>'; print_r($data); echo '</pre>';exit;
           
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This note no longer exists.'));
            }
            /*var_dump($data);
            exit;*/
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the note.'));
                $this->dataPersistor->clear('magefan_alert_note');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the note.'));
            }

            $this->dataPersistor->set('magefan_alert_note', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magefan_Alert::note');
    }
}
