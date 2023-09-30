<?php

namespace App\Service;

interface ResponseApiInterface
{
    public function message(string $message);

    public function data($data);

    public function info(string $info);

    public function toArray(): array;

    public function json();

    public function error(string $error);

    public function getError();

    public function getMessage();

    public function getData();

    public function getInfo();

    public function getStatus();

    public function setStatus($status);

    public static function statusFatalError(): ResponseApiInterface;

    public static function statusValidateError(): ResponseApiInterface;

    public static function statusQueryError(): ResponseApiInterface;

    public static function statusUniversalError(): ResponseApiInterface;

    public static function statusSuccessCreated(): ResponseApiInterface;

    public static function statusSuccess(): ResponseApiInterface;

    public static function statusDefault(): ResponseApiInterface;
}
