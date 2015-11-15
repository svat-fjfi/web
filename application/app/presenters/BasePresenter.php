<?php

namespace App\Presenters;

use Nette,
	App\Model;


/**
 * Base presenter for all application presenters.
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var \Nette\Database\Context @inject */
    public $database;

    public function renderDefault($year) {

    }

}
