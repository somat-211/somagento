<?php
namespace Magefan\Alert\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\RedirectFactory;
use Magefan\Alert\Model\NoteFactory;
use Magento\Framework\Registry;


abstract class Note extends Action
{
    /**
     * inquiry factory
     *
     * @var AuthorFactory
     */
    protected $noteFactory;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * date filter
     *
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @param Registry $registry
     * @param AuthorFactory $bannerFactory
     * @param RedirectFactory $resultRedirectFactory
     * @param Context $context
     */
    public function __construct(
        Registry $registry,
        NoteFactory $noteFactory,
        Context $context
    )
    {
        $this->coreRegistry = $registry;
        $this->noteFactory = $noteFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();
        parent::__construct($context);
    }

    
    protected function initNote()
    {
        $noteId  = (int) $this->getRequest()->getParam('id');        
        $note    = $this->noteFactory->create();
        if ($noteId) {
            $note->load($noteId);
        }
        $this->coreRegistry->register('magefan_alert', $note);
        return $note;
    }



}
