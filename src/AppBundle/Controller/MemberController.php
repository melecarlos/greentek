<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Member;
use AppBundle\Entity\Quotation;
use AppBundle\Entity\Email;
use AppBundle\Entity\Phone;
use AppBundle\Entity\Company;
use AppBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Member controller.
 *
 * @Route("/")
 */
class MemberController extends Controller
{

    /**
     * Creates a new member entity.
     *
     * @Route("/", name="member_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();
        $member = new Member();
        if(count($member->getQuotations())==0){
            $quotation = new Quotation();
            $quotation->setKwh(null);
            $quotation->setPercentage(null);
            $quotation->setKwp(null);
            $member->getQuotations()->add($quotation);
        }
        if(count($member->getEmails())==0){
            $email = new Email();
            $email->setEmail('');
            $member->getEmails()->add($email);
        }
        if(count($member->getPhones())==0){
            $phone = new Phone();
            $phone->setPhone('');
            $member->getPhones()->add($phone);
        }
        if(count($member->getCompanies())==0){
            $company = new Company();
            $company->setName('');
            $member->getCompanies()->add($company);
        }
        if(count($member->getMessages())==0){
            $message = new Message();
            $message->setMessage('');
            $member->getMessages()->add($message);
        }
        $member->setStatus('quotation');
        $form = $this->createForm('AppBundle\Form\MemberType', $member);
        $form->handleRequest($request);
        $validator = $this->get('validator');
        $errors = $validator->validate($member);
        if ($form->isSubmitted() && $form->isValid() && count($errors)<=0) {
            if($member->getMessages()[0]->getMessage()==null){ //Eliminar objeto de mensajes si es nulo
                $member->clearMessages();
            }
            $member->setIp($this->container->get('request_stack')->getCurrentRequest()->getClientIp());
            foreach($member->getQuotations() as $q){
                $kwp = $q->getKwp();
            }
            foreach($member->getEmails() as $e){
                $email = $e->getEmail();
            }
            foreach($member->getCompanies() as $c){
                if($c->getName()==null){
                    $member->clearCompanies();
                }
            }
            $forename = $member->getForename();
            $lastname = $member->getLastname();
            $em->persist($member);
            $em->flush();
            //Enviar correos
            $message = (new \Swift_Message('[Greentek] Cotización Sistema Fotovoltaico'))
                ->setFrom('cotiza@greentekca.com')
                ->setTo($email)
                //->attach(\Swift_Attachment::fromPath($urlQuotation))
                ->setBody($this->renderView('quotation/email.html.twig',array('forename'=>$forename, 'lastname'=>$lastname, 'kwp'=>$kwp)),'text/html');
            $mailer->send($message);
            return $this->redirectToRoute('member_show', array('id' => $member->getId()));
        }
        return $this->render('member/new.html.twig', array(
            'member' => $member,
            'form'   => $form->createView(),
            'errors' => $errors
        ));
    }

    /**
     * Funcion ajax que calcula la potencia en base al consumo y ahorro
     * @Route("/calculopotencia", name="member_calculo_potencia")
     */
    public function saveReactionDestinationAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();
        if($isAjax){
            $kwh         = $request->request->get('kwh');
            $percentage  = $request->request->get('percentage');
            if($kwh>=0 and $percentage!=null) {
                $percent = $percentage / 100;
                $celdasOcultas = $kwh * $percent;
                $kwp = round(($celdasOcultas * 12) / 1500, 1); // Presición 1 decimal

                if ($kwp >= 0 and $kwp < 1.5) { // Aproximar a la potencia mayor 1.5
                    $kwp = 1.5;
                } elseif ($kwp >= 1.5 and $kwp <= 1.9) { // Aproximar a la potencia menor 1.5
                    $kwp = 1.5;
                } elseif ($kwp >= 2.0 and $kwp <= 2.9) { // Aproximar a la potencia menor 2.0
                    $kwp = 2.0;
                } elseif ($kwp >= 3.0 and $kwp <= 3.9) { // Aproximar a la potencia menor 3.0
                    $kwp = 3.0;
                } elseif ($kwp >= 4.0 and $kwp <= 4.9) { // Aproximar a la potencia menor 4.0
                    $kwp = 4.0;
                } elseif ($kwp >= 5.0 and $kwp <= 5.9) { // Aproximar a la potencia menor 5.0
                    $kwp = 5.0;
                } elseif ($kwp >= 6.0 and $kwp <= 6.9) { // Aproximar a la potencia menor 6.0
                    $kwp = 6.0;
                } elseif ($kwp >= 7.0 and $kwp <= 7.9) { // Aproximar a la potencia menor 7.0
                    $kwp = 7.0;
                } elseif ($kwp >= 8.0 and $kwp <= 8.9) { // Aproximar a la potencia menor 8.0
                    $kwp = 8.0;
                } elseif ($kwp >= 9.0 and $kwp <= 9.9) { // Aproximar a la potencia menor 9.0
                    $kwp = 9.0;
                } elseif ($kwp >= 10.0 and $kwp <= 11.9) { // Aproximar a la potencia menor 10.0
                    $kwp = 10.0;
                } elseif ($kwp >= 12.0 and $kwp <= 17.9) { // Aproximar a la potencia menor 12.0
                    $kwp = 12.0;
                } elseif ($kwp >= 18.0 and $kwp <= 19.9) { // Aproximar a la potencia menor 18.0
                    $kwp = 18.0;
                } elseif ($kwp >= 20.0 and $kwp <= 32.9) { // Aproximar a la potencia menor 20.0
                    $kwp = 20.0;
                } elseif ($kwp >= 33.0 and $kwp <= 35.9) { // Aproximar a la potencia menor 33.0
                    $kwp = 33.0;
                } elseif ($kwp >= 36.0 and $kwp <= 39.9) { // Aproximar a la potencia menor 36.0
                    $kwp = 36.0;
                } elseif ($kwp >= 40.0) { // Aproximar a la potencia menor 40.0
                    $kwp = 40.0;
                }
                if($kwp>0){
                    $status = 'success';
                }else{
                    $status = 'error';
                }
                $array = array('status'=>$status, 'result'=>$kwp);
                $response = new JsonResponse();
                return $response->setData($array);
            }
        }
        return new Response('');
    }

    /**
     * Lists all member entities.
     *
     * @Route("/index", name="member_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $members = $em->getRepository('AppBundle:Member')->findAll();

        return $this->render('member/index.html.twig', array(
            'members' => $members,
        ));
    }

    /**
     * Finds and displays a member entity.
     *
     * @Route("/show/{id}", name="member_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        //$deleteForm = $this->createDeleteForm($member);

        return $this->render('member/show.html.twig', array(
           // 'member' => $member,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/usuario/registro", name="usuario_registro")
     * @Method({"GET", "POST"})
     */
    public function registerUserAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Member();
        $user->setStatus('active');
        $user->setIp($this->container->get('request_stack')->getCurrentRequest()->getClientIp());
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);
        //validation
        $validator = $this->get('validator');
        $errors = $validator->validate($user);
        if($form->isSubmitted() && $form->isValid() && count($errors)==0){
            $login    = $user->getLogin();
            $password = $passwordEncoder->encodePassword($login, $login->getPassword());
            $login->setPassword($password);
            $login->setIp($this->container->get('request_stack')->getCurrentRequest()->getClientIp());
            $em         = $this->getDoctrine()->getManager();
            $role       = $em->getRepository('AppBundle:Roles')->findOneBy(array('name'=>'ROLE_ADMIN'));
            if($role){
                $login->addRole($role);
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('usuario_show', array('id' => $user->getId()));
        }
        return $this->render('member/newUser.html.twig', array(
            'user'    => $user,
            'form'    => $form->createView(),
            'errors'  => $errors,
        ));
    }

    /**
     * Finds and displays a member entity.
     *
     * @Route("/usuario/{id}", name="usuario_show")
     * @Method("GET")
     */
    public function showUserAction($id)
    {
        $em         = $this->getDoctrine()->getManager();
        $member     = $em->getRepository('AppBundle:Member')->find($id);
        return $this->render('member/showUser.html.twig', array(
            'member' => $member,
            //'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing member entity.
     *
     * @Route("/{id}/edit", name="member_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Member $member)
    {
        $deleteForm = $this->createDeleteForm($member);
        $editForm = $this->createForm('AppBundle\Form\MemberType', $member);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_edit', array('id' => $member->getId()));
        }

        return $this->render('member/edit.html.twig', array(
            'member' => $member,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }



}
