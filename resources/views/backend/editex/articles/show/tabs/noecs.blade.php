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
                <td id="noecs_starttime">{{ $article->noecse_start }}</td>
            </tr>

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.end')</th>
                <td>{{ $article->noecse_end }}</td>
            </tr>
            
            @if($article->noecs==1)
            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.location')</th>
                <td>{{ $article->article_path }}\{{ $article->article_id }}-NoeCEs.docx</td>               
            </tr>
            @endif

            <tr>
                <th>@lang('labels.backend.access.editex.tabs.content.article.stage_status')</th>
                <td>@include('backend.editex.articles.includes.completed', ['stageStatus' => $article->noecs])</td>
            </tr>

            
        </table>
        @if($article->noecs!=1)
        <button class="btn btn-primary" id="btnnoecs">  Start </button>
        <button class="btn btn-primary" id="btnSpinner" style="display:none">
        <span class="spinner-border spinner-border-sm"></span>
        Running..
        </button>
        @endif
        @if($article->noecs==2) 
        <iframe src='https://docs.google.com/viewer?url=http://calibre-ebook.com/downloads/demos/demo.docx&embedded=true' frameborder='0'></iframe>
        @endif    
    </div>
</div><!--table-responsive-->