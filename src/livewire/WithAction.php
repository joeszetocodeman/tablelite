<?php

namespace Tablelite\livewire;

use App\Domain\CouponInsert\Traits\EvaluatesClosures;
use Tablelite\SupportSlideOver\SlideOver;

trait WithAction
{
    use EvaluatesClosures;

    public function callTableAction(string $name)
    {
        try {
            $closure = $this->getTableAction($name);
            $this->evaluate($closure, [
                'slideOver' => app(SlideOver::class, ['table' => $this->table])
            ]);
        } catch (\Exception $e) {
        }
    }

    /**
     * @throws \Exception
     */
    public function getTableAction(string $name)
    {
        foreach ($this->table->getHeaderActions() as $action) {
            if ($action->getName() === $name) {
                return $action->getAction()(...);
            }
        }

        throw new \Exception('can not find action with name: '.$name);
    }
}
