<?php

namespace Magefan\Alert\Model\ResourceModel\Note;

use Magefan\Alert\Model\ResourceModel\AbstractCollection;
use Magefan\Alert\Model\Note;
use Magefan\Alert\Model\ResourceModel\Note as ResourceNote;
use Magento\Store\Model\Store;
use Magento\Framework\DB\Select;

/**
 * Class Collection
 * @package Magefan\Alert\Model\ResourceModel\Note
 */
class Collection extends AbstractCollection
{
    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(Note::class, ResourceNote::class);
    }

    /**
     * {@inheritdoc}
     */
    protected function _afterLoad()
    {
       
        $this->attachRelationTable('mf_alert_note_store', 'id', 'note_id', 'store_id', 'store_ids');
        /*$this->attachRelationTable(
            'aw_rbslider_slide_customer_group',
            'id',
            'slide_id',
            'customer_group_id',
            'customer_group_ids'
        );*/
        return parent::_afterLoad();
    }


}
