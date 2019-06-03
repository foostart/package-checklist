<?php

use LaravelAcl\Authentication\Classes\Menu\SentryMenuFactory;
use Foostart\Category\Helpers\FooCategory;
use Foostart\Category\Helpers\SortTable;

/*
  |-----------------------------------------------------------------------
  | GLOBAL VARIABLES
  |-----------------------------------------------------------------------
  |   $sidebar_items
  |   $sorting
  |   $order_by
  |   $plang_admin = 'checklist-admin'
  |   $plang_front = 'checklist-front'
 */
View::composer([
    'package-checklist::admin.checklist-edit',
    'package-checklist::admin.checklist-form',
    'package-checklist::admin.checklist-items',
    'package-checklist::admin.checklist-item',
    'package-checklist::admin.checklist-search',
    'package-checklist::admin.checklist-config',
    'package-checklist::admin.checklist-lang',
    'package-checklist::admin.checklist-view',
    'package-checklist::admin.checklist-view-item',
        ], function ($view) {

    /**
     * $plang-admin
     * $plang-front
     */
    $plang_admin = 'checklist-admin';
    $plang_front = 'checklist-front';

    $view->with('plang_admin', $plang_admin);
    $view->with('plang_front', $plang_front);

    $fooCategory = new FooCategory();
    $key = $fooCategory->getContextKeyByRef('admin/checklists');
    /**
     * $sidebar_items
     */
    $sidebar_items = [
        trans('checklist-admin.sidebar.add') => [
            'url' => URL::route('checklists.edit', []),
            'icon' => '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>'
        ],
        trans('checklist-admin.sidebar.list') => [
            "url" => URL::route('checklists.list', []),
            'icon' => '<i class="fa fa-list-ul" aria-hidden="true"></i>'
        ],
        trans('checklist-admin.sidebar.category') => [
            'url' => URL::route('categories.list', ['_key=' . $key]),
            'icon' => '<i class="fa fa-sitemap" aria-hidden="true"></i>'
        ],
        trans('checklist-admin.sidebar.config') => [
            "url" => URL::route('checklists.config', []),
            'icon' => '<i class="fa fa-braille" aria-hidden="true"></i>'
        ],
        trans('checklist-admin.sidebar.lang') => [
            "url" => URL::route('checklists.lang', []),
            'icon' => '<i class="fa fa-language" aria-hidden="true"></i>'
        ],
    ];

    /**
     * $sorting
     * $order_by
     */
    $orders = [
        '' => trans($plang_admin . '.form.no-selected'),
        'id' => trans($plang_admin . '.fields.id'),
        'task_id' => trans($plang_admin . '.fields.task_id'),
        'task_url' => trans($plang_admin . '.fields.task_url'),
        'task_name' => trans($plang_admin . '.fields.name'),
        'task_status' => trans($plang_admin . '.fields.checklist-status'),
        'updated_at' => trans($plang_admin . '.fields.updated_at'),
    ];

    $sortTable = new SortTable();
    $sortTable->setOrders($orders);
    $sorting = $sortTable->linkOrders();

    /**
     * $order_by
     */
    $order_by = [
        'asc' => trans('category-admin.order.by-asc'),
        'desc' => trans('category-admin.order.by-des'),
    ];

    /**
     * Send to view
     */
    $view->with('sidebar_items', $sidebar_items );
    $view->with('plang_admin', $plang_admin);
    $view->with('plang_front', $plang_front);
    $view->with('sorting', $sorting);
    $view->with('order_by', $order_by);
});
