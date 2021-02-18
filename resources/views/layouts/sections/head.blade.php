<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@guest @else {{ Auth::user()->person->getFullname()}} {{ __('-') }} @endguest {{ config('app.name', 'Laravel') }}</title>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '#mytextarea-post',
        branding: false,
        menubar: false,
        plugins: 'link image table',
        contextmenu: 'link image table',
        block_unsupported_drop: false,
    });
</script>

<script type="text/javascript">
    tinymce.init({
        selector: '#mytextarea-vacancy',
        branding: false,
        menubar: false,
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'formatselect | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
    });
</script>
<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>
    #container {
        width: 100%;
        height: 100%;
    }

    #container img {
        width: 100%;
    }
</style>
