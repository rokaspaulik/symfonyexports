<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Employee;
use AppBundle\Service\ExcelGenerator;
use AppBundle\Service\PdfService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExcelController extends Controller
{
    /**
     * @Route("/", name="table")
     */
    public function tableViewAction(){
        $employees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        return $this->render('default/index.html.twig', array(
            'employees' => $employees
        ));
    }

    /**
     * @Route("/excel")
     * @param ExcelGenerator $excelGenerator
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function excelGetAction(ExcelGenerator $excelGenerator){
        $employees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $excelGenerator->getDoc($employees);
        return $this->file('employees.xlsx', 'darbuotojai.xlsx', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/pdf")
     * @param PdfService $pdfService
     */
    public function pdfGetAction(PdfService $pdfService){
        $employees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        $pdf = $this->container->get("white_october.tcpdf")->create('vertical', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdfService->generateTable($pdf, $employees);
    }

    /**
     * @Route("/add")
     */
    public function employeeAddNewAction(Request $request){

        $employee = new Employee();

        $form = $this->createFormBuilder($employee)
            ->add('fname', TextType::class)
            ->add('lname', TextType::class)
            ->add('email', EmailType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $fname = $form['fname']->getData();
            $lname = $form['lname']->getData();
            $email = $form['email']->getData();

            $employee->setFname($fname);
            $employee->setLname($lname);
            $employee->setEmail($email);

            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('table');
        }

        return $this->render('default/form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}