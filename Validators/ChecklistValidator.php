<?php namespace Foostart\Checklist\Validators;

use Foostart\Category\Library\Validators\FooValidator;
use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;
use Foostart\Checklist\Models\Check;

use Illuminate\Support\MessageBag as MessageBag;

class ChecklistValidator extends FooValidator
{

    protected $obj_checklist;

    public function __construct()
    {
        // add rules
        self::$rules = [
            'check_name' => ["required"],
            'check_overview' => ["required"],
            'check_description' => ["required"],
        ];

        // set configs
        self::$configs = $this->loadConfigs();

        // model
        $this->obj_checklist = new Check();

        // language
        $this->lang_front = 'checklist-front';
        $this->lang_admin = 'checklist-admin';

        // event listening
        Event::listen('validating', function($input)
        {
            self::$messages = [
                'check_name.required'          => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.name')]),
                'check_overview.required'      => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.overview')]),
                'check_description.required'   => trans($this->lang_admin.'.errors.required', ['attribute' => trans($this->lang_admin.'.fields.description')]),
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
                'key' => 'check_name',
                'label' => trans($this->lang_admin.'.fields.name'),
                'min' => $_ln['check_name']['min'],
                'max' => $_ln['check_name']['max'],
            ],
            'overview' => [
                'key' => 'check_overview',
                'label' => trans($this->lang_admin.'.fields.overview'),
                'min' => $_ln['check_overview']['min'],
                'max' => $_ln['check_overview']['max'],
            ],
            'description' => [
                'key' => 'check_description',
                'label' => trans($this->lang_admin.'.fields.description'),
                'min' => $_ln['check_description']['min'],
                'max' => $_ln['check_description']['max'],
            ],
        ];

        $flag = $this->isValidLength($input['check_name'], $params['name']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['check_overview'], $params['overview']) ? $flag : FALSE;
        $flag = $this->isValidLength($input['check_description'], $params['description']) ? $flag : FALSE;

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