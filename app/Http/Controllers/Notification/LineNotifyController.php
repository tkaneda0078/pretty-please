<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class LineNotifyController extends Controller
{
    /**
     * HTTP Client
     *
     * @var object
     */
    protected $client;

    /**
     * Notify API
     *
     * @var string
     */
    protected $uri = 'https://notify-api.line.me/api/notify';

    /**
     * Content Type
     * Request header
     * 
     * @var string
     */
    protected $content_type = 'application/x-www-form-urlencoded';

    /**
     * Access Token
     *
     * @var string
     */
    protected $access_token;

    /**
     * Notify Message
     *
     * @var string
     */
    protected $message;
    
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Notify what you want by line service
     *
     * @return redirect top
     */
    public function notify()
    {
        $this->client->post($this->uri, [
            'headers' => [
                'Content-Type'  => $this->content_type,
                'Authorization' => 'Bearer <access_token>', // todo
            ],
            'form_params' => [
                'message' => $this->message // todo
            ]
        ]);

        return redirect('/');
    }
}
