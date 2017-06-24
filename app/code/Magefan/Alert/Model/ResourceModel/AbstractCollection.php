<?php

namespace Magefan\Alert\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Collection;

/**
 * Class AbstractCollection
 * @package Magefan\Alert\Model\ResourceModel
 */
abstract class AbstractCollection extends Collection\AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function addFieldToFilter($field, $condition = null)
    {
        if ($field == 'note_id') {
            return $this->addNoteFilter($condition);
        }
        return parent::addFieldToFilter($field, $condition);
    }

   

    /**
     * Add note filter
     *
     * @param int|array $note
     * @return $this
     */
    public function addNoteFilter($note)
    {
        $this->addFilter('note_id', ['in' => $note], 'public');
        return $this;
    }

    /**
     * Attach relation table data to collection items
     *
     * @param string $tableName
     * @param string $columnName
     * @param string $linkageColumnName
     * @param string $columnNameRelationTable
     * @param string $fieldName
     * @return void
     */
    protected function attachRelationTable(
        $tableName,
        $columnName,
        $linkageColumnName,
        $columnNameRelationTable,
        $fieldName
    ) {
        $ids = $this->getColumnValues($columnName);
        if (count($ids)) {
            $connection = $this->getConnection();
            $select = $connection->select()
                ->from([$tableName . '_table' => $this->getTable($tableName)])
                ->where($tableName . '_table.' . $linkageColumnName . ' IN (?)', $ids);
            /** @var \Magento\Framework\DataObject $item */
            foreach ($this as $item) {
                $resultIds = [];
                $id = $item->getData($columnName);
                foreach ($connection->fetchAll($select) as $data) {
                    if ($data[$linkageColumnName] == $id) {
                        if ($fieldName == 'note_ids') {
                            $resultIds[$data[$columnNameRelationTable]] = $data['position'];
                        } else {
                            $resultIds[] = $data[$columnNameRelationTable];
                        }
                    }
                }
                if ($fieldName == 'note_ids') {
                    $item->setData($fieldName, array_keys($resultIds));
                    $item->setData('note_position', json_encode($resultIds));
                } else {
                    $item->setData($fieldName, $resultIds);
                }
            }
        }
    }

    /**
     * Join to linkage table if filter is applied
     *
     * @param string $tableName
     * @param string $columnName
     * @param string $linkageColumnName
     * @param string $columnFilter
     * @return void
     */
    protected function joinLinkageTable(
        $tableName,
        $columnName,
        $linkageColumnName,
        $columnFilter
    ) {
        if ($this->getFilter($columnFilter)) {
            $linkageTableName = $columnFilter . '_table';
            $select = $this->getSelect();
            $select->joinLeft(
                [$linkageTableName => $this->getTable($tableName)],
                'main_table.' . $columnName . ' = ' . $linkageTableName . '.' . $linkageColumnName,
                []
            )->group('main_table.' . $columnName);
            $this->addFilterToMap($columnFilter, $columnFilter . '_table.' . $columnFilter);
        }
    }
}
