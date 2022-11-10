@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.editex.management'))

@section('breadcrumb-links')
@include('backend.editex.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    {{ __('labels.backend.access.editex.management') }} <small class="text-muted">{{ __('labels.backend.access.editex.active') }}</small>
                </h4>
            </div>
            <!--col-->
        </div>
        <!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table id="articles-table" class="table" data-ajax_url="{{ route("admin.editex.articles.get") }}">
                        <thead>
                            <tr>
                              <th>Publisher ID</th>
                              <th>Publisher Name</th>
                              <th>Article ID</th>
                              <th>{{ trans('labels.backend.access.editex.Process.step1') }}</th>
                              <th>{{ trans('labels.backend.access.editex.Process.step2') }}</th>
                              <th>{{ trans('labels.backend.access.editex.Process.step3') }}</th>
                              
                              <th>Status</th> 
                              <th>Action</th> 

                            </tr>
                        </thead>
                       
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
        

    </div>
    <!--card-body-->
</div>
<!--card-->
@endsection

@section('pagescript')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script>  
   
    $(document).ready(function(){
        
    $("button").click(function(){
        var fileSelected = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
        var processid = this.id;
        if (fileSelected == '') {
                       alert("Please choose File");
                   }else {
  $.post("editex/runbat",
  {
    filename: fileSelected,
    process: processid
  },
  function(data, status){
    alert("Data: " + data + "\nStatus: " + status);
  });
}
});
    
});
function ExportToTable() {  
  var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xml)$/;  
  //Checks whether the file is a valid xml file    
  if (regex.test($("#formFile").val().toLowerCase())) {  
   //Checks whether the browser supports HTML5    
   if (typeof(FileReader) != "undefined") {  
    var reader = new FileReader();  
    reader.onload = function(e) {  
     var xmlDoc = $.parseXML(e.target.result);  
     //Splitting of Rows in the xml file    
     var xmlrows = $(xmlDoc).find("body>p:first").text();  
     alert(xmlrows);
     
     $('#xmltable').show();  
    }  
    reader.readAsText($("#formFile")[0].files[0]);  
   } else {  
    alert("Sorry! Your browser does not support HTML5!");  
   }  
  } else {  
   alert("Please upload a valid XML file!");  
  }  
 }
 FTX.Utils.documentReady(function() {
        FTX.Articles.list.init('active');
    });
</script>
@endsection