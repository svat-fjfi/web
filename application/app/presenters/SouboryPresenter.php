<?php
namespace App\Presenters;

use Nette\Application\UI\Form;

/**
 * SouboryPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class SouboryPresenter extends BasePresenter {

    protected $resultId;


    protected function startup()
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }

    


    public function handleSetActive($id, $value) {
        $this->database->table('file')->where(array("slug" => $id))->fetch()->update(array("active" => $value));

        $this->redrawControl();

        
    }


    protected function createComponentUploadForm() {
        $form = new Form();
        $form->setRenderer(new \App\Forms\Bootstrap3FormRenderer());
        $form->addUpload('file', 'Soubor')
            ->addRule(Form::FILLED, 'Je nutné zvolit soubor k nahrání.');
        $form->addText('description', 'Popis')
            ->addRule(Form::FILLED, 'Je nutné zadat popis.');
        $form->addSubmit('send', 'Nahrát');
        $form->onSuccess[] = $this->uploadFormSubmitted;

        return $form;
    }


    public function uploadFormSubmitted(Form $form) {
        $values = $form->values;

        if ($values['file']->isOk()) {

            $ssn = explode('.', $values['file']->getSanitizedName());

            $extension = end($ssn);

            $slug = \Nette\Utils\Strings::webalize($values['description']);
            while($this->database->table('file')->where(array('slug' => $slug))->count()) {
                $slug .= '-'.\Nette\Utils\Strings::random(3);
            }

            $path = '/files/SVAT_'.$slug.'.'.$extension;
            $values['file']->move(WWW_DIR.$path);

            $this->database->table('file')->insert(array(
                'slug' => $slug,
                'description' => $values['description'],
                'path' => $path,
                'date' => new \Nette\DateTime(),
                'active' => 1
            ));

            $this->redrawControl();
        } else {
            $this->flashMessage('Soubor se nepodařilo nahrát. Zkuste to později.', 'error');
            $this->redrawControl();
        }
        
        

    }
    
    
    public function renderDefault($year) {
        $this->template->files = $this->database->table('file')->order("id DESC");

    }


}
