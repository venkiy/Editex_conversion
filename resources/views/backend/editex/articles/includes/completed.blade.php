@if ($stageStatus==1)    
        <span class="badge badge-success">@lang('labels.general.yes')</span>
   @else   
        <span class="badge badge-danger" style="cursor:pointer">@lang('labels.general.no')</span>
   
@endif
