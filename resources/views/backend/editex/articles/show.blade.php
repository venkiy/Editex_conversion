@extends('backend.layouts.app')

@section('title', __('labels.backend.access.editex.management') . ' | ' . __('labels.backend.access.editex.show'))

@section('breadcrumb-links')
    @include('backend.editex.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    @lang('labels.backend.access.editex.management')
                    <small class="text-muted">@lang('labels.backend.access.editex.show')</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#noecsTab" role="tab" aria-controls="noecsTab" aria-expanded="true"><i class="fas fa-user"></i> @lang('labels.backend.access.editex.Process.step1')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $article->noecs!=1 ? 'disabled' : '' }}" data-toggle="tab" href="#galleypdfTab" role="tab" aria-controls="galleypdfTab" aria-expanded="false"><i class="fas fa-user"></i> @lang('labels.backend.access.editex.Process.step2')</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="noecsTab" role="tabpanel" aria-expanded="true">
                    <div class="col">
                    @include('backend.editex.articles.show.tabs.noecs')

                    </div><!--tab-->
                    <div class="tab-pane" id="galleypdfTab" role="tabpanel" aria-expanded="false">
                    <div class="col">
                    @include('backend.editex.articles.show.tabs.galleypdf')

                    </div><!--tab-->
                </div>
                <!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>@lang('labels.backend.access.users.tabs.content.overview.created_at'):</strong> 
                    <strong>@lang('labels.backend.access.users.tabs.content.overview.last_updated'):</strong> 
                    
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer-->
</div><!--card-->
@endsection
@section('pagescript')
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
<script>  
   
    $(document).ready(function(){
        
    $("button").click(function(){
        $("#"+this.id).hide();
        $("#btnSpinner").show();
        var fileSelected = $('#articlename').text().replace(/C:\\fakepath\\/i, '');
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
    $("#btnSpinner").hide();
    window.location.reload();
    //alert("Data: " + data + "\nStatus: " + status);
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