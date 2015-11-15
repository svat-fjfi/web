<?php

namespace App\Presenters;

/**
 * MaterialyPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class MaterialyPresenter extends TexyPresenter {

    public function renderDefault($year) {

        $this->template->title = 'Materiály';

        parent::renderDefault($year);
    }

}