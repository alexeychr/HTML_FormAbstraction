# HTML Form Abstraction for PHP
 
This library provides a bidirectional abstraction layer between HTML \<form\>'s (and their elements) and PHP objects. Such a layer makes it easier to map form fields to classes, validate them and transform back to HTML containers.

# The benefits

* OOP representation of HTML forms and their elements (input, select, button, file uploads, etc) 
* data de-coupling and object model that cares about your app architecture and fits into MVC pattern
* mapping of raw incoming data (GET, POST) to objects of forms and forms elements 
* builtin and extensible data validation
* really easy interaction with mapping and validation errors 
* builtin form signatures to prevent CSRF attacks
* transformation of objects to raw HTML, taking predefined and raw values into consideration


## Why to have yet another abstraction layer? 

The history of PHP provides a lot of great examples of template engines and HTML abstractions: Smarty, HTML_FormPersister, etc. Still, there is no truly OOP solution, which is important when dealing with huge projects.
 
## Why not to use native PHP?

Perhaps, abstraction is useless when we deal with simple form that consists of one or two input fields:

```php
<input type="text" name="email" value="<?=htmlSpecialChars($_GET['email'])?>" />
```

The complexity comes when we need to generate a single or multivalue selectbox with the set of predefined values, when some of them may be default or selected:
 
```
<select name="fruits" multiple="multiple" id="fruit-selector" class="f-sel">
	<? foreach ($fruitsOptions as $fruitId => $fruitName) { ?>
		<option name="<?= $fruitId?> " <? // check if $fruitId is selected
```

Uf, that is not easy... 

With HTML Form Abstraction such a mess goes away forever. Example:

```php
$myForm->fruits->toHtml([
	"id" => fruit-selector", 
	"class" => 'f-sel'
])
```

# The Status

*IMPORTANT!* 

This library was developed to be compatible with Phoebius framework (https://github.com/phoebius/phoebius) and thus it is not a standalone library yet.

This library is licensed under the LGPL.

# Some examples

## Prototyping

```php
class PhotoEditForm extends Form 
{
	/**
	 * @var Photo
	 */
	private $photo;

	function __construct(Photo $photo, HttpUrl $url)
	{
		$this->photo = $photo;
	
		parent::__construct(__CLASS__, $url, $signed);
		$this->addControl(FormControl::string("name"));
		$this->addControl(FormControl::email("email"));
		$this->addControl(FormControl::password("password"));
		$this->addControl(FormControl::string("website", false));
		$this->addControl(FormControl::textarea("about"));
		$this->addControl(FormControl::image("image"));
		$this->addControl(FormControl::file("metafile"));
		$this->addControl(FormControl::fileSet("images"));
		$this->addControl(FormControl::checkbox("is_private"));
		$this->addControl(FormControl::checkboxSet("licence", array(0 => 'free', 1 => 'pay'), array(0, 1)));
		$this->addControl(FormControl::select("quality", array(0 => 'low', 1 => 'normal', 2 => 'high'), 0));
		$this->addControl(FormControl::selectMultiple("license", array(0 => 'free', 1 => 'pay'), array(0, 1)));
		$this->addControl(FormControl::radioGroup("priority", array(0 => 'low', 1 => 'normal', 2 => 'high'), 0));
	
		$this->addButton("save", "Save");
		$this->addButton("delete", "Delete");
	}
}
```

## Using inside the controllers

```
// signless:
$form = new SomeForm();
$form->import($request->getPost());
if ($form->hasErrors()) {
	// import failed
}
else {
	// all ok
}
return new View("auth", array('form' => $form));


// signed:
$form = new SomeForm(..., $signed = true);
try {
	$form->handle($request);
	if (!$form->hasErrors())
		return "/";
}
catch (FormSubmitException $e) {
	// not matched or invalidated
}
$form->sign($request);
return new View("auth", array('form' => $form));
```

## Using inside the views

```
<?= $this->form->getHeadHtml(array('id' => 'page-form'))?>
	<div class="row">
		<label class="title"><?= $this->form->title->getLabel()?></label>
		<div class="field"><?= $this->form->title->toHtml()?></div>
		<div class="error"><?= $this->form->title->getErrorMessage()?></div>
	</div>
	<div class="row">
		<label class="title"><?= $this->form->path->getLabel()?></label>
		<div class="field"><?= $this->form->path->toHtml()?></div>
		<div class="error"><?= $this->form->path->getErrorMessage()?></div>
	</div>
	<div class="row">
		<label class="title"><?= $this->form->text->getLabel()?></label>
		<div class="field"><?= $this->form->text->toHtml(array('cols' => 100, 'rows' => 20))?></div>
	</div>

	<div class="actions">
		<div class="loading">
			<span style="visibility: hidden;"></span>
		</div>
		<div class="buttons">
			<?= $this->form->submit->toHtml()?>
			<? if (isset($this->form->delete)) echo $this->form->delete->toHtml(); ?>
		</div>
	</div>
<?= $this->form->getHeelHtml()?>
```