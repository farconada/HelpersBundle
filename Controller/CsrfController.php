<?php
/**
 * Created by PhpStorm.
 * User: fernando
 * Date: 30/06/15
 * Time: 9:24
 */

namespace Fer\HelpersBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use JMS\DiExtraBundle\Annotation as DI;

class CsrfController {

    /** @var \Symfony\Component\Security\Csrf\CsrfTokenManagerInterface $token_manager */
    protected $token_manager;


    /**
     * @DI\InjectParams({
     *  "token_manager" = @DI\Inject("security.csrf.token_manager")
     * })
     * @param $token_manager
     */
    function __construct($token_manager)
    {
        $this->token_manager = $token_manager;
    }

    /**
     * @Route(path="/csrf/{intention}")
     * @param $intention
     */
    public function generateAction($intention)
    {
        $token = $this->token_manager->getToken($intention);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(json_encode(["csrf" => $token->getValue(), "id" => $token->getId()]));
        return $response;
    }

}