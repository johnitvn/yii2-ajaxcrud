
yii2-ajaxcrud
=============
[![Latest Stable Version](https://poser.pugx.org/johnitvn/yii2-ajaxcrud/v/stable)](https://packagist.org/packages/johnitvn/yii2-ajaxcrud)
[![License](https://poser.pugx.org/johnitvn/yii2-ajaxcrud/license)](https://packagist.org/packages/johnitvn/yii2-ajaxcrud)
[![Total Downloads](https://poser.pugx.org/johnitvn/yii2-ajaxcrud/downloads)](https://packagist.org/packages/johnitvn/yii2-ajaxcrud)
[![Monthly Downloads](https://poser.pugx.org/johnitvn/yii2-ajaxcrud/d/monthly)](https://packagist.org/packages/johnitvn/yii2-ajaxcrud)
[![Daily Downloads](https://poser.pugx.org/johnitvn/yii2-ajaxcrud/d/daily)](https://packagist.org/packages/johnitvn/yii2-ajaxcrud)
[![Stories in Ready](https://badge.waffle.io/johnitvn/yii2-ajaxcrud.png?label=ready&title=Ready)](https://waffle.io/johnitvn/yii2-ajaxcrud)

Gii CRUD template for Single Page Ajax Administration for yii2

![yii2 ajaxcrud extension screenshot](https://c1.staticflickr.com/1/330/18659931433_6e3db2461d_o.png "yii2 ajaxcrud extension screenshot")


Features
------------
+ Create, read, update, delete in onpage with Ajax
+ Bulk delete suport
+ Pjax widget suport
+ Export function(pdf,html,text,csv,excel,json)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist johnitvn/yii2-ajaxcrud "*"
```

or add

```
"johnitvn/yii2-ajaxcrud": "*"
```

to the require section of your `composer.json` file.


Usage
-----
For first you must enable Gii module Read more about [Gii code generation tool](http://www.yiiframework.com/doc-2.0/guide-tool-gii.html)

Because this extension used [kartik-v/yii2-grid](https://github.com/kartik-v/yii2-grid) extensions so we must config gridview module before

Let 's add into modules config in your main config file
````php
'modules' => [
    'gridview' =>  [
        'class' => '\kartik\grid\Module'
    ]       
]
````

You can then access Gii through the following URL:

http://localhost/path/to/index.php?r=gii

and you can see <b>Ajax CRUD Generator</b>


Contributing to this project
----------------------------

Anyone and everyone is welcome to contribute. 

License
----------------------------
yii2-ajaxcrud is released under the Apache-2.0.

Versions History
----------------------------
<b>Version 1.0.5</b>
+ Release a final stable of version 1.0.*

<b>Version 1.0.5</b>
+ Fix some bugs
+ Add process toggle column
+ Move GridView to Assets package

<b>Version 1.0.4</b>
+ Catch when ajax take a error response
+ Fix bug toogle fullscreen icon error when user press Esc key for quit fullscreen
+ Make the default panel title is 'List of [Model Class Name]'
Note: This version almost update assets. It safe for update, no need regenerate or path anything

<b>Version 1.0.3</b>
+ Separate assets to yii2-ajaxcrud-assets
Note: This version need regenerate or you can path for upgrade to this version
See: [Issue #6](https://github.com/johnitvn/yii2-ajaxcrud/issues/6) for more information

<b>Version 1.0.2</b>
+ Clean template for better output

<b>Version 1.0.1</b>
+ Fix bug: Invalid icon for fullscreen button

<b>Version 1.0.0</b>
+ Initial version
