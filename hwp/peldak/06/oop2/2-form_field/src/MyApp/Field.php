<?php
namespace MyApp;

class Field
{
    public function __construct(
        public string     $name,
        public string     $type,
        public string|int $value = '',
        public ?string    $id = null,
        public int        $size = 0,
        public ?string    $label = null
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

    public function render(): string
    {
        $labelHtml = !empty($this->label)
            ? '<label' . (!empty($this->id) ? ' for="' . $this->id . '"' : '') . '>' . $this->label . ': </label>' . "\n"
            : '';

        $attributes = $this->renderAttributes([
            'type' => $this->type,
            'name' => $this->name,
            'id' => $this->id,
            'value' => $this->value,
            'size' => $this->size
        ]);
        return $labelHtml . "<input $attributes><br>\n";
    }
}