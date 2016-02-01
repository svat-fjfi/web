<?php

namespace App\Presenters;

/**
 * TexyPresenter
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class TexyPresenter extends BasePresenter {
    
    /** @var \App\Model\GitHub @inject */
    public $github;

    public function handleDownload($id) {
        $filename = $this->database->table('file')->where(array('slug' => $id))->fetch()->path;

        $this->sendResponse(new \Nette\Application\Responses\FileResponse(WWW_DIR.$filename));
    }

    public function renderDefault($year) {
        $texy = new \Texy();
        $texy->allowed['phrase/sup'] = TRUE; // turns on ^^superscript^^
        $texy->allowed['phrase/sub'] = TRUE; // turns on __subscript__

        $this->template->setFile(__DIR__.'/../templates/Texy.default.latte');

        try{
            preg_match('#(\w+)Presenter$#', get_class($this), $m);
            $path = ($year ? $year.'/' : '').$m[1];
            $text = $this->github->getRawContent(
                $path
            );
            $text = $this->preprocess($text);
            $this->template->text = $texy->process($text);
        } catch(\Exception $e) {
            $this->template->text = $e;
        }

        $this->template->year = $year;

    }


    private function preprocess($text) {
        return preg_replace_callback(
            '/\[@(.*?)\]/',
            function ($matches) {
                $result = $this->database->table('file')->where(array('slug' => $matches[1], 'active' => 1))->fetch();
                return $result
                    ? "[".$this->link("download!", $result->slug)."]"
                    : "<span style='color:#aaa;'>nefunkční odkaz</span>"
                ;
            },
            $text
        );

    }


}
