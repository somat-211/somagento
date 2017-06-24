<?php
namespace Magefan\Alert\Model\ResourceModel;

/**
 * Class Note
 * @package Magefan\Alert\Model\ResourceModel
 */
class Note extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mf_alert_note', 'id');
    }
}
