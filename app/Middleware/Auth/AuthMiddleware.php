<?php

declare(strict_types=1);

namespace App\Middleware\Auth;

use App\Constants\ErrorCode;
use App\Exception\BusinessException;
use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Hyperf\HttpServer\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */

    protected $response;

    /**
     * @var string
     */
    protected $header = 'Authorization';

    /**
     * @var string
     */
    protected $pattern = '/^Bearer\s+(.*?)$/';

    /**
     * @var string
     */
    protected $realm = 'api';

    /**
     * @var string
     */
    public static $authToken = '';

    /**
     * AuthMiddleware constructor.
     * @param ContainerInterface $container
     * @param HttpResponse $response
     * @param RequestInterface $request
     */
    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
        $this->challenge();
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $header = $request->getHeader($this->header);
        $isValidToken = $this->authenticate($header);
        if (!$isValidToken) {
            throw new BusinessException(ErrorCode::UNAUTHORIZED, 'token验证失败');
        }
        return $handler->handle($request);
    }

    /**
     * setHeader
     */
    public function challenge()
    {
        $this->response->withHeader('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }

    /**
     * 验证token
     * @param $header
     * @return bool|null
     */
    public function authenticate($header)
    {
        if (!empty($header) && $header[0] !== null) {
            if ($this->pattern !== null) {
                if (preg_match($this->pattern, $header[0], $matches)) {
                    self::$authToken = $matches[1];

                } else {
                    return null;
                }
            }
            return true;
        }
        return null;
    }
}