<?php

namespace App\Presenters;

/**
 * HomepagePresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class HomepagePresenter extends TexyPresenter {

    public function renderDefault($year) {

        $this->template->title = 'S.V.A.T.';

        parent::renderDefault($year);
    }

}
