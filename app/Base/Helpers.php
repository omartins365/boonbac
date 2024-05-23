<?php
use App\Base\ApiResponse;
use App\Models\User;

if (! function_exists('percentageOf'))
{
    /**
     * calculate the percentage Of number
     *
     * @param numeric $percentage
     * @param numeric $number
     * @return float|int
     */
    function percentageOf($percentage, $number)
    {
        return ($percentage / 100) * $number;
    }
}


if (! function_exists('ApiSuccess'))
{

    function apiSuccess(object|array $body = null, string $message = "Success", int $code = 200, string $status = null)
    {
        $status = $status ?? ApiStatus::Success->value;
        return ApiResponse::success($message, $code)->setBody($body)->setStatus(str($status)->title()->headline())->getResponse();
    }
}
if (! function_exists('ApiResponse'))
{

    function apiResponse(string $message = "Success", int $code = 200)
    {
        return ApiResponse::success($message, $code)->getResponse();
    }
}

if (! function_exists('ApiError'))
{

    function apiError(string $message = "Something went wrong", int $code = 400, array|object $errors = null)
    {
        return ApiResponse::error($message, $code, $errors)->getResponse();
    }
}

if (! function_exists('negativeOf'))
{
    function negativeOf(float $amount) : float
    {
        return $amount * -1;
    }
}


if (! function_exists('addMessage'))
{
    function addMessage($msg, BSAlert $alert_temp = null, string $heading = null)
    {
        \App\Base\Core::add_message($msg, $alert_temp->value, $heading);
    }

    if (! function_exists('alertInfo'))
    {

        function alertInfo(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::INFO, $heading ?? ucfirst(strtolower(BSAlert::INFO->name)));
        }

    }
    if (! function_exists('alertPrimary'))
    {

        function alertPrimary(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::PRIMARY, $heading ?? ucfirst(strtolower(BSAlert::PRIMARY->name)));
        }

    }
    if (! function_exists('alertWarning'))
    {

        function alertWarning(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::WARNING, $heading ?? ucfirst(strtolower(BSAlert::WARNING->name)));
        }

    }
    if (! function_exists('alertLight'))
    {

        function alertLight(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::LIGHT, $heading ?? ucfirst(strtolower(BSAlert::LIGHT->name)));
        }

    }
    if (! function_exists('alertDark'))
    {

        function alertDark(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::DARK, $heading ?? ucfirst(strtolower(BSAlert::DARK->name)));
        }

    }
    if (! function_exists('alertSecondary'))
    {

        function alertSecondary(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::SECONDARY, $heading ?? ucfirst(strtolower(BSAlert::SECONDARY->name)));
        }

    }
    if (! function_exists('alertDanger'))
    {

        function alertDanger(string $msg, string $heading = "Error")
        {
            return addMessage($msg, BSAlert::DANGER, $heading ?? ucfirst(strtolower(BSAlert::DANGER->name)));
        }

    }
    if (! function_exists('alertSuccess'))
    {

        function alertSuccess(string $msg, string $heading = null)
        {
            return addMessage($msg, BSAlert::SUCCESS, $heading ?? ucfirst(strtolower(BSAlert::SUCCESS->name)));
        }

    }


}
