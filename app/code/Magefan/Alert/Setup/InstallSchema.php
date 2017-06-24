<?php
/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/


namespace Magefan\Alert\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Create table 'mf_alert_note'
         */
      
        $noteTable = $installer->getConnection()->newTable($installer->getTable('mf_alert_note'))
            ->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Title'
            )
            ->addColumn(
                'content',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Content'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                1,
                ['nullable' => false],
                'Status'
            )
            ->addColumn(
                'display_from',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Display From'
            )
            ->addColumn(
                'display_to',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                [],
                'Display To'
            )
           
            ->addColumn(
                'img_file',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                ['nullable' => false],
                'Image File'
            );
           
        $installer->getConnection()->createTable($noteTable);

        /**
         * Create table 'mf_alert_note_store'
         */
        $storeTable = $installer->getConnection()
            ->newTable(
                $installer->getTable('mf_alert_note_store')
            )->addColumn(
                'note_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Note ID'
            )->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Store ID'
            )->addIndex(
                $installer->getIdxName('mf_alert_note_store', ['note_id']),
                ['note_id']
            )->addIndex(
                $installer->getIdxName('mf_alert_note_store', ['note_id']),
                ['store_id']
            )->addForeignKey(
                $installer->getFkName('mf_alert_note_store', 'note_id', 'mf_alert_note', 'id'),
                'note_id',
                $installer->getTable('mf_alert_note'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('mf_alert_note_store', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'Magefan note To Store Relation Table'
            );
        $installer->getConnection()->createTable($storeTable);

        /**
         * Create table 'mf_alert_note_customer_group'
         */
        $customerGroupTable = $installer->getConnection()
            ->newTable(
                $installer->getTable('mf_alert_note_customer_group')
            )->addColumn(
                'note_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Note ID'
            )->addColumn(
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false],
                'Customer Group ID'
            )->addIndex(
                $installer->getIdxName('mf_alert_note_customer_group', ['note_id']),
                ['note_id']
            )->addIndex(
                $installer->getIdxName('mf_alert_note_customer_group', ['customer_group_id']),
                ['customer_group_id']
            )->addForeignKey(
                $installer->getFkName('mf_alert_note_customer_group', 'note_id', 'mf_alert_note', 'id'),
                'note_id',
                $installer->getTable('mf_alert_note'),
                'id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName(
                    'mf_alert_note_customer_group',
                    'customer_group_id',
                    'customer_group',
                    'customer_group_id'
                ),
                'customer_group_id',
                $installer->getTable('customer_group'),
                'customer_group_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment(
                'MF  Note To Customer Group Relation Table'
            );
        $installer->getConnection()->createTable($customerGroupTable);

     

        $installer->endSetup();
    }
}
