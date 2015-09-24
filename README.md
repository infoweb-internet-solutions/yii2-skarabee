Skarabee module for Yii 2
=====================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require infoweb-internet-solutions/yii2-skarabee "*"
```

or add

```
"infoweb-internet-solutions/yii2-skarabee": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed run this migration

```bash
yii migrate/up --migrationPath=@infoweb/skarabee/migrations
```

Enable the module in `common\config\main.php` as follows:

```php
'modules' => [
    ...
    'skarabee' => [
        'class' => 'infoweb\skarabee\Module',
    ],
],
```

And configure the component in `common\config\main.php`:
```php
'components' => [
	...
    'skarabee' => [
    	'class' => 'infoweb\skarabee\components\Skarabee',
        'userName' => XXXXXX,
        'password' => XXXXXX
    ]
]
```

Import the translations and use category 'infoweb/skarabee':
```bash
yii i18n/import @infoweb/skarabee/messages
```

You can import real estates from **Skarabee** into your database from the command line with the following command:
```bash
yii skarabee/import
```
Configuration
-------------
All available configuration options are listed below with their default values.
___
##### realEstateUrlPrefix (type: `string`, default: )
The value of this option will be used in the `getUrl` method of the `infoweb\Skarabee\models\RealEstate` model. It serves as the prefix in the url structure and is a translation key in the `url` **i18n** category.
___