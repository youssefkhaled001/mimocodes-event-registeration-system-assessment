<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModal extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $modalId = 'deleteModal',
        public ?string $title = null,
        public ?string $message = null,
        public ?string $confirmText = null
    ) {
        //
    }

    /**
     * Get the form ID based on modal ID.
     */
    public function formId(): string
    {
        return $this->modalId . 'Form';
    }

    /**
     * Get the method input ID based on modal ID.
     */
    public function methodInputId(): string
    {
        return $this->modalId . 'Method';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-modal', [
            'formId' => $this->formId(),
            'methodInputId' => $this->methodInputId(),
        ]);
    }
}
