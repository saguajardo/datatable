<script>
    var dt = null;
    $(document).ready(function() {
        dt = $('#{!! $id !!}').DataTable({
            "ajax": {
                "url": "{!! $url !!}",
                "method": "{!! $method !!}",
                error: function (xhr) {
                    alert("Error");
                }
            },
            "columns": [
                @foreach($fields as $field)
                    {
                        "data": function(data) {
                            return ({!! $field !!});
                        }
                    },
                @endforeach
            ],
            @foreach($functions as $key => $value)
                "{!! $key !!}": {!! $value !!}
            @endforeach
        });
    });
    
</script>
