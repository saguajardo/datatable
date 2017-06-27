<script>
    var dt = null;
    $(document).ready(function() {
        var dom = '<"row"<"col-sm-6"l';
        @if($enableColVis)
			dom = dom + '<"pull-left"C>';
        @endif
        dom = dom + '><"col-sm-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-5"i><"col-sm-7"p>>';
        dt = $('#{!! $id !!}').DataTable({
        	"dom": dom,
			@if($enableColVis)
			colVis: {
				buttonText: "{!! __('labels.show_hide_columns') !!}",
				@if(is_array($colVis) && array_key_exists('exclude', $colVis))
					exclude: [ {!! $colVis['exclude'] !!} ],
				@endif
			},
			@endif
            colReorder: {
                realtime: false
            },
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
	                	@if(array_key_exists('visible', $field))
	                	"visible": {!! $field['visible'] !!},
	                	@endif
						@if(array_key_exists('name', $field))
	                		"name": "{!! $field['name'] !!}",
	                	@endif
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
