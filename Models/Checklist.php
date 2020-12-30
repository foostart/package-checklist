<?php

namespace Foostart\Checklist\Models;

use Foostart\Category\Library\Models\FooModel;
use Illuminate\Database\Eloquent\Model;

class Checklist extends FooModel {

    /**
     * @table categories
     * @param array $attributes
     */
    public function __construct(array $attributes = array()) {
        //set configurations
        $this->setConfigs();

        parent::__construct($attributes);
    }

    public function setConfigs() {

        //table name
        $this->table = 'checked_rules';

        //list of field in table
        $this->fillable = [
            'checklist_id',
            'check_id',
            'context_id',
            'context_task'
        ];

        //list of fields for inserting
        $this->fields = [
            'checklist_status' => [
                'name' => 'checked_rule_status',
                'type' => 'Int',
            ],
            'check_id' => [
                'name' => 'check_id',
                'type' => 'Int',
            ],
             'context_id' => [
                'name' => 'context_id',
                'type' => 'Int',
            ],

        ];

        //check valid fields for inserting
        $this->valid_insert_fields = [
            'checklist_status',
            'check_id',
            'user_id',
            'context_id',
            'context_type'
        ];

        //check valid fields for ordering
        $this->valid_ordering_fields = [
            'check_id',
            'updated_at',
            $this->field_status,
        ];
        //check valid fields for filter
        $this->valid_filter_fields = [
            'keyword',
            'status',
            'check_id',
            'context_id',
        ];

        //primary key
        $this->primaryKey = 'checklist_id';

        //the number of items on page
        $this->perPage = 10;

        //item status
        $this->field_status = 'checklist_status';
    }

    /**
     * Gest list of items
     * @param type $params
     * @return object list of categories
     */
    public function selectItems($params = array()) {

        //join to another tables
        $elo = $this->joinTable();

        //search filters
        $elo = $this->searchFilters($params, $elo);

        //select fields
        $elo = $this->createSelect($elo);

        //order filters
        $elo = $this->orderingFilters($params, $elo);

        //paginate items
        $items = $this->paginateItems($params, $elo);

        return $items;
    }

    /**
     * Get a checklist by {id}
     * @param ARRAY $params list of parameters
     * @return OBJECT checklist
     */
    public function selectItem($params = array(), $key = NULL) {


        if (empty($key)) {
            $key = $this->primaryKey;
        }
        //join to another tables
        $elo = $this->joinTable();

        //search filters
        $elo = $this->searchFilters($params, $elo, FALSE);

        //select fields
        $elo = $this->createSelect($elo);

        //id
        if (!empty($params['id'])) {
            $elo = $elo->where($this->primaryKey, $params['id']);
        }

        //first item
        $item = $elo->first();

        return $item;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function joinTable(array $params = []) {
        return $this;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    protected function searchFilters(array $params = [], $elo, $by_status = TRUE) {

        //filter
        if ($this->isValidFilters($params) && (!empty($params))) {
            foreach ($params as $column => $value) {
                if ($this->isValidValue($value)) {
                    switch ($column) {
                        case 'checklist_name':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.checklist_name', '=', $value);
                            }
                            break;
                        case 'check_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.check_id', '=', $value);
                            }
                            break;
                        case 'context_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.context_id', '=', $value);
                            }
                            break;
                        case 'context_type':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.context_type', '=', $value);
                            }
                            break;
                        case 'status':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.' . $this->field_status, '=', $value);
                            }
                            break;
                        case 'keyword':
                            if (!empty($value)) {
                                $elo = $elo->where(function($elo) use ($value) {
                                    $elo->where($this->table . '.checklist_name', 'LIKE', "%{$value}%")
                                            ->orWhere($this->table . '.checklist_description', 'LIKE', "%{$value}%")
                                            ->orWhere($this->table . '.checklist_overview', 'LIKE', "%{$value}%");
                                });
                            }
                            break;
                        default:
                            break;
                    }
                }
            }
        }

        return $elo;
    }

    /**
     * Select list of columns in table
     * @param ELOQUENT OBJECT
     * @return ELOQUENT OBJECT
     */
    public function createSelect($elo) {

        $elo = $elo->select($this->table . '.*', $this->table . '.checklist_id as id'
        );

        return $elo;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return ELOQUENT OBJECT
     */
    public function paginateItems(array $params = [], $elo) {
        $items = $elo->paginate($this->perPage);

        return $items;
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @param INT $id is primary key
     * @return type
     */
    public function updateItem($params = [], $id = NULL) {

        if (empty($id)) {
            $id = $params['id'];
        }
        $field_status = $this->field_status;

        $checklist = $this->selectItem($params);

        if (!empty($checklist)) {
            $dataFields = $this->getDataFields($params, $this->fields);

            foreach ($dataFields as $key => $value) {
                $checklist->$key = $value;
            }

            //$checklist->$field_status = $this->status['publish'];

            $checklist->save();

            return $checklist;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return OBJECT checklist
     */
    public function insertItem($params = []) {


        $_params = [
            'check_id' => $params['check_id'],
            'context_id' => $params['context_id'],
            'context_type' => $params['context_type'],
        ];

        $item = $this->selectItem($_params);

        if ($item) {
            return 0;
        }

        $dataFields = $this->getDataFields($params, $this->fields);

        //$dataFields[$this->field_status] = $this->status['publish'];


        $item = self::create($dataFields);

        $key = $this->primaryKey;
        $item->id = $item->$key;

        return $item;
    }

    /**
     *
     * @param ARRAY $input list of parameters
     * @return boolean TRUE incase delete successfully otherwise return FALSE
     */
    public function deleteItem($input = [], $delete_type) {

        /**
         * $_params
         */
        $_params = [
            'check_id' => $params['check_id'],
            'context_id' => $params['context_id'],
            'context_type' => $params['context_type'],
        ];

        $item = $this->selectItem($_params);

        if ($item) {
            switch ($delete_type) {
                case 'delete-trash':
                    return $item->fdelete($item);
                    break;
                case 'delete-forever':
                    return $item->delete();
                    break;
            }
        }

        return FALSE;
    }

    /**
     *
     * Get list of statuses to push to select
     * @return ARRAY list of statuses
     */

     public function getPluckStatus() {
            $pluck_status = config('package-checklist.status.list');
            return $pluck_status;
     }


     public function getChecklists($task_id) {
         $checked_rules = NULL;

         $checked_rules = self::from('checklist')
                                ->select('posts.*')
                                ->join('posts','posts.post_id', '=', 'checked_rules.post_id')
                                ->where('check_id','=', $task_id)
                                ->get();
         return $checked_rules;
     }
}
