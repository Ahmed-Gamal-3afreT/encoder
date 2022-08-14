<?php
$wall_paper = asset('/image/Softlock Logo 2020.png');
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/image/Softlock Logo 2020.png') }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
* {
  box-sizing: border-box;
}
 
body {
  font-family: 'Roboto Slab';
  font-size: 1.5rem;
  font-weight: 300;
}
 
div#contact_form {
  width: 800px;
  display: flex;
  align-items: stretch;
  justify-content: space-evenly;
  border: 2px solid black;
  padding: 10px;
}
 
div.input-box {
  display: flex;
  margin: 10px 0;
  flex-wrap: wrap;
}
 
div.input-box label {
  display: inline-block;
  margin: 10px 10px 10px 0;
  width: 20%;
}
 
div.input-box input {
  font-size: 1.5rem;
  border: 1px solid #ccc;
  padding: 4px 8px;
  flex: 1;
}
 
input.button {
  font-size: 1.5rem;
  background: black;
  color: white;
  border: 1px solid black;
  margin: 10px;
  padding: 4px 40px;
}
 
h1 {
  font-size: 5rem;
  text-transform: uppercase;
  font-family: 'Passion One';
  font-weight: 400;
  letter-spacing: 2px;
  line-height: 0.8;
  opacity: 0.0;
  color: rgba(red, green, blue, alpha)
}
 
div.greetings {
  text-align: center;
  font-size: 1.2rem;
  background-color: #d3d3d3;
  background-image: url('<?php echo $wall_paper;?>'); 
  /* background-image: linear-gradient(15deg, transparent 28%, rgba(255, 255, 255, 0.5) 28%); */
  background-size: 400px;
  background-repeat: no-repeat;

}
 
div.input-box input.error {
    border: 2px dashed red;
    background: #fee;
}
 
div.input-box label.error {
    color: red;
    font-size: 1rem;
    text-align: right;
    width: 100%;
    margin: 10px 0;
}

.styled-table {
    border-collapse: collapse;
    margin: 25px auto;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    
}

.td, th, tr{
    text-align: center;
}
    </style>
{{-- 
    <script>
         function saveStaticDataToFile() {
            var blob = new Blob(["Welcome to Websparrow.org."],
                { type: "text/plain;charset=utf-8" });
            saveAs(blob, "static.txt");
        }
    </script> --}}
</head>
<body>
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item">
                            <a class="nav-link" style="color:DodgerBlue; href="{{ route('login') }}"><b>Encrypt</b></a>
                        </li>
                        
                            <li class="nav-item">
                                <a class="nav-link" style="color:Tomato" href="{{ route('register') }}">Decrypt</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container" >

                  {{--   <a href="path/to/file.ext" download="ss.txt" rel="noopener noreferrer" target="_blank">
                        Download File
                     </a> --}}

                     <div>            
                        <select class="js-save-as css-select2-50">
                                         <option>

                                         </option>
                        </select>
                     </div>
            </div>
            
        </main>

        <a href="download" id="a">click here to download your file</a>
        <button onclick="download('{{$data}}', 'myfilename.txt', 'text/plain')">Create file</button>
                         
    </div>

    <a href="download" id="a">click here to download your file</a>
    <button onclick="download('{{$data}}', 'myfilename.json', 'text/json')">Create file</button>

    <button type="button" onclick="saveStaticDataToFile();"></button>
</body>
</html>

<script>
var file = new File(["Hello, world!"], "hello world.txt", {type: "text/plain;charset=utf-8"});
FileSaver.saveAs(file);

</script>