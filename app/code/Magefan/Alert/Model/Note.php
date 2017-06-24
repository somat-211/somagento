<?php
namespace Magefan\Alert\Model;

/**
 * Class Note
 * @package Magefan\Alert\Model
 */
class Note extends \Magento\Framework\Model\AbstractModel
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        //$parent::_construct();
        $this->_init('Magefan\Alert\Model\ResourceModel\Note');
    }
}
