<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormOption extends Component
{
    public $value;

    public $text;

    public $selected;

    public $name;

    /**
     * Create a new component instance.
     */
    public function __construct($value, $text, $name = null, $selected = null)
    {
        $this->value = $value;
        $this->text = $text;
        $this->name = $name;

        $this->selected = $this->isSelected($selected);
    }

    private function isSelected($explicit)
    {
        if (! is_null($explicit)) {
            return (string) $explicit === (string) $this->value;
        }

        if ($this->name && old($this->name) !== null) {
            return (string) old($this->name) === (string) $this->value;
        }

        return false;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form-option');
    }
}
