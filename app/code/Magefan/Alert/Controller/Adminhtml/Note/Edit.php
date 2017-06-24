<?php

namespace Magefan\Alert\Controller\Adminhtml\Note;

use Magefan\Alert\Controller\Adminhtml\Note as NoteController;
use Magento\Framework\Registry;
use Magefan\Alert\Model\NoteFactory;
use Magento\Backend\Model\Session as BackendSession;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magento\Framework\View\Result\PageFactory;


class Edit extends NoteController
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
    public function __construct(
        Registry $registry,
        PageFactory $resultPageFactory,
        NoteFactory $noteFactory,
        Context $context
    )
    {
        $this->backendSession = $context->getSession();
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($registry, $noteFactory,$context);
    }
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {

       
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        /** @var \Magefan\Alert\Model\Attachment $attachment*/
        $note = $this->initNote();
        
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magefan_Alert::note');
        $resultPage->getConfig()->getTitle()->set((__('Note')));

        // 2. Initial checking
        if ($id) {
            $note->load($id);
            if (!$note->getId()) {
                $this->messageNoter->addError(__('This Note no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath(
                    'note/*/edit',
                    [
                        'id' => $note->getId(),
                        '_current' => true
                    ]
                );
                return $resultRedirect;
            }
        }

        // 3. Set entered data if was error when we do save

        $title = $note->getId() ? $note->getTitle() : __('New Note');
        $resultPage->getConfig()->getTitle()->append($title);
        $data = $this->backendSession->getData('magefan_alert_alert', true);
        if (!empty($data)) {
            $note->setData($data);
        }
        
        return $resultPage;

    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magefan_Alert::note');
    }
}
