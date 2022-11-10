@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.frontend.contact.box_title'))

@section('content')
    <div class="row justify-content-center">
    <div class="split left">
  <div class="">
  <div id="editnav">
    <input type="file" id="openbtn" onchange="openCode(this.files)" value="Open">
   </div>
  <div id="editor"></div>

  </div>
</div>

<div class="split right">
  <div class="">
    <iframe src="https://www.w3docs.com/uploads/media/default/0001/01/540cb75550adf33f281f29132dddd14fded85bfc.pdf" width="100%" height="500px">
    </iframe>
  </div>
</div>
      
    </div><!--row-->
@endsection

@push('after-scripts')
    @if(config('access.captcha.contact'))
        @captchaScripts
    @endif
@endpush