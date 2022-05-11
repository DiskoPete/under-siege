<?php

namespace App\View\Components\Ui;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class HeadersInput extends Component
{
    public function __construct(
        public readonly Collection|array|null $headers = new Collection()
    )
    {
    }


    public function render(): View
    {
        return view('components.ui.headers-input');
    }

    public function getHeadersCollection(): Collection
    {
        return collect($this->headers)
            ->map(fn(string $value, string $key) => [$key, $value])
            ->values();
    }
}
