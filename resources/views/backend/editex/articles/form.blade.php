<div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{ __('labels.backend.access.editex.management') }}
                <small class="text-muted">{{ (isset($blog)) ? __('labels.backend.access.blogs.edit') : __('labels.backend.access.editex.create') }}</small>
            </h4>
        </div>
        <!--col-->
    </div>
    <!--row-->

    <hr>

    <div class="row mt-4 mb-4">
        <div class="col">
            <div class="form-group row">
                {{ Form::label('publisher_id', trans('validation.attributes.backend.access.article.publisher_id'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {{ Form::text('publisher_id', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.article.publisher_id'), 'required' => 'required']) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->
                      

            <div class="form-group row">
                {{ Form::label('publisher_name', trans('validation.attributes.backend.access.article.publisher_name'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {{ Form::text('publisher_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.article.publisher_name')]) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            
            <div class="form-group row">
                {{ Form::label('article_id', trans('validation.attributes.backend.access.article.article_id'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {{ Form::text('article_id', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.article.article_id')]) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                {{ Form::label('article_path', trans('validation.attributes.backend.access.article.article_path'), ['class' => 'col-md-2 from-control-label required']) }}

                <div class="col-md-10">
                    {{ Form::text('article_path', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.article.article_path')]) }}
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            
            <div class="form-group row">
                {{ Form::label('status', trans('validation.attributes.backend.access.article.status'), ['class' => 'col-md-2 from-control-label required']) }}
                
                <div class="col-md-10">
                    <div class="checkbox d-flex align-items-center">
                        <label class="switch switch-label switch-pill switch-primary mr-2" for="role-1"><input class="switch-input" type="checkbox" name="active" id="role-1" value="1" 
                        {{ (!isset($blogCategory->status) ||(isset($blogCategory->status) && $blogCategory->status === 1)) ? "checked" : "" }}><span class="switch-slider" data-checked="on" data-unchecked="off"></span></label>
                    </div>
                </div><!--col-->
            </div><!--form-group-->
            
        </div>
        <!--col-->
    </div>
    <!--row-->
</div>
<!--card-body-->

@section('pagescript')
<script type="text/javascript">
    FTX.Utils.documentReady(function() {
        FTX.Blogs.edit.init("{{ config('locale.languages.' . app()->getLocale())[1] }}");
    });
</script>
@stop