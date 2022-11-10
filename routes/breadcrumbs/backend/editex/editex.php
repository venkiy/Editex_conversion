<?php

Breadcrumbs::for('admin.editex.articles.index', function ($trail) {
    $trail->push(__('labels.backend.access.editex.management'), route('admin.editex.articles.index'));
});

Breadcrumbs::for('admin.editex.article.create', function ($trail) {
    $trail->parent('admin.editex.articles.index');
    $trail->push(__('labels.backend.access.editex.management'), route('admin.editex.article.create'));
});

Breadcrumbs::for('admin.editex.article.show', function ($trail, $id) {
    $trail->parent('admin.editex.articles.index');
    $trail->push(__('labels.backend.access.editex.management'), route('admin.editex.article.show', $id));
});
