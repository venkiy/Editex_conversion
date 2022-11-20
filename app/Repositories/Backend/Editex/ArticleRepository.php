<?php

namespace App\Repositories\Backend\Editex;

use App\Exceptions\GeneralException;
use App\Models\Editex\Article;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Article::class;

    protected $upload_path;

    /**
     * Sortable.
     *
     * @var array
     */
    private $sortable = [
        'id',
        'publisher_id',
        'publisher_name',
        'article_id',
        'noecs',
        'galleypdf',
        'typeset',
        'active',
        'created_at',
        'updated_at',
    ];

    /**
     * Storage Class Object.
     *
     * @var \Illuminate\Support\Facades\Storage
     */
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'editex'.DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('local');
    }

    /**
     * Retrieve List.
     *
     * @var array
     * @return Collection
     */
    public function retrieveList(array $options = [])
    {
        $perPage = isset($options['per_page']) ? (int) $options['per_page'] : 20;
        $orderBy = isset($options['order_by']) && in_array($options['order_by'], $this->sortable) ? $options['order_by'] : 'created_at';
        $order = isset($options['order']) && in_array($options['order'], ['asc', 'desc']) ? $options['order'] : 'desc';
        $query = $this->query()
            ->with([
                'owner',
                'updater',
            ])
            ->orderBy($orderBy, $order);

        if ($perPage == -1) {
            return $query->get();
        }

        return $query->paginate($perPage);
    }

    /**
     * @return mixed
     */
    public function getForDataTable()
    {
        return $this->query()            
            ->select([
                'articles.id',
                'articles.publisher_id',
                'articles.publisher_name',
                'articles.article_id',
                'articles.noecs',
                'articles.galleypdf',
                'articles.typeset',
                'articles.active',               
                'articles.created_at'
                
            ]);
    }

    /**
     * @param array $input
     *
     * @throws \App\Exceptions\GeneralException
     *
     * @return bool
     */
    public function create(array $input)
    {
        
        return DB::transaction(function () use ($input) {
            
            if ($article = Article::create($input)) {
                
                //event(new BlogCreated($blog));

                return $article;
            }

            throw new GeneralException(__('exceptions.backend.articles.create_error'));
        });
    }

    /**
     * @param \App\Models\Blog $blog
     * @param array $input
     */
    public function update(Blog $blog, array $input)
    {
        $tagsArray = $this->createTags($input['tags']);
        $categoriesArray = $this->createCategories($input['categories']);

        unset($input['tags'], $input['categories']);

        $input['slug'] = Str::slug($input['name']);
        $input['updated_by'] = auth()->user()->id;
        $input['publish_datetime'] = Carbon::parse($input['publish_datetime']);

        // Uploading Image
        if (array_key_exists('featured_image', $input)) {
            $this->deleteOldFile($blog);
            $input = $this->uploadImage($input);
        }

        return DB::transaction(function () use ($blog, $input, $tagsArray, $categoriesArray) {
            if ($blog->update($input)) {
                // Updateing associated category's id in mapper table
                if (count($categoriesArray)) {
                    $blog->categories()->sync($categoriesArray);
                }

                // Updating associated tag's id in mapper table
                if (count($tagsArray)) {
                    $blog->tags()->sync($tagsArray);
                }

                event(new BlogUpdated($blog));

                return $blog->fresh();
            }

            throw new GeneralException(__('exceptions.backend.blogs.update_error'));
        });
    }

    /**
     * @param \App\Models\Editex\Article $article
     * @param array $input
     */
    public function updateArticle(array $input)
    {   
        $articleid = Article::where("article_id","=",$input["article_id"])->first();        
        $article = Article::find($articleid->id);
        //print_r($input);exit;
        if($input['process']=="btnnoecs"){
            $article->noecs = $input['noecs'];
            $article->noecse_start = $input['noecs_start'];
            $article->noecse_end = $input['noecs_end'];
        } else if ($input['process']=="btngalleypdf") {
            $article->galleypdf = $input['galleypdf'];
            $article->galleypdf_start = $input['galleypdf_start'];
            $article->galleypdf_end = $input['galleypdf_end'];
        } else {
            $article->galleyproofpdf = $input['galleyproofpdf'];
            $article->galleyproofpdf_start = $input['galleyproofpdf_start'];
            $article->galleyproofpdf_end = $input['galleyproofpdf_end'];
        }
        $article->save();
        
    }

    /**
     * Creating Tags.
     *
     * @param array $tags
     *
     * @return array
     */
    public function createTags($tags)
    {
        //Creating a new array for tags (newly created)
        $tags_array = [];

        foreach ($tags as $tag) {
            if (is_numeric($tag)) {
                $tags_array[] = $tag;
            } else {
                $newTag = BlogTag::firstOrCreate(
                    [
                        'name' => $tag,
                    ],
                    [
                        'name' => $tag,
                        'status' => 1,
                        'created_by' => auth()->user()->id,
                    ]
                );
                $tags_array[] = $newTag->id;
            }
        }

        return $tags_array;
    }

    /**
     * Creating Categories.
     *
     * @param array $categories
     *
     * @return array
     */
    public function createCategories($categories)
    {
        //Creating a new array for categories (newly created)
        $categories_array = [];

        foreach ($categories as $category) {
            if (is_numeric($category)) {
                $categories_array[] = $category;
            } else {
                $newCategory = BlogCategory::firstOrCreate(
                    [
                        'name' => $category,
                    ],
                    [
                        'name' => $category,
                        'status' => 1,
                        'created_by' => auth()->user()->id,
                    ]
                );

                $categories_array[] = $newCategory->id;
            }
        }

        return $categories_array;
    }

    /**
     * @param \App\Models\Blogs\Blog $blog
     *
     * @throws GeneralException
     *
     * @return bool
     */
    public function delete(Blog $blog)
    {
        DB::transaction(function () use ($blog) {
            if ($blog->delete()) {
                BlogMapCategory::where('blog_id', $blog->id)->delete();
                BlogMapTag::where('blog_id', $blog->id)->delete();

                event(new BlogDeleted($blog));

                return true;
            }

            throw new GeneralException(__('exceptions.backend.blogs.delete_error'));
        });
    }

    /**
     * Upload Image.
     *
     * @param array $input
     *
     * @return array $input
     */
    public function uploadImage($input)
    {
        if (isset($input['featured_image']) && ! empty($input['featured_image'])) {
            $avatar = $input['featured_image'];
            $fileName = time().$avatar->getClientOriginalName();

            $this->storage->put($this->upload_path.$fileName, file_get_contents($avatar->getRealPath()));

            $input = array_merge($input, ['featured_image' => $fileName]);
        }

        return $input;
    }

    /**
     * Destroy Old Image.
     *
     * @param int $id
     */
    public function deleteOldFile($model)
    {
        $fileName = $model->featured_image;

        return $this->storage->delete($this->upload_path.$fileName);
    }
}
