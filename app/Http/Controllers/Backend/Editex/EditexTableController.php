<?php

namespace App\Http\Controllers\Backend\Editex;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Editex\ManageArticleRequest;
use App\Repositories\Backend\Editex\ArticleRepository;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class EditexTableController.
 */
class EditexTableController extends Controller
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
    }

    /**
     * @param \App\Http\Requests\Backend\Editex\ManageArticleRequest $request
     *
     * @return mixed
     */
    public function __invoke(ManageArticleRequest $request)
    {
        return Datatables::make($this->repository->getForDataTable($request->get('status'), $request->get('trashed')))
            ->escapeColumns([])
            ->editColumn('noecs', function ($article) {
                return $article->noecs_label;
            })
            ->editColumn('galleypdf', function ($article) {
                return $article->galleypdf_label;
            })
            ->editColumn('typeset', function ($article) {
                return $article->typeset_label;
            })
            ->editColumn('status', function ($article) {
                return $article->status_label;
            })
            ->addColumn('actions', function ($article) {
                return $article->action_buttons;
            })
            ->make(true);
    }
}
