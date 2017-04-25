<table id="{!! $id !!}" class="{!! $class !!}" {!! $options !!}>
    <thead>
        <tr>
            @foreach($fields as $field)
                <th>{!! $field !!}</th>
            @endforeach
        </tr>
    </thead>
</table>