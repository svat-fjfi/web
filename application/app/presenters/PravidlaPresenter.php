<?php

namespace App\Presenters;

/**
 * PravidlaPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class PravidlaPresenter extends TexyPresenter {

    public function renderDefault() {

        $this->template->title = 'Pravidla';

        parent::renderDefault();
    }

}