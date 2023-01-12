# laarvel jwt & permision laravel

#instalasi

````sh

= JWT ================================================================
https://hackthestuff.com/article/laravel-8-jwt-authentication-tutorial
composer require tymon/jwt-auth
'providers' => [
    ....
    Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
],

php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret

===================================================================
===================================================================
#laravel/permission
https://imansugirman.com/menggunakan-laravel-permission-dari-spatie
composer require spatie/laravel-permission
'providers' => [
    // ...
    Spatie\Permission\PermissionServiceProvider::class,
];
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
=====================================================================
#dinamic model
# doc
[a link](https://github.com/i-rocky/eloquent-dynamic-relation)
=====================================================================
=====================================================================
#modules
#doc
[a link](https://docs.laravelmodules.com/v9/installation-and-setup)
=====================================================================
=====================================================================
#seeders
  $_super_admin = Role::create(['guard_name' => 'api', 'name' => 'super-admin']);
        $_super_admin = Role::create(['guard_name' => 'admin', 'name' => 'super-admin']);

        $_admin = Role::create(['guard_name' => 'api', 'name' => 'admin']);
        $_admin = Role::create(['guard_name' => 'admin', 'name' => 'admin']);

        $_user = Role::create(['guard_name' => 'api', 'name' => 'user']);
        $_user = Role::create(['guard_name' => 'web', 'name' => 'user']);


        $s_admin = User::create([
            'name'    => "super admin",
            'email'    => "super_admin@mail.com",
            'password'    => bcrypt('password')
        ]);

        $s_admin->assignRole($_super_admin);


        $admin = User::create([
            'name'    => "admin",
            'email'    => "admin@mail.com",
            'password'    => bcrypt('password')
        ]);

        $admin->assignRole($_admin);




        $user = User::create([
            'name'    => "user",
            'email'    => "user@mail.com",
            'password'    => bcrypt('password')
        ]);

        $user->assignRole($_user);

=======================================================================


#auth.php
```sh
[
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [

        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],

    ]
]
# json format
{
    "File_name": "Perpustakaan",
    "Public_name": [
        "Perpustakaan",
        "perpustakaan"
    ],
    "Inisial": {
        "table": "perpustakaan",
        "primary": "id",
        "Protected": {
            "hidden": [
                "status"
            ]
        }
    },
    "Namespace": {
        "Controller": "App\\Http\\Controllers\\api\\v1\\PerpustakaanController",
        "Model": "App\\Models\\Perpustakaan",
        "Use_Model": [
            "App\\Models\\Perpustakaan",
            "App\\Models\\User"
        ]
    },
    "Data": {
        "user_id": {
            "name": "user_id",
            "control_insert": "before",
            "label": "",
            "type": "key",
            "relation": {
                "table": "user",
                "function": "users",
                "relation_index": "users",
                "foreign": {
                    "key": "id",
                    "table": "users",
                    "auto_delete_relation": true
                }
            },
            "validate": 2,
            "request": false,
            "migration": 0
        },
        "nama": {
            "name": "nama",
            "label": "Nama",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 1,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "text"
            },
            "costum": {}
        },
        "phone": {
            "name": "nama",
            "label": "Nama",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 2,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "text"
            },
            "costum": {}
        },
        "tahun_berdiri": {
            "name": "tahun_berdiri",
            "label": "Tahun Berdiri",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 2,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "text"
            },
            "costum": {}
        },
        "akreditas": {
            "name": "akreditas",
            "label": "Akreditas",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 2,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "select_static"
            },
            "costum": {}
        },
        "jam_buka": {
            "name": "jam_buka",
            "label": "Jam Buka",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 4,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "time"
            },
            "costum": {}
        },
        "jam_tutup": {
            "name": "jam_tutup",
            "label": "Jam Tutup",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 4,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "time"
            },
            "costum": {}
        },
        "gambar": {
            "validate": 1,
            "type": "image",
            "path": "avatar",
            "request": true,
            "migration": 3,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "time"
            },
            "costum": {}
        },
        "koordinat": {
            "name": "koordinat",
            "label": "Koordinat",
            "type": "string",
            "request": true,
            "validate": 0,
            "migration": 1,
            "view": {
                "table": {
                    "status": true
                },
                "input": {
                    "status": true
                },
                "update": {
                    "status": true
                },
                "form": "text"
            },
            "costum": {}
        },
        "status": {
            "validate": 0,
            "type": "static",
            "value": "active",
            "request": false,
            "migration": 2
        }
    },
    "Relation": {
        "users": {
            "hirarky": "before",
            "model": "\\App\\Models\\User",
            "foreign": "user_id",
            "function": {
                "model": "\\App\\Models\\User",
                "relation": "belongsTo",
                "foreign": "user_id"
            },
            "file_relation": {
                "name": "User",
                "file": "User"
            },
            "data": []
        }
    },
    "Query_get": {
        "get": {
            "role": "perpustakaan",
            "key_where": "user_id"
        },
        "getById": {
            "role": "perpustakaan"
        }
    },
    "Router": {
        "config": {
            "name_space": "App\\Http\\Controllers\\api\\",
            "contoller": "PerpustakaanController"
        },
        "api": {
            "index": {
                "method": "get",
                "router": "/index",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "get": {
                "method": "get",
                "router": "/",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "getById": {
                "method": "get",
                "router": "/{slug}",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "getByIdAndSource": {
                "method": "get",
                "router": "/source/{slug}",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "store": {
                "method": "post",
                "router": "/store",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "update": {
                "method": "post",
                "router": "/update/{id}",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            },
            "delete": {
                "method": "delete",
                "router": "/delete/{id}",
                "prefix": "perpustakaan",
                "middleware": 0,
                "version": "1"
            }
        }
    },
    "Url": {
        "api": {
            "store": "api/perpustakaan/store",
            "update": "api/perpustakaan/update/",
            "delete": "api/perpustakaan/delete/",
            "show": "api/perpustakaan/",
            "getById": "api/perpustakaan/",
            "getByIdSource": "api/perpustakaan/source/"
        },
        "web": {
            "show": "perpustakaan/",
            "detail": "perpustakaan/detail/",
            "input": "perpustakaan/input",
            "update": "perpustakaan/update/",
            "web": "site/perpustakaan/"
        }
    }
}
```sh

````
