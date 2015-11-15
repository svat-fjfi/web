<?php

namespace App\Presenters;

/**
 * VysledkyPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class VysledkyPresenter extends TexyPresenter {

    public function renderDefault($year) {

        $this->template->title = 'Výsledky';

        parent::renderDefault($year);
    }



}