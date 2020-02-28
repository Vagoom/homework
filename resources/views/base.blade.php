<html>
    <head>
        <title>Homework</title>
        <style>
            .thumbnail-container {
                display: flex;
                flex-wrap: wrap;
            }
            .thumbnail-container > div {
                width: 22%;
                border: 1px dotted black;
                padding: 3px;
                margin-left: 2%;
                margin-bottom: 2%;
                word-break: break-word;

            }
            .pagination {
                display: flex;
                justify-content: center;
                list-style-type: none;
            }
        </style>
    </head>
    <body>
        <h1>Documents</h1>
        <form method="post" action="{{ url('/upload') }}" enctype="multipart/form-data">
            <input type="file" name="{{ \App\Models\Document::FILE_FORM_FIELD }}">
            <input type="submit" value="Add new document">
        </form>
        <div class="thumbnail-container">
            @foreach ($documents as $doc)
                <div data-id={{ $doc->id }}>
                    <h5>Title:</h5>
                    <p>{{ $doc->title }}</p>
                    <a href="{{ $doc->file_url }}" target="_blank">Download file</a>
                </div>
            @endforeach
        </div>
        {{ $documents->links() }}

        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>

            $("form").submit(function(event) {
                event.preventDefault();

                var form = $(this);
                $.ajax({
                    url         : form.attr( "action" ),
                    data        : new FormData(form[0]),
                    cache       : false,
                    contentType : false,
                    processData : false,
                    type        : 'POST',
                    success     : function(response) {
                        // console.log(response);

                        if (response.status === 'ok') {
                            var child = $(".thumbnail-container").children(":first").clone();
                            child.attr('data-id', response.docId);
                            child.find("p").text(response.docTitle);
                            child.find("a").attr('href', response.docUrl);
                            $(".thumbnail-container").append(child);
                            // clear file input
                            form.find('input[type="file"]').val(null);
                        }
                    }
                });
            });

        </script>
    </body>
</html>
