<html>
    <head>
        <title>Homework</title>
        <style>
            .thumbnail-container {
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
            }
            .thumbnail-container > div {
                width: 23.33%;
                border: 1px dotted black;
                padding: 3px;
                margin-bottom: 3px;
                word-break: break-word;

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
                    <p><strong>Title:</strong> {{ $doc->title }}</p>
                    <a href="{{ $doc->file_url }}">Download file</a>
                </div>
            @endforeach
        </div>


        <script>

        </script>
    </body>
</html>
