<?php

namespace App\Http\Controllers;

use App\Traits\FlashMessages;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use FlashMessages;

    protected $data = null;


    /**
     * @param $title
     * @param $subTitle
     */
    protected function setPageTitle($title, $subTitle)
    {
        view()->share(['pageTitle' => $title, 'subTitle' => $subTitle]);
    }

    protected function showErrorPage($errorCode = 404, $message = null): \Illuminate\Http\Response
    {
        $data['message'] = $message;
        return response()->view('errors.' . $errorCode, $data, $errorCode);
    }


    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null): JsonResponseAlias
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * @param        $route
     * @param        $message
     * @param string $type
     * @param false  $error
     * @param false  $withOldInputWhenError
     * @return RedirectResponse
     */
    protected function responseRedirect($route, $message, string $type = 'info', bool $error = false, bool
    $withOldInputWhenError = false): RedirectResponse
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();;

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        return redirect()->route($route);
    }


    protected function responseRedirectBack($message, $type = 'info'): \Illuminate\Http\RedirectResponse
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return redirect()->back();
    }
}
