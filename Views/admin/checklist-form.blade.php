<!------------------------------------------------------------------------------
| List of elements in checklist form
|------------------------------------------------------------------------------->

{!! Form::open(['route'=>['checklists.post', 'id' => @$item->id],  'files'=>true, 'method' => 'post'])  !!}

    <!--BUTTONS-->
    <div class='btn-form'>
        <!-- DELETE BUTTON -->
        @if($item)
            <a href="{!! URL::route('checklists.delete',['id' => @$item->id, '_token' => csrf_token()]) !!}"
            class="btn btn-danger pull-right margin-left-5 delete">
                {!! trans($plang_admin.'.buttons.delete') !!}
            </a>
        @endif
        <!-- DELETE BUTTON -->

        <!-- SAVE BUTTON -->
        {!! Form::submit(trans($plang_admin.'.buttons.save'), array("class"=>"btn btn-info pull-right ")) !!}
        <!-- /SAVE BUTTON -->
    </div>
    <!--/BUTTONS-->

    <!--TAB MENU-->
    <ul class="nav nav-tabs">
        <!--MENU 1-->
        <li class="active">
            <a data-toggle="tab" href="#menu_1">
                {!! trans($plang_admin.'.tabs.menu_1') !!}
            </a>
        </li>

        <!--MENU 2-->
        <li>
            <a data-toggle="tab" href="#menu_2">
                {!! trans($plang_admin.'.tabs.menu_2') !!}
            </a>
        </li>

        <!--MENU 3-->
        <li>
            <a data-toggle="tab" href="#menu_3">
                {!! trans($plang_admin.'.tabs.menu_3') !!}
            </a>
        </li>
    </ul>
    <!--/TAB MENU-->

    <!--TAB CONTENT-->
    <div class="tab-content">

        <!--MENU 1-->
        <div id="menu_1" class="tab-pane fade in active">

            <!--checklist NAME-->
            @include('package-category::admin.partials.input_text', [
                'name' => 'check_name',
                'label' => trans($plang_admin.'.labels.name'),
                'value' => @$item->check_name,
                'description' => trans($plang_admin.'.descriptions.name'),
                'errors' => $errors,
            ])
            <!--/checklist NAME-->

            <div class="row">

                <!-- LIST OF CATEGORIES -->
                <div class='col-md-6'>
                    @include('package-category::admin.partials.select_single', [
                        'name' => 'category_id',
                        'label' => trans($plang_admin.'.labels.category'),
                        'items' => $categories,
                        'value' => @$item->category_id,
                        'description' => trans($plang_admin.'.descriptions.category', [
                                            'href' => URL::route('categories.list', ['_key' => $context->context_key])
                                            ]),
                        'errors' => $errors,
                    ])
                </div>
                <!-- /LIST OF CATEGORIES -->

                <!--STATUS-->
                <div class='col-md-6'>

                    @include('package-category::admin.partials.radio', [
                        'name' => 'check_status',
                        'label' => trans($plang_admin.'.labels.checklist-status'),
                        'value' => @$item->check_status,
                        'description' => trans($plang_admin.'.descriptions.checklist-status'),
                        'items' => $statuses,
                    ])
                </div>
                <!--/STATUS-->

                <!--check_ID-->
                <div class='col-md-6'>
                    @include('package-category::admin.partials.input_text', [
                        'name' => 'redmine_id',
                        'label' => trans($plang_admin.'.labels.check_id'),
                        'value' => @$item->check_id,
                        'description' => trans($plang_admin.'.descriptions.check_id'),
                        'errors' => $errors,
                    ])
                </div>
                <!--/check_ID-->

                <!--check_URL-->
                <div class='col-md-6'>
                    @include('package-category::admin.partials.input_text', [
                        'name' => 'redmine_url',
                        'label' => trans($plang_admin.'.labels.check_url'),
                        'value' => @$item->redmine_url,
                        'description' => trans($plang_admin.'.descriptions.check_url'),
                        'errors' => $errors,
                    ])
                </div>
                <!--/check_URL-->

            </div>
             <!--checklist FILES-->
            @include('package-category::admin.partials.input_files', [
                'name' => 'files',
                'label' => trans($plang_admin.'.labels.files'),
                'value' => @$item->check_files,
                'description' => trans($plang_admin.'.descriptions.files'),
                'errors' => $errors,
            ])
            <!--/checklist FILES-->
        </div>

        <!--MENU 2-->
        <div id="menu_2" class="tab-pane fade">
            <div class="row">
            <!--checklist OVERVIEW-->
            @include('package-category::admin.partials.textarea', [
                'name' => 'check_overview',
                'label' => trans($plang_admin.'.labels.overview'),
                'value' => @$item->check_overview,
                'description' => trans($plang_admin.'.descriptions.overview'),
                'tinymce' => false,
                'errors' => $errors,
            ])
            <!--/checklist OVERVIEW-->

            <!--checklist DESCRIPTION-->
            @include('package-category::admin.partials.textarea', [
                'name' => 'check_description',
                'label' => trans($plang_admin.'.labels.description'),
                'value' => @$item->check_description,
                'description' => trans($plang_admin.'.descriptions.description'),
                'rows' => 50,
                'tinymce' => true,
                'errors' => $errors,
            ])
            <!--/checklist DESCRIPTION-->
            </div>
        </div>

        <!--MENU 3-->
        <div id="menu_3" class="tab-pane fade">
            <div class="row">
            <!--checklist IMAGE-->
            @include('package-category::admin.partials.input_image', [
                'name' => 'check_image',
                'label' => trans($plang_admin.'.labels.image'),
                'value' => @$item->check_image,
                'description' => trans($plang_admin.'.descriptions.image'),
                'errors' => $errors,
                'lfm_config' => false,
            ])
            <!--/checklist IMAGE-->
            </div>
        </div>

    </div>
    <!--/TAB CONTENT-->

    <!--HIDDEN FIELDS-->
    <div class='hidden-field'>
        {!! Form::hidden('id',@$item->id) !!}
        {!! Form::hidden('context',$request->get('context',null)) !!}
    </div>
    <!--/HIDDEN FIELDS-->

{!! Form::close() !!}
<!------------------------------------------------------------------------------
| End list of elements in checklist form
|------------------------------------------------------------------------------>