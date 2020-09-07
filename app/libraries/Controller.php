<?php

/**
 * Class Controller
 *
 * Base Controller to load the models and views
 */
class Controller
{
    /**
     * @param $model
     * @return mixed
     */
    public function model($model)
    {
        // Require model file
        require_once '../app/models/' . $model . '.php';

        // instantiate model
        return new $model();
    }

    public function view($view, $data = [])
    {
        // Check for view file
        if (file_exists('../app/views/' . $view . '.php')) {

            require_once '../app/views/' . $view . '.php';

        } else {

            // view does not exists
            die('View does not exists');
        }

    }
}