
@extends('layouts.app')

@section('content')
<a href="{{$data}}" download="ss">aaa</a>
<a href="{{$data}}" download value="aa">
    <button href= "{{$data}}" id="save-btn">Save Text file</button>
@endsection

<script>

$("#save-btn").click(function() {
  var blob = new Blob(["test text"], {type: "text/plain;charset=utf-8"});
  saveAs(blob, "testfile1.txt");
});
</script>