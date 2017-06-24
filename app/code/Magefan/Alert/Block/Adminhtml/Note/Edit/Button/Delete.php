<?php
namespace Magefan\Alert\Block\Adminhtml\Note\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
//use Magefan\Alert\Api\NoteRepositoryInterface;

/**
 * Class Delete
 * @package Magefan\Alert\Block\Adminhtml\Slide\Edit\Button
 */
class Delete implements ButtonProviderInterface
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var SlideRepositoryInterface
     */
    //private $slideRepository;

    /**
     * @param Context $context
     * @param SlideRepositoryInterface $slideRepository
     */
    public function __construct(
        Context $context
        //NoteRepositoryInterface $noteRepository
    ) {
        $this->context = $context;
        //$this->slideRepository = $slideRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getButtonData()
    {
        $data = [];
        if ($id = $this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => sprintf(
                    "deleteConfirm('%s', '%s')",
                    __('Are you sure you want to do this?'),
                    $this->getUrl('*/*/delete', ['id' => $id])
                ),
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * Return slide ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $id = $this->context->getRequest()->getParam('id');
       /* if ($id && $this->noteRepository->get($id)) {
            return $this->noteRepository->get($id)->getId();
        }*/
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
