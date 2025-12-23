<?php

class Page
{
    private $title;
    private $footer;
    private $class;
    private $lang;

    public function __construct(string $title, string $footer, string $lang, string $class = "")
    {
        $this->title = $title;
        $this->footer = $footer;
        $this->lang = $lang;
        $this->class = $class;
    }

    public function renderHeader(): void
    {
        echo '<!DOCTYPE html>' . PHP_EOL;
        echo '<html lang="' . $this->lang . '">' . PHP_EOL;
        echo '<head><title>' . $this->title . '</title></head>' . PHP_EOL;
        echo '<body class="' . $this->class . '">' . PHP_EOL;
    }

    public function renderFooter(): void
    {
        echo '<p>' . $this->footer . '</p>' . PHP_EOL;
        echo '</body>' . PHP_EOL;
        echo '</html>' . PHP_EOL;
    }
}

class Field
{
    private $type;
    private $name;
    private $label;

    public function __construct(string $type, string $name, string $label)
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
    }

    public function render(): void
    {
        echo '<label for="' . $this->name . '">' . $this->label . '</label>' . PHP_EOL;
        echo '<input type="' . $this->type . '" name="' . $this->name . '" id="' . $this->name . '"><br>' . PHP_EOL;
    }
}

class Form
{
    private $fields;
    private $action;

    public function __construct(string $action)
    {
        $this->fields = [];
        $this->action = $action;
    }

    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }

    public function render(): void
    {
        echo '<form method="post" action="' . $this->action . '">' . PHP_EOL; // method can be also a variable

        foreach ($this->fields as $field) {
            $field->render();
        }

        echo '<input type="submit" value="Submit">' . PHP_EOL;
        echo '</form>' . PHP_EOL;
    }
}

$page = new Page("First form", "copyright by VTS", "en", "container-fluid mb-5");
$page->renderHeader();
$textField = new Field('text', 'name', 'Name');
$emailField = new Field('email', 'email', 'Email');
$checkboxField = new Field('checkbox', 'subscribe', 'Subscribe to Newsletter');

$form = new Form("add.php");

$form->addField($textField);
$form->addField($emailField);
$form->addField($checkboxField);

$form->render();

$page->renderFooter();