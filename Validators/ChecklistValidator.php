<?php namespace Foostart\Checklist\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Checklist\Models\Task;

use Illuminate\Support\MessageBag as MessageBag;

class ChecklistValidator extends FooValidator
{

    protected $obj_checklist;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'task_name' => ["required"],
            'task_overview' => ["required"],
            'task_description' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_checklist = new Task();

        // language
        $this->lang_front = 'checklist-front';
        $this->lang_admin = 'checklist-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'task_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'task_overview.required'      => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.overview')]),
                'task_description.required'   => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.description')]),
            ];
        });


    }

    /**
     *
     * @param ARRAY $input is form data
     * @return type
     */
    public function validate($input) {

        $flag = parent::validate($input);
        $this->errors = $this->errors ? $this->errors : new MessageBag();

        //Check length
        $_ln = self::$configs['length'];

        $params = [
            'name' => [
                'key' => 'task_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['task_name']['min'],
                'max' => $_ln['task_name']['max'],
            ],
            'overview' => [
                'key' => 'task_overview',
                'label' => trans($this->lang_admin.'.fields.overview'),
                'min' => $_ln['task_overview']['min'],
                'max' => $_ln['task_overview']['max'],
            ],
            'description' => [
                'key' => 'task_description',
                'label' => trans($this->lang_admin.'.fields.description'),
                'min' => $_ln['task_description']['min'],
                'max' => $_ln['task_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['task_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['task_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['task_description'], $params['description']) ? $flag : FALSE;

        return $flag;
    }


    /**
     * Load configuration
     * @return ARRAY $configs list of configurations
     */
    public function loadConfigs(){

        $configs = config('package-checklist');
        return $configs;
    }

}