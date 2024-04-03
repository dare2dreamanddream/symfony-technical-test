<?php

namespace App\System\Traits;

use Symfony\Component\HttpFoundation\Request;

trait EntityTrait
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this
            ->setRequest($request)
            ->fromRequest();
    }

    private function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function fromRequest(): void
    {
        $fields = $this->request->request->all();
        if (sizeof((array)$fields) > 0) {
            foreach ($fields as $field => $value) {
                $this->$field = $value;
            }
        }
    }
}