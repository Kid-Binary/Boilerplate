<?php
// AppBundle/Controller/Website/CommonWebsiteController.php
namespace AppBundle\Controller\Website;

use Symfony\Component\HttpFoundation\Response,
    Symfony\Bundle\FrameworkBundle\Controller\Controller;

use JMS\DiExtraBundle\Annotation as DI;

use AppBundle\Entity\Website\Contact\Contact;

class CommonWebsiteController extends Controller
{
    /** @DI\Inject("doctrine.orm.entity_manager") */
    private $_manager;

    /** @DI\Inject("app.common.messages") */
    private $_messages;

    public function headerAction()
    {
        $contacts = $this->_manager->getRepository('AppBundle:Website\Contact\Contact')->findBy([
            'alias' => ['support_center', 'support_center_mts', 'support_center_kyivstar', 'support_center_life']
        ]);

        if( !$contacts )
            throw $this->createNotFoundException();

        return $this->render('AppBundle:Website/Common:header.html.twig', [
            'contacts' => Contact::headerize($contacts)
        ]);
    }

    public function preFooterAction()
    {
        $contacts = $this->_manager->getRepository('AppBundle:Website\Contact\Contact')->findBy([
            'alias' => ['support_center', 'support_center_mts', 'support_center_kyivstar', 'support_center_life']
        ]);

        if( !$contacts )
            throw $this->createNotFoundException();

        return $this->render('AppBundle:Website/Common:preFooter.html.twig', [
            'contacts' => Contact::headerize($contacts)
        ]);
    }

    public function footerAction()
    {
        return $this->render('AppBundle:Website/Common:footer.html.twig');
    }

    public function messagesAction()
    {
        $messages = $this->_messages->getMessages();

        if( !$messages )
            new Response;

        return $this->render('AppBundle:Website/Common:messages.html.twig', [
            'messages' => $messages
        ]);
    }
}