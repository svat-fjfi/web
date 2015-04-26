<?php

namespace App\Presenters;

/**
 * VyzkumacekPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class VyzkumacekPresenter extends TexyPresenter {

    public function renderDefault() {

        $this->template->title = 'Výzkumáček';

        parent::renderDefault();
    }

}
