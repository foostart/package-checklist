<?php

namespace Foostart\Checklist\Controllers\Admin;

use Illuminate\Http\Request;
use Foostart\Checklist\Controllers\Admin\ChecklistController;
use URL;
use Route,
    Redirect;
/**
 * Models
 */
use Foostart\Checklist\Models\Checklist;
use Foostart\Pnd\Models\Students;
use Foostart\Checklist\Models\ChecklistCategories;
use Foostart\Checklist\Helper\PexcelParse;
/**
 * Validators
 */
use Foostart\Checklist\Validators\ChecklistAdminValidator;

class ChecklistAdminController extends ChecklistController {

    private $obj_Checklist = NULL;
    private $obj_Checklist_categories = NULL;
    private $obj_validator = NULL;

    public function __construct() {

        $this->obj_Checklist = new Checklist();
        $this->obj_Checklist_categories = new ChecklistCategories();
    }

    /**
     *
     * @return type
     */
    public function index(Request $request) {

        $this->isAuthentication();

        $params = $request->all();


        $params['user_name'] = $this->current_user->user_name;
        $params['user_id'] = $this->current_user->id;

        /**
         * EXPORT
         */
        if (isset($params['export'])) {
            $checklists = $this->obj_checklist->get_checklists($params);
            $obj_parse = new Parse();
            $obj_parse->export_data($checklists, 'checklists');

            unset($params['export']);
        }
        ////////////////////////////////////////////////////////////////////////

        $checklists = $this->obj_checklist->get_checklists($params);

        $this->data = array_merge($this->data, array(
            'checklists' => $checklists,
            'request' => $request,
            'params' => $params
        ));
        return view('checklist::admin.checklist_list', $this->data);
    }

    /**
     *
     * @return type
     */
    public function edit(Request $request) {

        $this->isAuthentication();

        if ($this->current_user) {
            $checklist = NULL;
            $checklist_id = (int) $request->get('id');


            if (!empty($checklist_id) && (is_int($checklist_id))) {
                $checklist = $this->obj_checklist->find($checklist_id);
            }

            if ($this->is_admin || $this->is_all || $this->is_my || ($checklist->user_id == $this->current_user->id)) {
                $this->data = array_merge($this->data, array(
                    'checklist' => $checklist,
                    'request' => $request,
                    'categories' => $this->obj_checklist_categories->pluckSelect()->toArray(),
                ));
                return view('checklist::admin.checklist_edit', $this->data);
            }
        }
    }

    /**
     *
     * @param Request $request
     * @return type
     */
    public function post(Request $request) {

        $this->isAuthentication();

        $this->obj_validator = new checklistAdminValidator();

        $input = $request->all();

        $input['user_id'] = $this->current_user->id;

        $checklist_id = (int) $request->get('id');

        $checklist = NULL;

        $data = array();

        if (!$this->obj_validator->adminValidate($input)) {

            $data['errors'] = $this->obj_validator->getErrors();

            if (!empty($checklist_id) && is_int($checklist_id)) {
                $checklist = $this->obj_checklist->find($checklist_id);
            }
        } else {

            if (!empty($checklist_id) && is_int($checklist_id)) {

                $checklist = $this->obj_checklist->find($checklist_id);

                if (!empty($checklist)) {

                    $input['checklist_id'] = $checklist_id;
                    $checklist = $this->obj_checklist->update_checklist($input);

                    //Message
                    $this->addFlashMessage('message', trans('checklist::checklist.message_update_successfully'));

                    return Redirect::route("admin_checklist.parse", ["id" => $checklist->checklist_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('checklist::checklist.message_update_unsuccessfully'));
                }
            } else {

                $input = array_merge($input, array(
                ));

                $checklist = $this->obj_checklist->add_checklist($input);

                if (!empty($checklist)) {

                    //Message
                    $this->addFlashMessage('message', trans('checklist::checklist.message_add_successfully'));

                    return Redirect::route("admin_checklist.parse", ["id" => $checklist->checklist_id]);
                    //return Redirect::route("admin_checklist.edit", ["id" => $checklist->checklist_id]);
                } else {

                    //Message
                    $this->addFlashMessage('message', trans('checklist::checklist.message_add_unsuccessfully'));
                }
            }
        }

        $this->data = array_merge($this->data, array(
            'checklist' => $checklist,
            'request' => $request,
                ), $data);

        return view('checklist::admin.checklist_edit', $this->data);
    }

    /**
     *
     * @return type
     */
    public function delete(Request $request) {

        $this->isAuthentication();


        $checklist = NULL;
        $checklist_id = $request->get('id');


        if (!empty($checklist_id)) {

            $checklist = $this->obj_checklist->find($checklist_id);

            if (!empty($checklist)) {
                //Message
                $this->addFlashMessage('message', trans('checklist::checklist.message_delete_successfully'));

                if ($this->is_admin || $this->is_all || ($checklist->user_id == $this->current_user->id)) {

                    $obj_student = new Students();

                    $obj_student->deleteStudentsBychecklistId($checklist->checklist_id);

                    $checklist->delete();
                }
            }
        } else {

        }

        $this->data = array_merge($this->data, array(
            'checklist' => $checklist,
        ));

        return Redirect::route("admin_checklist");
    }

    public function parse(Request $request) {
        $obj_parse = new Parse();
        $obj_students = new Students();

        $input = $request->all();

        $checklist_id = $request->get('id');

        $checklist = $this->obj_checklist->find($checklist_id);

        $checklist_category = $this->obj_checklist_categories->find($checklist->checklist_category_id);

        $checklist->checklist_category_name = $checklist_category->checklist_category_name;

        $students = $obj_parse->read_data($checklist);

        $checklist->checklist_value = json_encode($students);
        unset($checklist->checklist_category_name);
        $checklist->save();

        $config = config('checklist.status_str');

        /**
         * Import data
         */
        $this->data = array_merge($this->data, array(
            'students' => $students,
            'request' => $request,
            'checklist' => $checklist,
            'config' => $config,
        ));

        return view('checklist::admin.checklist_parse', $this->data);
    }

}
