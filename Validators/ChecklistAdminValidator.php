<?php namespace Foostart\Checklist\Validators;

use Event;
use \LaravelAcl\Library\Validators\AbstractValidator;

use Illuminate\Support\MessageBag as MessageBag;

class ChecklistAdminValidator extends AbstractValidator
{
    protected static $rules = array(
        'checklist_name' => 'required',
        'checklist_description' => 'required',
        'checklist_file_path' => 'required',
    );

    protected static $messages = [];


    public function __construct()
    {
        Event::listen('validating', function($input)
        {
        });
        $this->messages();
    }

    public function adminValidate($input) {

        $flag = parent::validate($input);

        $this->errors = $this->errors?$this->errors:new MessageBag();

//        $flag = $this->isValidTitle($input)?$flag:FALSE;
//        $flag = $this->isValidDescription($input)?$flag:FALSE;

        return $flag;
    }

    public function userValidate($input) {

        $flag = parent::validate($input);

        $this->errors = $this->errors?$this->errors:new MessageBag();

        $flag = $this->isValidTitle($input)?$flag:FALSE;
        $flag = $this->isValidDescription($input)?$flag:FALSE;

        return $flag;
    }

    public function apiUserValidate($input) {

        $flag = $this->userValidate($input);

        $this->errors = $this->errors?$this->errors:new MessageBag();

        if (empty($input['user_id'])) {
            $this->errors->add('user_id', 'Yêu cầu nhập mã thành viên');
            $flag = FALSE;
        }

        return $flag;
    }

    public function messages() {
        self::$messages = [
            'checklist_name.required' => 'Yêu cầu nhập tiêu đề.',
            'checklist_description.required' => 'Yêu cầu nhập nội dung bài viết.',
            'checklist_file_path.required' => 'Yêu cầu gửi file đính kèm.',
        ];
    }

    public function isValidTitle($input) {

        $flag = TRUE;

        $min_lenght = config('buoumau.length_name_min');
        $max_lenght = config('buoumau.length_name_max');

        $checklist_name = @$input['checklist_name'];

        if ((strlen($checklist_name) < $min_lenght)  || ((strlen($checklist_name) > $max_lenght))) {
            $this->errors->add('length_name', trans('checklist::checklist.length_name', ['LENGTH_NAME_MIN' => $min_lenght, 'LENGTH_NAME_MAX' => $max_lenght]));
            $flag = FALSE;
        }

        return $flag;
    }

    public function isValidOverview($input) {

        $flag = TRUE;

        $min_lenght = config('buoumau.length_overview_min') + 7;
        $max_lenght = config('buoumau.length_overview_max');

        $checklist_overiew = @$input['checklist_overview'];

        if ((strlen($checklist_overiew) < $min_lenght)  || ((strlen($checklist_overiew) > $max_lenght))) {
            $this->errors->add('length_overview', trans('checklist::checklist.length_overview', ['LENGTH_OVERVIEW_MIN' => 10, 'LENGTH_OVERVIEW_MAX' => $max_lenght]));
            $flag = FALSE;
        }

        return $flag;
    }

     public function isValidDescription($input) {

        $flag = TRUE;

        $min_lenght = config('buoumau.length_description_min');

        $checklist_overiew = @$input['checklist_description'];

        if (strlen($checklist_overiew) < $min_lenght) {
            $this->errors->add('length_description', trans('checklist::checklist.length_description', ['LENGTH_DESCRIPTION_MIN' => $min_lenght]));
            $flag = FALSE;
        }

        return $flag;
    }
}