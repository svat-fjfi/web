<?php

namespace App\Presenters;

/**
 * ZadaniPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class ZadaniPresenter extends TexyPresenter
{
    public function renderDefault() {

        $this->template->title = 'Zadání';

        parent::renderDefault();
    }

}
