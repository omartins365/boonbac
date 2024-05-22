<?php

namespace App\Base;

use ApiStatus;
use Illuminate\Http\Response;

class ApiResponse
{
    protected $status = null;
    protected $body_name = "data";
    protected array|object|null $body = null;
    protected $message = "";
    protected $code = null;

    private object $response;

    static function build()
    {
        return new ApiResponse();
    }

    public function __toString()
    {
        return json_encode($this->getResponse());
    }

    static function success($message = "Success", $code = 200)
    {
        return ApiResponse::build()
            ->setStatus(ApiStatus::Success)
            ->setMessage($message)
            ->setCode($code);
    }
    static function failure($message = "Something went wrong, check your inputs and try again", $code = 400)
    {
        return self::error($message, $code);
    }
    static function error($message = "Server Error", $code = 500,array|object $errors = null)
    {
        return ApiResponse::build()
            ->setStatus(ApiStatus::Error)
            ->setMessage($message)
            ->setCode(empty($code)? 500 : $code)
            ->setBodyName("error")
            ->setBody($errors);
    }

    private function build_response()
    {
        $this->response = (object) [];
        $this->response->status = $this->status;
        $this->response->code = $this->code;
        if (!empty($this->message)) {
            $this->response->message = $this->message;
        }
        if (!empty($this->body)) {
            if (is_countable($this->body)) {
                $this->response->count = count($this->body);
            }
            $this->response->{$this->body_name} = $this->body;
        }
        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(ApiStatus|string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of body_name
     */
    protected function getBodyName()
    {
        return $this->body_name;
    }

    /**
     * Set the value of body_name
     */
    protected function setBodyName(?string $body_name): self
    {
        if ($body_name) {
            $this->body_name = $body_name;
        }
        return $this;
    }

    /**
     * Get the value of body
     *
     * @return array|object
     */
    public function getBody(): array|object
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @param array|object $body
     *
     * @return self
     */
    public function setBody(array|object $body = null): self
    {

        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     */
    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * Set the value of code
     */
    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }


    public function getResponse()
    {
        return response((array)$this->build_response()->response, $this->code);
    }
}
