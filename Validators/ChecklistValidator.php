<?php namespace Foostart\Checklist\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Checklist\Models\Checklist;

use Illuminate\Support\MessageBag as MessageBag;

class ChecklistValidator extends FooValidator
{

    protected $obj_checklist;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'checklist_name' => ["required"],
            'checklist_overview' => ["required"],
            'checklist_description' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_checklist = new checklist();

        // language
        $this->lang_front = 'checklist-front';
        $this->lang_admin = 'checklist-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'checklist_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'checklist_overview.required'      => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.overview')]),
                'checklist_description.required'   => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.description')]),
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
                'key' => 'checklist_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['checklist_name']['min'],
                'max' => $_ln['checklist_name']['max'],
            ],
            'overview' => [
                'key' => 'checklist_overview',
                'label' => trans($this->lang_admin.'.fields.overview'),
                'min' => $_ln['checklist_overview']['min'],
                'max' => $_ln['checklist_overview']['max'],
            ],
            'description' => [
                'key' => 'checklist_description',
                'label' => trans($this->lang_admin.'.fields.description'),
                'min' => $_ln['checklist_description']['min'],
                'max' => $_ln['checklist_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['checklist_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['checklist_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['checklist_description'], $params['description']) ? $flag : FALSE;

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