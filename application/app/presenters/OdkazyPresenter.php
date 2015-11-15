<?php

namespace App\Presenters;

/**
 * OdkazyPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class OdkazyPresenter extends TexyPresenter {

    public function renderDefault($year) {

        $this->template->title = 'Odkazy';

        parent::renderDefault($year);
    }

}
