<?php

class Response
{

    private $success;
    private $httpStatusCode;
    private $messages = array();
    private $data;
    private $toCache = false;
    private $responseData = array();






    public function setSuccess($success): self
    {
        $this->success = $success;
        return $this;
    }


    public function setHttpStatusCode($httpStatusCode): self
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }


    public function setData($data): self
    {
        $this->data = $data;
        return $this;
    }

    public function setToCache($toCache): self
    {
        $this->toCache = $toCache;
        return $this;
    }
    public function addMessage($messages)
    {
        $this->messages[] = $messages;
        return $this;
    }

    public function send()
    {

        header('Content-type:application/json; charset=utf-8');
        if ($this->toCache == true) {

            header('Cache-control:max-age=60');

        } else {
            header('Cache-control:no-cache,no-store');
        }

        if (($this->success !== false && $this->success !== true) || !is_numeric($this->httpStatusCode)) {
            http_response_code(500);
            $this->responseData['statusCode'] = 500;
            $this->responseData['success'] = false;
            $this->messages = array();
            $this->addMessage("Response creation error");
            $this->responseData['messages'] = $this->messages;

        } else {
            http_response_code($this->httpStatusCode);
            $this->responseData['statusCode'] = $this->httpStatusCode;
            $this->responseData['success'] = $this->success;
            $this->responseData['messages'] = $this->messages;
            $this->responseData['data'] = $this->data;

        }
        echo json_encode($this->responseData);
    }

}







?>