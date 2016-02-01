<?php

namespace App\Model;

/**
 * Description of GitHub
 *
 * @author František Blachowicz <f.blach@owi.cz>
 *         Created on 26.4.2015
 * 
 */
class GitHub {
    
    const PATH = 'https://github.com/';
    protected $account;
    protected $repository;
    protected $branch;


    public function __construct($account, $repository, $branch) {
        $this->account = $account;
        $this->repository = $repository;
        $this->branch = $branch;
    }
    
    public function getRawContent($filename) {
        $url = sprintf(
                '%s%s/%s/raw/%s/%s',
                GitHub::PATH,
                $this->account,
                $this->repository,
                $this->branch,
                $filename
        );
        return file_get_contents(
            $url,
            false,
            stream_context_create(
                array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                )
            )
        );
    }
}
