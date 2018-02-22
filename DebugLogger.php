<?php


namespace DebugLogger;


class DebugLogger
{

    protected $env;
    protected $colors;

    public function __construct()
    {
        $this->env = ('cli' === php_sapi_name()) ? 'cli' : 'web';
        $this->colors = [
            'warning' => 'orange',
            'info' => 'blue',
            'success' => 'success',
            'error' => 'red',
        ];
    }


    public static function create()
    {
        return new static();
    }



    //--------------------------------------------
    //
    //--------------------------------------------
    public function log($mixed, $type = 'info', $br = false)
    {
        $this->output($mixed, $type, $br);
    }

    public function warning($mixed, $br = false)
    {
        $this->output($mixed, 'warning', $br);
    }

    public function info($mixed, $br = false)
    {
        $this->output($mixed, 'info', $br);
    }

    public function success($mixed, $br = false)
    {
        $this->output($mixed, 'success', $br);
    }

    public function error($mixed, $br = false)
    {
        $this->output($mixed, 'error', $br);
    }



    //--------------------------------------------
    //
    //--------------------------------------------
    protected function output($mixed, $type, $br)
    {
        $color = $this->colors[$type];
        if ('cli' === $this->env) {
            $this->renderCli($mixed, $type, $color, $br);
        } else {
            $this->renderWeb($mixed, $type, $color, $br);
        }
    }

    protected function renderWeb($mixed, $type, $color, $br = false)
    {
        echo '<span style="color: ' . $color . '">';
        if (is_scalar($mixed)) {
            echo $mixed;
        } else {
            if (function_exists("a")) { // universe framework
                a($mixed);
            } else {
                var_dump($mixed);
            }
        }
        echo '</span>';

        if (true === $br) {
            echo '<br>';
        }
    }


    protected function renderCli($mixed, $type, $color, $br = false)
    {
        /**
         * @todo-ling: implement colors for cli
         */
        echo $mixed;
        if (true === $br) {
            echo PHP_EOL;
        }
    }


}