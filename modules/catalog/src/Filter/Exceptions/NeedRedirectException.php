<?php

namespace WezomCms\Catalog\Filter\Exceptions;

class NeedRedirectException extends \Exception
{
    private $url;

    /**
     * @param $url
     * @return NeedRedirectException
     */
    public function setUrl($url): NeedRedirectException
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
}
