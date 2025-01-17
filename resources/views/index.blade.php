@extends('main')
@section('title')
صفحة الوظائف
@endsection

@section('content')
@if(Session::has('success'))
<div class="alert alert-success" role="alert">
{{ Session::get('success') }}

</div>

@endif
@if(Session::has('error'))
<div class="alert alert-error" role="alert">
{{ Session::get('error') }}

</div>

@endif
 <p style="text-align: center;">
<a href="{{ route('languageConverter','ar') }}"> AR</a>
<a href="{{ route('languageConverter','en') }}"> EN</a>
<a  href="{{ route('languageConverter','fr') }}"> FR</a>


 </p>

<p>
<a href="{{ route('createjob') }}"  style="margin: 50px; color: white;" class="btn btn-sm btn-info">  {{ __('mycustom.addnew') }} </a>
</p>

<div class="col-md-4">

  <input type="text" id="searchbyjobname" class="form-control" placeholder="search by job name">
  <br>
</div>
<div id="ajax_search_result">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">name</th>
        <th scope="col">active</th>
        <th>photo</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>

     @if(!@empty($data))
     @php $i=1;    @endphp
    @foreach ($data as $info )
      <tr>
        <td> {{ $i }} </td>
        <td> {{ $info->name }} </td>
        <td> @if($info->active==1) مفعل @else معطل @endif </td>
        <td> 
 <a href="{{ route('editjob',$info->id) }}" style="color: white" class="btn btn-sm btn-primary">edit</a>
 <a href="{{ route('deletejob',$info->id) }}" style="color: white" class="btn btn-sm btn-danger">delete</a>

        </td>
        <td>
   @if(!@empty($info->files))
   @foreach ($info->files as $file )
   <img src="uploads/{{ $file->photo }}" style="width: 50px; heigh:50px; margin:5px;">

   @endforeach
   
   @endif

        </td>
    </tr>  
   @php  $i++; @endphp
    @endforeach

     @else   

     @endif
   
    </tbody>
  </table>
  
  <br>
  {{ $data->links() }}



</div>

@endsection

@section('script')
<script>
$(document).ready(function(){

$(document).on('input',"#searchbyjobname",function(){

var searchbyjobname=$(this).val(); 
jQuery.ajax({
  url:"{{ route('ajax_search_job') }}",
  type:'post',
  dataType:'html',
  cache:false,
  data:{searchbyjobname :searchbyjobname ,"_token":"{{ csrf_token() }}"},
  success:function(data){
 $("#ajax_search_result").html(data);
  },
  error:function(){

  }
});
$(document).on('click',"#ajax_search_pagination a",function(e){
  e.preventDefault();
  var searchbyjobname=$(this).val();
  jQuery.ajax({
  url:$(this).attr("href"),
  type:'post',
  dataType:'html',
  cache:false,
  data:{searchbyjobname :searchbyjobname ,"_token":"{{ csrf_token() }}"},
  success:function(data){
 $("#ajax_search_result").html(data);
  },
  error:function(){

  }
});


});



});


});



</script>


@endsection




