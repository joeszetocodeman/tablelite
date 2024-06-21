<?php

namespace Tablelite\livewire;

use App\Domain\CouponInsert\Traits\EvaluatesClosures;
use Tablelite\SlideOver;

trait WithAction
{
    use EvaluatesClosures;

    public function callTableAction(string $name)
    {
        try {
            $closure = $this->getAction($name);
            $this->evaluate($closure, [
                'slideOver' => app(SlideOver::class, ['table' => $this->table])
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * @throws \Exception
     */
    public function getAction(string $name)
    {
        foreach ($this->table->getHeaderActions() as $action) {
            if ($action->getName() === $name) {
                return $action->getAction()(...);
            }
        }

        throw new \Exception('can not find action with name: '.$name);
    }
}
