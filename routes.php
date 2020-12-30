<?php

use Illuminate\Session\TokenMismatchException;

/**
 * FRONT
 */
Route::get('checklist', [
    'as' => 'checklist',
    'uses' => 'Foostart\Checklist\Controllers\Front\ChecklistFrontController@index'
]);


/**
 * ADMINISTRATOR
 */
Route::group(['middleware' => ['web']], function () {

    Route::group(['middleware' => ['admin_logged', 'can_see', 'in_context'],
                  'namespace' => 'Foostart\Checklist\Controllers\Admin',
        ], function () {

        /*
          |-----------------------------------------------------------------------
          | Manage checklist
          |-----------------------------------------------------------------------
          | 1. List of checklists
          | 2. Edit checklist
          | 3. Delete checklist
          | 4. Add new checklist
          | 5. Manage configurations
          | 6. Manage languages
          |
        */

        /**
         * list
         */
        Route::get('admin/checklists', [
            'as' => 'checklists.list',
            'uses' => 'ChecklistAdminController@index'
        ]);
        Route::get('admin/checklists/list', [
            'as' => 'checklists.list',
            'uses' => 'ChecklistAdminController@index'
        ]);

        /**
         * view
         */
        Route::get('admin/checklists/view', [
            'as' => 'checklists.view',
            'uses' => 'ChecklistAdminController@view'
        ]);

        /**
         * view
         */
        Route::get('admin/checklists/download', [
            'as' => 'checklists.download',
            'uses' => 'ChecklistAdminController@download'
        ]);

        /**
         * edit-add
         */
        Route::get('admin/checklists/edit', [
            'as' => 'checklists.edit',
            'uses' => 'ChecklistAdminController@edit'
        ]);

        /**
         * copy
         */
        Route::get('admin/checklists/copy', [
            'as' => 'checklists.copy',
            'uses' => 'ChecklistAdminController@copy'
        ]);

        /**
         * post
         */
        Route::post('admin/checklists/edit', [
            'as' => 'checklists.post',
            'uses' => 'ChecklistAdminController@post'
        ]);

        /**
         * delete
         */
        Route::get('admin/checklists/delete', [
            'as' => 'checklists.delete',
            'uses' => 'ChecklistAdminController@delete'
        ]);

        Route::get('admin/taskrule/delete', [
            'as' => 'taskrule.delete',
            'uses' => 'ChecklistAdminController@deleteCheckRule'
        ]);

        /**
         * Checked
         */
        Route::get('admin/taskrule/checked', [
            'as' => 'taskrule.checked',
            'uses' => 'ChecklistAdminController@checked'
        ]);
        /**
         * trash
         */
         Route::get('admin/checklists/trash', [
            'as' => 'checklists.trash',
            'uses' => 'ChecklistAdminController@trash'
        ]);

        /**
         * configs
        */
        Route::get('admin/checklists/config', [
            'as' => 'checklists.config',
            'uses' => 'ChecklistAdminController@config'
        ]);

        Route::post('admin/checklists/config', [
            'as' => 'checklists.config',
            'uses' => 'ChecklistAdminController@config'
        ]);

        /**
         * language
        */
        Route::get('admin/checklists/lang', [
            'as' => 'checklists.lang',
            'uses' => 'ChecklistAdminController@lang'
        ]);

        Route::post('admin/checklists/lang', [
            'as' => 'checklists.lang',
            'uses' => 'ChecklistAdminController@lang'
        ]);

    });
});
