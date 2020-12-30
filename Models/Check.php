<?php

namespace Foostart\Checklist\Models;

use Foostart\Category\Library\Models\FooModel;
use Illuminate\Database\Eloquent\Model;

class Check extends FooModel {

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
        $this->table = 'checks';

        //list of field in table
        $this->fillable = [
            'check_name',
            'category_id',
            'user_id',
            'redmine_id',
            'redmine_url',
            'check_overview',
            'check_description',
            'check_image',
            'check_files',
            'check_status',
        ];

        //list of fields for inserting
        $this->fields = [
            'check_name' => [
                'name' => 'check_name',
                'type' => 'Text',
            ],
            'category_id' => [
                'name' => 'category_id',
                'type' => 'Int',
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => 'Int',
            ],
            'redmine_id' => [
                'name' => 'redmine_id',
                'type' => 'Text',
            ],
            'redmine_url' => [
                'name' => 'redmine_url',
                'type' => 'Text',
            ],
            'check_overview' => [
                'name' => 'check_overview',
                'type' => 'Text',
            ],
            'check_description' => [
                'name' => 'check_description',
                'type' => 'Text',
            ],
            'check_image' => [
                'name' => 'check_image',
                'type' => 'Text',
            ],
            'check_files' => [
                'name' => 'files',
                'type' => 'Json',
            ],

            'check_status' => [
                 'name' => 'check_status',
                 'type' => 'Int',
            ],

        ];

        //check valid fields for inserting
        $this->valid_insert_fields = [
            'check_name',
            'user_id',
            'category_id',
            'redmine_id',
            'redmine_url',
            'updated_at',
            'check_overview',
            'check_description',
            'check_image',
            'check_files',
            'check_status',
        ];

        //check valid fields for ordering
        $this->valid_ordering_fields = [
            'redmine_id',
            'redmine_url',
            'check_name',
            'updated_at',
            $this->field_status,
        ];
        //check valid fields for filter
        $this->valid_filter_fields = [
            'keyword',
            'status',
            'user_id',
            'check_status',
        ];

        //primary key
        $this->primaryKey = 'check_id';

        //the number of items on page
        $this->perPage = 10;

        //item status
        $this->field_status = 'check_status';
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
     * Get a task by {id}
     * @param ARRAY $params list of parameters
     * @return OBJECT task
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
                        case 'check_name':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.check_name', '=', $value);
                            }
                            break;
                        case 'status':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.' . $this->field_status, '=', $value);
                            }
                            break;
                        case 'user_id':
                            if (!empty($value)) {
                                $elo = $elo->where($this->table . '.user_id', '=', $value);
                            }
                            break;
                        case 'keyword':
                            if (!empty($value)) {
                                $elo = $elo->where(function($elo) use ($value) {
                                    $elo->where($this->table . '.check_name', 'LIKE', "%{$value}%")
                                            ->orWhere($this->table . '.check_description', 'LIKE', "%{$value}%")
                                            ->orWhere($this->table . '.check_overview', 'LIKE', "%{$value}%");
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

        $elo = $elo->select($this->table . '.*', $this->table . '.check_id as id'
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

        $task = $this->selectItem($params);

        if (!empty($task)) {
            $dataFields = $this->getDataFields($params, $this->fields);

            foreach ($dataFields as $key => $value) {
                $task->$key = $value;
            }

            //$task->$field_status = $this->status['publish'];

            $task->save();

            return $task;
        } else {
            return NULL;
        }
    }

    /**
     *
     * @param ARRAY $params list of parameters
     * @return OBJECT task
     */
    public function insertItem($params = []) {

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

        $item = $this->find($input['id']);

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


     public function getChecklists($check_id) {
         $checked_rules = NULL;

         $checked_rules = self::from('checked_rules')
                                ->select('posts.*')
                                ->join('posts','posts.post_id', '=', 'checked_rules.post_id')
                                ->where('check_id','=', $check_id)
                                ->get();
         return $checked_rules;
     }
}
