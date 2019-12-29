Installing Ion Auth.
===================================

Before installing, please check that you are meeting the minimum server requirements.

There are 2 ways to install this package.

> 1. Move files from this package to the corresponding folder structure:

```shell
CI                          # → Root Directory
└── application/
    ├── config/
    │   └── ion_auth.php
    ├── controllers/
    │   └── Auth.php
    ├── libraries
    │   └── Ion_auth.php
    ├── models
    │   └── Ion_auth_model.php
    └── views/
        └── auth/           # → Various view files
```


---


> 2. Move files from this package to the corresponding **third_party** structure:

```shell
CI                          # → Root Directory
└── application/
    ├── controllers/
    │   └── Auth.php
    ├── third_party/
    │   └── ion_auth/
    │       ├── config/
    │       │   └── ion_auth.php
    │       ├── libraries
    │       │    └── Ion_auth.php
    │       └── models
    │            └── Ion_auth_model.php
    └── views/
        └── auth/           # → Various view files
```

Then in your controller, example `Auth.php` add the package path and load the library like normal

	$this->load->add_package_path(APPPATH.'third_party/ion_auth/');
	$this->load->library('ion_auth');

Or autoload by adding the following to application/config/autoload.php

	$autoload['packages'] = array(APPPATH.'third_party/ion_auth');


---

### Relational DB Setup
Add the tables from `/sql/` onto your database. Those are authorization related tables.

Then, add the `sessions` table to track the Sessions.
The more information and the scheme of the table could be found on the documentation of [Symfony Sessions PDO Handler](https://symfony.com/doc/2.2/cookbook/configuration/pdo_session_storage.html)


