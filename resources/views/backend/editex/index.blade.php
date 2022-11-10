@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.editex.management'))



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
                    <table id="pages-table" class="table" >
                        <thead>
                            <tr>
                                <th>{{ trans('labels.backend.access.editex.Process.step1') }}</th>
                                <th>{{ trans('labels.backend.access.editex.Process.step2') }}</th>
                                <th data-orderable="false">{{ trans('labels.backend.access.editex.Process.step3') }}</th>
                                <th>{{ trans('labels.backend.access.editex.Process.step4') }}</th>
                                <th>{{ trans('labels.backend.access.editex.Process.step5') }}</th>
                                <th>{{ trans('labels.backend.access.editex.Process.step6') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="mb-3">        
                                <input class="form-control" type="file" id="formFile" onchange="ExportToTable()">
                                </div></td>
                                <td><button type="button" class="btn btn-primary" id="noeces">NoeCEs</button></td>
                                <td><button type="button" class="btn btn-dark" id="galleys">Galleys</button></td>
                                <td><button type="button" class="btn btn-warning" id="typeset">TypeSet</button></td>
                                <td><button type="button" class="btn btn-secondary" id="pdf">PDF</button></td>
                                <td><button type="button" class="btn btn-success" id="download">Download</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--col-->
        </div>
        <!--row-->
        <div class="row" id="jobsheet" style="">
        <h3 > Job sheet info </h3>
        <table class="table table-bordered" id="xmltable">
        
  <tbody>
    <tr>
      <th scope="row" id="publisherid">Publisher ID</th>
      <td colspan="3">bjbms</td>
      
    </tr>
    <tr>
      <th scope="row" id="publishername">Publisher Name</th>
      <td colspan="3">Bosnian Journal of Basic Medical science</td>
      
    </tr>
    <tr>
      <th scope="row" id="artid">Artid</th>
      <td colspan="3">Bjms-2022-8034</td>
      
    </tr>
    <tr>
      <th scope="row">Stage</th>
      <td colspan="3">Auto_CE</td>
      
    </tr>
    <tr>
      <th scope="row">Start</th>
      <td colspan="3">09:50</td>
      
    </tr>
    <tr>
      <th scope="row">End</th>
      <td colspan="3">09:52</td>
      
    </tr>
  </tbody>
</table>
</div>

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
</script>
@endsection