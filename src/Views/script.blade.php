<script>
    $(document).ready(function() {
        var dt = $('#{{ $id }}').DataTable({
            "ajax": {
                "url": "{{ $url }}",
                "method": "{{ $method }}",
                error: function (xhr) {
                    alert("Error");
                }
            },
            "filter": {{ $filter }},
            "ordering": {{ $ordering }},
            "columns": [
                @foreach($fields as $field)
                    {
                        "data": function(data) {
                            return ({{ $field }});
                        }
                    },
                @endforeach
            ],
            "oLanguage": {
                "sSearch": "Filtrar:",
                "sLoadingRecords": '<div><div class="row row-centered"><img width="30px" height="30px" src="../bootstrap/dist/images/loading_upload.gif" alt="cargando"></div></div>',
            }
        });
    });
    
</script>