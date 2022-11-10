@extends('backend.layouts.app')

@section('title', __('labels.backend.access.editex.management') . ' | ' . __('labels.backend.access.editex.create'))

@section('breadcrumb-links')
    @include('backend.editex.includes.breadcrumb-links')
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.editex.article.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-article', 'files' => true]) }}

    <div class="card">
        @include('backend.editex.articles.form')
        @include('backend.components.footer-buttons', [ 'cancelRoute' => 'admin.editex.articles.index' ])
    </div><!--card-->
    {{ Form::close() }}
@endsection