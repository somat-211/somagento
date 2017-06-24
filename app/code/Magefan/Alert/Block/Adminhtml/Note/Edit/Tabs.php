<?php

namespace Magefan\Alert\Block\Adminhtml\Note\Edit;
/**
 * Admin page left menu
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('note_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Note Information'));

         $this->addTab('note_form', array(
                'label'     => __('Note Information'),
                'title'     => __('Note Information'),
                'content'   => $this->getLayout()->createBlock('Magefan\Alert\Block\Adminhtml\Note\Edit\Tab\Main')->toHtml(),
                
        ));
    }

    
}
