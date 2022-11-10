<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Route::is('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-title">
                    @lang('menus.backend.sidebar.system')
                </li>

                <li class="nav-item nav-dropdown {{
                    active_class(Route::is('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Route::is('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Route::is('admin/auth/permission*'))
                            }}" href="{{ route('admin.auth.permission.index') }}">
                                @lang('labels.backend.access.permissions.management')
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="divider"></li>

                <li class="nav-item">
                    <a class="nav-link {{
                        active_class(Route::is('admin/editex*'))
                    }}" href="{{ route('admin.editex.articles.index') }}">
                        <i class="nav-icon fas fa-file"></i>
                        @lang('menus.backend.sidebar.editex')
                    </a>
                </li>
                <li class="divider"></li>

<li class="nav-item nav-dropdown {{
    active_class(Route::is('admin/blogs'), 'open')
}}">
    <a class="nav-link nav-dropdown-toggle {{
            active_class(Route::is('admin/blogs*'))
        }}" href="#">
        <i class="nav-icon fas fa-rss"></i> @lang('menus.backend.sidebar.blogs')
    </a>

    <ul class="nav-dropdown-items">
        <li class="nav-item">
            <a class="nav-link {{
            active_class(Route::is('admin/blogs/blog-categories*'))
        }}" href="{{ route('admin.blog-categories.index') }}">
                @lang('labels.backend.access.blog-category.management')
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{
            active_class(Route::is('admin/blogs/blog-tags*'))
        }}" href="{{ route('admin.blog-tags.index') }}">
                @lang('labels.backend.access.blog-tag.management')
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ active_class(Route::is('admin/blogs')) }}" 
                href="{{ route('admin.blogs.index') }}">
                @lang('labels.backend.access.blogs.management')
            </a>
        </li>
    </ul>
</li>
                

            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
