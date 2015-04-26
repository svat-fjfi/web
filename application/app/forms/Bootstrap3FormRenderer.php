<?php

namespace App\Forms;

use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Forms\Controls;
use Nette\Forms\Form;
use Nette;
use Nette\Utils\Html;

/**
 * Description of Bootstrap3FormRenderer
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 19.4.2015
 * 
 */
class Bootstrap3FormRenderer extends DefaultFormRenderer {
    
    /** @var bool */
    private $controlsInit = FALSE;

    public function __construct() {
        $this->wrappers['form']['class'] = 'form-vertical';
        $this->wrappers['controls']['container'] = NULL;
        $this->wrappers['pair']['container'] = 'div class=form-group';
        $this->wrappers['pair']['.error'] = 'has-error';
        $this->wrappers['control']['container'] = NULL;
        $this->wrappers['control']['class'] = 'form-control';
        $this->wrappers['label']['container'] = NULL;
        $this->wrappers['label']['class'] = 'control-label';
        $this->wrappers['control']['description'] = 'span class=help-block';
        $this->wrappers['control']['errorcontainer'] = 'span class=help-block';
    }

    public function renderBegin() {
        $this->controlsInit();
        return parent::renderBegin();
    }

    public function renderEnd() {
        $this->controlsInit();
        return parent::renderEnd();
    }

    public function renderBody() {
        $this->controlsInit();
        return parent::renderBody();
    }

    public function renderControls($parent) {
        $this->controlsInit();
        return parent::renderControls($parent);
    }

    public function renderPair(Nette\Forms\IControl $control) {
        $this->controlsInit();
        return parent::renderPair($control);
    }

    public function renderPairMulti(array $controls) {
        $this->controlsInit();
        return parent::renderPairMulti($controls);
    }

    public function renderLabel(Nette\Forms\IControl $control) {
        $this->controlsInit();
        return parent::renderLabel($control);
    }

    public function renderControl(Nette\Forms\IControl $control) {
        $this->controlsInit();
        return parent::renderControl($control);
    }

    private function controlsInit() {
        if ($this->controlsInit) {
            return;
        }

        $this->controlsInit = TRUE;
        foreach ($this->form->getControls() as $control) {
            if ($control instanceof Controls\Button) {
                if (empty($usedPrimary) && $control->parent instanceof Form) {
                    $class = 'btn btn-primary';
                    $usedPrimary = TRUE;
                } else {
                    $class = 'btn btn-default';
                }
                $control->getControlPrototype()->addClass($class);
            } elseif ($control instanceof Controls\TextBase || $control instanceof Controls\SelectBox || $control instanceof Controls\MultiSelectBox) {
                $control->getControlPrototype()->addClass('form-control');
            } elseif ($control instanceof Controls\Checkbox || $control instanceof Controls\CheckboxList || $control instanceof Controls\RadioList) {
                $control->getSeparatorPrototype()->setName('div')->addClass($control->getControlPrototype()->type);
            }
        }
    }

}
