<script>
    $.extend($.fn.dataTable.defaults, {
        @foreach($defaults as $key => $value)
            "{!! $key !!}": {!! $value !!},
        @endforeach
    });
</script>