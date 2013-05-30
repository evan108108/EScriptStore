EScriptStore
============

Yii Module &amp; Widget that registers inline JS and CSS as an external file.


##install

1. Place EScriptStore into your modules directory.

2. Edit config/main.php

```php
	'import'=>array(
		…,
		'application.modules.EScriptStore.widgets.CMeInFile.*',
	),
	…,
	'modules=>array(
		'EScriptStore',
		…,
	),
	…,
```

##Examples

1. Register Inline JS as external script. The code bellow will register a script include to the head of your document.

```html
<?php $this->beginWidget('EJSscript');  ?>
	var x = 100;
<?php $this->endWidget(); ?>

<h1>Some Heading</h2>

<?php $this->beginWidget('EJSscript');  ?>
	alert(x);
<?php $this->endWidget(); ?>
```

2. Register Inline CSS as external script. The code bellow will register a script include to the head of your document.


```html
<?php $this->beginWidget('ECSSscript');  ?>
	.someClass: {width:100px;}
	.someOther: {width:200px;}
<?php $this->endWidget(); ?>

<?php $this->beginWidget('ECSSscript');  ?>
	.someClassTwo: {width:101px;}
	.someOtherThree: {width:201px;}
<?php $this->endWidget(); ?>
```




