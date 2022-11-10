<div class="table-responsive">
        <table class="table table-hover">
            
            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.publisher_id')</th>
                <td>{{ $article->publisher_id }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.publisher_name')</th>
                <td>{{ $article->publisher_name }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.article_id')</th>
                <td id="articlename">{{ $article->article_id }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.status')</th>
                <td>@include('backend.editex.articles.includes.status', ['article' => $article])</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.start')</th>
                <td id="noecs_starttime">{{ $article->galleypdf_start }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.end')</th>
                <td>{{ $article->galleypdf_end }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.stage_status')</th>
                <td>@include('backend.editex.articles.includes.completed', ['stageStatus' => $article->galleypdf])</td>
            </tr>

            
        </table>
        @if($article->galleypdf!=1)
        <button class="btn btn-primary" id="btngalleypdf">  Start </button>
        <button class="btn btn-primary" id="btnSpinner" style="display:none">
        <span class="spinner-border spinner-border-sm"></span>
        Running..
        </button>
        @endif
    </div>
</div><!--table-responsive-->