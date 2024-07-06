<?php

namespace App\Http\Controllers;

/**
 * Class BaseResponse
 * @template DataType
 * @package App\Http\Controllers
 */
class BaseResponse
{
    public int $status;
    public bool $success = true;
    public bool $showMessage = false;
    public string | null $message = null;
    /** @var DataType | null $data */
    public mixed $data = null;
}
