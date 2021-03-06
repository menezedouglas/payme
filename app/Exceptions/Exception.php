<?php

namespace App\Exceptions;

use Exception as BasicException;

use App\Exceptions\Contracts\ExceptionInterface;

use Illuminate\Http\JsonResponse;

class Exception extends BasicException implements ExceptionInterface
{

    /**
     * Exception occurred
     *
     * @var BasicException
     */
    protected BasicException $exception;

    /**
     * Error message
     *
     * @var string
     */
    protected $message;

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected $code;

    /**
     * HTTP Status Messages
     *
     * @var string[]
     */
    protected array $httpStatusMessages = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing', // WebDAV; RFC 2518
        103 => 'Early Hints', // RFC 8297
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information', // since HTTP/1.1
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content', // RFC 7233
        207 => 'Multi-Status', // WebDAV; RFC 4918
        208 => 'Already Reported', // WebDAV; RFC 5842
        226 => 'IM Used', // RFC 3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // Previously "Moved temporarily"
        303 => 'See Other', // since HTTP/1.1
        304 => 'Not Modified', // RFC 7232
        305 => 'Use Proxy', // since HTTP/1.1
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect', // since HTTP/1.1
        308 => 'Permanent Redirect', // RFC 7538
        400 => 'Bad Request',
        401 => 'Unauthorized', // RFC 7235
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required', // RFC 7235
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed', // RFC 7232
        413 => 'Payload Too Large', // RFC 7231
        414 => 'URI Too Long', // RFC 7231
        415 => 'Unsupported Media Type', // RFC 7231
        416 => 'Range Not Satisfiable', // RFC 7233
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot', // RFC 2324, RFC 7168
        421 => 'Misdirected Request', // RFC 7540
        422 => 'Unprocessable Entity', // WebDAV; RFC 4918
        423 => 'Locked', // WebDAV; RFC 4918
        424 => 'Failed Dependency', // WebDAV; RFC 4918
        425 => 'Too Early', // RFC 8470
        426 => 'Upgrade Required',
        428 => 'Precondition Required', // RFC 6585
        429 => 'Too Many Requests', // RFC 6585
        431 => 'Request Header Fields Too Large', // RFC 6585
        451 => 'Unavailable For Legal Reasons', // RFC 7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates', // RFC 2295
        507 => 'Insufficient Storage', // WebDAV; RFC 4918
        508 => 'Loop Detected', // WebDAV; RFC 5842
        510 => 'Not Extended', // RFC 2774
        511 => 'Network Authentication Required', // RFC 6585
    ];

    /**
     * Constructor method
     *
     * @param BasicException|null $exception
     * @param string|null $message
     * @param int|null $code
     */
    public function __construct(
        ?BasicException $exception = null,
        ?string $message = null,
        ?int $code = null
    ) {

        if ($exception) {
            $this->exception = $exception;

            if (!method_exists($this->exception, 'getStatusCode')) {
                if (array_key_exists($this->exception->getCode(), $this->httpStatusMessages)) {
                    $this->code = $this->exception->getCode();
                    $this->message = $this->exception->getMessage();
                } else {
                    $this->message = $this->message ?? $this->httpStatusMessages[$this->code];
                }
            } else {
                $this->code = $this->exception->getStatusCode();
                $this->message = $this->exception->getMessage();
            }
        } else if ($message || $code) {
            $this->message = $message ?? $this->message;
            $this->code = $code ?? $this->code;
        }

        parent::__construct($this->message, $this->code);
    }


    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report(): ?bool
    {
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        $response =  [
            'message' => $this->code === 422 ? json_decode($this->message) : $this->message,
            'code' => $this->code
        ];

        if (strtolower(env('APP_ENV')) === 'testing')
            $response['exception'] = $this->exception;

        return response()->json($response, $this->code);
    }
}
