Image placeholder
=================
Image placeholder

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist tigokr/yii2-image-placeholder "*"
```

or add

```
"tigokr/yii2-image-placeholder": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```html
<img src="/placeholder/300x200?text=no+photo">
<img src="/placeholder/300">
<img src="/placeholder/300x200?fg=9bce3b&bg=fff&text=no+photo">

```