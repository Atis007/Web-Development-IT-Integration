<?php
namespace MyApp;

class Form
{
    public function __construct(
        public string  $name,
        public string  $method = 'post',
        public string  $action = '',
        public ?string $id = null,
        public ?string $class = null,
        public ?string $enctype = null
    )
    {
    }


    private function renderAttributes(array $attributes): string
    {
        $result = [];
        foreach ($attributes as $key => $value) {
            if (!empty($value)) {
                $result[] = htmlspecialchars($key) . '="' . htmlspecialchars((string)$value) . '"';
            }
        }
        return implode(' ', $result);
    }


    public function renderStart(): string
    {
        $attributes = $this->renderAttributes([
            'method' => $this->method,
            'action' => $this->action,
            'name' => $this->name,
            'id' => $this->id,
            'class' => $this->class,
            'enctype' => $this->enctype
        ]);
        return "<form $attributes>\n";
    }


    public function renderEnd(): string
    {
        return "</form>\n";
    }
}
