<?php
use App\Http\Controllers\Backend\Editex\EditexProcessController;
// Pages Management
Route::group(['prefix' => 'editex',
              'as' => 'editex.',
              'namespace' => 'Editex',
              'middleware' => 'access.routeNeedsPermission:view-articles-management'], function () {

                // Article CRUD
    Route::get('articles', [EditexProcessController::class, 'index'])->name('articles.index');
    Route::get('article/create', [EditexProcessController::class, 'create'])->name('article.create');
    Route::post('article/store', [EditexProcessController::class, 'store'])->name('article.store');
    //Route::resource('editex', 'EditexProcessController', ['except' => ['show']]);
     // Specific Article
     Route::group(['prefix' => 'article/{article}'], function () {
      // Article
      Route::get('/', [EditexProcessController::class, 'show'])->name('article.show');
      Route::get('edit', [EditexProcessController::class, 'edit'])->name('article.edit');
      Route::patch('/', [EditexProcessController::class, 'update'])->name('article.update');
      Route::delete('/', [EditexProcessController::class, 'destroy'])->name('article.destroy');
      //Run batch file
      Route::post('runbat', [EditexProcessController::class, 'runBatchfile'])->name('article.runbat');
     });
    
    //For DataTables
    Route::post('articles/get', 'EditexTableController')->name('articles.get');
});
