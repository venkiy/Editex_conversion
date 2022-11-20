<?php

namespace App\Http\Controllers\Backend\Editex;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Editex\ManageArticleRequest;
use App\Http\Requests\Backend\Editex\StoreArticleRequest;
use App\Http\Requests\Backend\Editex\ProcessArticleRequest;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Editex\Article;
use App\Repositories\Backend\Editex\ArticleRepository;
use Illuminate\Support\Facades\View;


class EditexProcessController extends Controller
{   
  /**
     * @var \App\Repositories\Backend\Editex\ArticleRepository
     */
    protected $repository;

    /**
     * @param \App\Repositories\Backend\Editex\ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository)
    {       
      $this->repository = $repository;  
      View::share('js', ['articles']);
    }

  /**
     * @param \App\Http\Requests\Backend\Editex\ManageArticleRequest $request
     *
     * @return \App\Http\Responses\ViewResponse
     */
    public function index(ManageArticleRequest $request)
    {
        return new ViewResponse('backend.editex.articles.index');
    }  

    /**
     * @param \App\Http\Requests\Backend\Editex\ManageArticleRequest $request
     *
     * @return ViewResponse
     */
    public function create(ManageArticleRequest $request, Article $article)
    {      

      return new ViewResponse('backend.editex.articles.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Editex\StoreArticleRequest $request
     *
     * @return \App\Http\Responses\RedirectResponse
     */
    public function store(StoreArticleRequest $request)
    {
        $this->repository->create($request->except(['_token', '_method']));

        return new RedirectResponse(route('admin.editex.articles.index'), ['flash_success' => __('alerts.backend.articles.created')]);
    }
  
    /**     
     * @param \App\Models\Backend\Article $article
     *
     * @return mixed
     */
    public function show(Article $article)
    {
        return view('backend.editex.articles.show')
            ->withArticle($article);
    }

    public function runBatchfile(ProcessArticleRequest $request)
    {
      $processStartTime = date('Y-m-d H:i:s');
      $articleName = $request->filename;
      //print_r($articleName);exit;
      $process = $request->process;
      if($process=="btnnoecs"){
        $executablePath = 'D:\Noesis-WF\Tools\BJBMS\DOC-CLEAN.BAT';
      }else if ($process == "btngalleypdf"){
        $executablePath = 'D:\Noesis-WF\Tools\BJBMS\AUTOTEX.BAT';
      }else {
        $executablePath = 'S:\Softwares\AppData\NPS-TeX4ht.bat';
      }
      $article  = Article::where('article_id', $articleName)->first();
      $aticlePath = $article->article_path;
      //print_r($article->article_path);exit;
      $filePath = $aticlePath."\\".$articleName;
      //exec('C:\wamp64\www\laravel_editexProcess\storage\app\articles\test.bat', $output);
      exec($executablePath." ".$filePath, $output);
      //exec('Y:\04_temp\Tool\27-BJBMS\TOOL\DOC-CLEAN.BAT D:\Noesis\BJMS\bjbms-2022-8034\bjbms-2022-8034', $output);
      $filename = 'C:\wamp64\www\laravel_editexProcess\storage\app\articles\testlog.txt';
      $fp = fopen($filename, "r");

      $content = fread($fp, filesize($filename));
      $lines = ($content);
      fclose($fp);
      if(trim($lines)=="Success "){
        print_r($lines);
      }
      $processEndTime = date('Y-m-d H:i:s');
      if($process=="btnnoecs"){
      $request->merge(["noecs_start"=>$processStartTime, "noecs_end"=>$processEndTime, "noecs"=> 1, "article_id"=> $request->filename]);
      }
      else if ($process=="btngalleypdf") {
        $request->merge(["galleypdf_start"=>$processStartTime, "galleypdf_end"=>$processEndTime, "galleypdf"=> 1, "article_id"=> $request->filename]); 
      } else {
        $request->merge(["galleyproofpdf_start"=>$processStartTime, "galleyproofpdf_end"=>$processEndTime, "galleyproofpdf"=> 1, "article_id"=> $request->filename]); 
      }
      $this->repository->updateArticle($request->except(['_token', '_method']));

      return \Response::json(__('alerts.backend.articles.updated'), 200);
      
    }
}
