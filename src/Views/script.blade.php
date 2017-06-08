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
	                @if(is_array($field))
	                    "data": function(data) {
	                    	return ({!! $field['value'] !!});
	                	},
	                	"visible": {!! $field['visible'] !!}
	                @else
	                	"data": function(data) {
	                    	return ({!! $field !!});
	                    }
	                @endif
	                },
	            @endforeach
            ],
            @foreach($functions as $key => $value)
                "{!! $key !!}": {!! $value !!}
            @endforeach
        });
    });
    
</script>
