@if(!empty($checked_rules))
<?php
$withs = [
    'order' => '10%',
    'rule_name'   => '40%',
    'updated_at' => '25%',
    'operations' => '20%',
];
$counter = 1;
?>
<caption>
    @if(count($checked_rules) == 1)
    {!! trans($plang_admin.'.descriptions.counter', ['number' => 1]) !!}
    @else
    {!! trans($plang_admin.'.descriptions.counters', ['number' => count($checked_rules)]) !!}
    @endif
</caption>

<table class="table table-hover">

    <thead>
        <tr style="height: 50px;">

            <!--ORDER-->
            <th style="width:{{ $withs['order'] }}">
                {{ trans($plang_admin.'.columns.order') }}
            </th>

            <!-- RULE NAME -->
            <th style="width:{{ $withs['rule_name'] }}">
                {{ trans($plang_admin.'.columns.rule_name') }}
            </th>

            <!--OPERATION-->
            <th style="width:{{ $withs['operations'] }}">
                {{ trans($plang_admin.'.columns.operations') }}
            </th>

            <!--UPDATED AT-->
            <th style="width:{{ $withs['updated_at'] }}">
                {{ trans($plang_admin.'.columns.updated_at') }}
            </th>

        </tr>

    </thead>

    <tbody>
        @foreach($checked_rules as $item)

        <tr>
            <!--ORDER-->
            <td> <?php echo $counter;
                    $counter++; ?> </td>

            <!--POST NAME-->
            <td>{!! $item->check_name !!}</td>

            <!--OPERATION-->
            <td>
                <!--view-->
                <a href="{!! Url::route('checkrule.view', [$item->check_slug, $item->check_id]) !!}" target="_blank">
                    <i class="fa fa-eye" aria-hidden="true"></i>
                </a>

                <!--delete-->
                <a href="{!! URL::route('checkrule.delete',[
                    'post_id' => $item->post_id,
                    'check_id' => $check->check_id,
                    'checked_rule_id' => $item->checked_rule_id,
                   '_token' => csrf_token(),
                   ])
                   !!}" class="margin-left-5 delete">
                    <i class="fa fa-trash-o f-tb-icon"></i>
                </a>
            </td>

            <!--UPDATED AT-->
            <td>
                {!! $item->updated_at !!}
            </td>

        </tr>
        @endforeach

    </tbody>

</table>
<div class="paginator">

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
{!! HTML::script('packages/foostart/js/form-table.js') !!}
@stop