<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('dashboard'),
        trans('backpack::base.dashboard'),
        'las la-tachometer-alt'
    ],
    'permission' => ''
])
@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('page'),
        'Pages',
        'la la-file-o'
    ],
    'permission' => 'pages'
])
@include('partials.sidebar_dropdown', [
    'entry' => [
        'la la-newspaper-o',
        'News',
    ],
    'permissions' => ['articles', 'tags', 'categories'],
    'drop_items' => [
        [
            'entry' => [
                backpack_url('article'),
                'Articles',
                'la la-newspaper-o'
            ],
            'permission' => 'articles'
        ],
        [
            'entry' => [
                backpack_url('category'),
                'Categories',
                'la la-list'
            ],
            'permission' => 'categories'
        ],
        [
            'entry' => [
                backpack_url('tag'),
                'Tags',
                'la la-tag'
            ],
            'permission' => 'tags'
        ]
    ]
])
@include('partials.sidebar_dropdown', [
    'entry' => [
        'la la-users',
        'Authentication',
    ],
    'permissions' => ['users'],
    'drop_items' => [
        [
            'entry' => [
                backpack_url('user'),
                'Users',
                'la la-user'
            ],
            'permission' => 'users'
        ],
        [
            'entry' => [
                backpack_url('role'),
                'Roles',
                'la la-id-badge'
            ],
        ],
        [
            'entry' => [
                backpack_url('permission'),
                'Permissions',
                'la la-key'
            ],
        ]
    ]
])
@include('partials.sidebar_dropdown', [
    'entry' => [
        'las la-tools',
        'Dev Tools',
    ],
    'roles' => 'isSuperAdminRole',
    'drop_items' => [
        [
            'entry' => [
                backpack_url('setting'),
                'Settings',
                'la la-cog'
            ],
        ],
        [
            'entry' => [
                backpack_url('log'),
                'Logs',
                'nav-icon las la-terminal'
            ],
        ],
        [
            'entry' => [
                backpack_url('languages'),
                'Languages',
                'las la-globe'
            ],
        ],
        [
            'entry' => [
                backpack_url('elfinder'),
                trans('backpack::crud.file_manager'),
                'la la-files-o'
            ],
        ]
    ]
])
