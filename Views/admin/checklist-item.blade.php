@if(!empty($items) && (!$items->isEmpty()) )
<?php
$withs = [
    'order' => '10%',
    'name' => '30%',
    'task_id' => '15%',
    'updated_at' => '25%',
    'operations' => '20%',
    'status' => '5%',
];

global $counter;
$nav = $items->toArray();
$counter = ($nav['current_page'] - 1) * $nav['per_page'] + 1;
?>
<caption>
    @if($nav['total'] == 1)
    {!! trans($plang_admin.'.descriptions.counter', ['number' => $nav['total']]) !!}
    @else
    {!! trans($plang_admin.'.descriptions.counters', ['number' => $nav['total']]) !!}
    @endif
</caption>
<div class="table-responsive" style="width: 950px">
<table class="table table-hover">

    <thead>
        <tr style="height: 50px;">

            <!--ORDER-->
            <th style='width:{{ $withs['order'] }}'>
                {{ trans($plang_admin.'.columns.order') }}
                <span class="del-checkbox pull-right">
                    <input type="checkbox" id="selecctall" />
                    <label for="del-checkbox"></label>
                </span>
            </th>

            <!-- NAME -->
            <?php $name = 'task_name' ?>
            <th class="hidden-xs" style='width:{{ $withs['name'] }}'>{!! trans($plang_admin.'.columns.name') !!}
                <a href='{!! $sorting["url"][$name] !!}' class='tb-id' data-order='asc'>
                    @if($sorting['items'][$name] == 'asc')
                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                    @elseif($sorting['items'][$name] == 'desc')
                    <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                    @else
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @endif
                </a>
            </th>

            <!-- TASK_ID -->
            <?php $name = 'task_id' ?>
            <th class="hidden-xs" style='width:{{ $withs['task_id'] }}'>{!! trans($plang_admin.'.columns.task_id') !!}
                <a href='{!! $sorting["url"][$name] !!}' class='tb-id' data-order='asc'>
                    @if($sorting['items'][$name] == 'asc')
                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                    @elseif($sorting['items'][$name] == 'desc')
                    <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                    @else
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @endif
                </a>
            </th>

            <!--STATUS-->
            <th style='width:{{ $withs['status'] }}'>
                {{ trans($plang_admin.'.columns.status') }}
            </th>

            <!--OPERATIONS-->
            <th style='width:{{ $withs['operations'] }}'>
                <span class='lb-delete-all'>
                    {{ trans($plang_admin.'.columns.operations') }}
                </span>

                {!! Form::submit(trans($plang_admin.'.buttons.delete-in-trash'), array(
                                                                            "class"=>"btn btn-danger pull-left delete btn-delete-all del-trash",
                                                                            "title"=> trans($plang_admin.'.hint.delete-in-trash'),
                                                                            'name'=>'del-trash'))
                !!}
                {!! Form::submit(trans($plang_admin.'.buttons.delete-forever'), array(
                                                                            "class"=>"btn btn-warning pull-left delete btn-delete-all del-forever",
                                                                            "title"=> trans($plang_admin.'.hint.delete-forever'),
                                                                            'name'=>'del-forever'))
                !!}
            </th>

            <!-- UPDATED AT -->
            <?php $name = 'updated_at' ?>
            <th class="hidden-xs" style='width:{{ $withs['updated_at'] }}'>{!! trans($plang_admin.'.columns.updated_at') !!}
                <a href='{!! $sorting["url"][$name] !!}' class='tb-id' data-order='asc'>
                    @if($sorting['items'][$name] == 'asc')
                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                    @elseif($sorting['items'][$name] == 'desc')
                    <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                    @else
                    <i class="fa fa-sort-desc" aria-hidden="true"></i>
                    @endif
                </a>
            </th>

        </tr>

    </thead>

    <tbody>
        @foreach($items as $item)
        <tr>
            <!--COUNTER-->
            <td>
                <?php echo $counter;  $counter++; ?>
                <span class='box-item pull-right'>
                   <input type="checkbox" id="<?php echo $item->id ?>" name="ids[]" value="{!! $item->id !!}">
                   <label for="box-item"></label>
                </span>
            </td>

            <!--NAME-->
            <td> {!! $item->task_name !!} </td>

            <!--TASK ID-->
            <td>
                <a href="{!! $item->task_url  !!}">
                    {!! $item->task_id !!}
                </a>
            </td>

            <!--STATUS-->
            <td style="text-align: center;">

                <?php $status = config('package-checklist.status'); ?>
                @if($item->task_status && (isset($status['list'][$item->task_status])))
                    <i class="fa fa-circle" style="color:{!! $status['color'][$item->task_status] !!}" title='{!! $status["list"][$item->task_status] !!}'></i>
               @else
                <i class="fa fa-circle-o red" title='{!! trans($plang_admin.".labels.unknown") !!}'></i>
                @endif
            </td>


            <!--OPERATOR-->
            <td>
                 <!--view-->
                <a href="{!! URL::route('checklists.view', [   'id' => $item->id,
                   '_token' => csrf_token()
                   ])
                   !!}">
                   <i class="fa fa-eye" aria-hidden="true"></i>
                </a>

                <!--edit-->
                <a href="{!! URL::route('checklists.edit', [   'id' => $item->id,
                   '_token' => csrf_token()
                   ])
                   !!}">
                    <i class="fa fa-edit f-tb-icon"></i>
                </a>

                <!--copy-->
                <a href="{!! URL::route('checklists.copy',[    'cid' => $item->id,
                   '_token' => csrf_token(),
                   ])
                   !!}"
                   class="margin-left-5">
                    <i class="fa fa-files-o f-tb-icon" aria-hidden="true"></i>
                </a>


                <!--download-->
                <a href="{!! URL::route('checklists.download', [   'id' => $item->id,
                   '_token' => csrf_token()
                   ])
                   !!}">
                    <i class="fa fa-download" aria-hidden="true"></i>
                </a>


                <!--delete-->
                <a href="{!! URL::route('checklists.delete',[  'id' => $item->id,
                   '_token' => csrf_token(),
                   ])
                   !!}"
                   class="margin-left-5 delete">
                    <i class="fa fa-trash-o f-tb-icon"></i>
                </a>

            </td>
            <!--UPDATED AT-->
            <td> {!! $item->updated_at !!} </td>

        </tr>
        @endforeach

    </tbody>

</table>
<div class="paginator">
    {!! $items->appends($request->except(['page']) )->render() !!}
</div>
</div>
@else
<!--SEARCH RESULT MESSAGE-->
<span class="text-warning">
    <h5>
        {{ trans($plang_admin.'.descriptions.not-found') }}
    </h5>
</span>
<!--/SEARCH RESULT MESSAGE-->
@endif

@section('footer_scripts')
@parent
{!! HTML::script('packages/foostart/js/form-table.js')  !!}
@stop