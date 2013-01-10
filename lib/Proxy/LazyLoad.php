<?php

namespace mineichen\entityManager\proxy;

use mineichen\entityManager\proxy\Complementer;

trait LazyLoad
{
    private $complementer;

    protected function lazyLoad($value)
    {
        if ($value instanceof NotLoaded) {

            $this->getComplementer()->complement($this);

            $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
            $methodName = $backtrace['function'];
            $args = $backtrace['args'];

            return call_user_func_array(array($this, $methodName), $args);
        }

        return $value;
    }

    public function setComplementer(Complementer $complementer)
    {
        $this->complementer = $complementer;
    }

    protected function getComplementer()
    {
        if (!($this->complementer instanceof Complementer)) {
            throw new Exception('LazyLoad hasn\'t already got a Complementer. Probably your Entity doesn\'t implement "Complementable"');
        }

        return $this->complementer;
    }
}