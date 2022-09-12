<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@include('partials.sidebar_link', [
    'entry' => [
        backpack_url('dashboard'),
        trans('backpack::base.dashboard'),
        'las la-tachometer-alt'
    ],
    'permission' => ''
])
{{-- @include('partials.sidebar_link', [
    'entry' => [
        backpack_url('page'),
        'Pages',
        'la la-file-o'
    ],
    'permission' => 'pages'
]) --}}
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
                    backpack_url('type'),
                    trans('system.type'),
                    'nav-icon la la-database'
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
        ],
        [
            'entry' => [
                    backpack_url('api_explorer'),
                    trans('system.api_explorer'),
                    'nav-icon lab la-searchengin'
                ],
        ],
        [
            'entry' => [
                            backpack_url('job'),
                            trans('system.jobs'),
                            'nav-icon las la-sync'
                ],
        ],
        [
            'entry' => [
                    backpack_url('failed_job'),
                    trans('system.failed_jobs'),
                    'nav-icon las la-undo-alt'
                ],
        ]
    ]
])




<li class='nav-item'><a class='nav-link' href='{{ backpack_url('products') }}'><i class='nav-icon la la-question'></i> Products</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('orders') }}'><i class='nav-icon la la-question'></i> Orders</a></li>