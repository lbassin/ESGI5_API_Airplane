<?php

declare(strict_types=1);

namespace App\Controller\Ticket;

use App\Entity\Ticket;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Twig\Environment as Twig;

class Pdf
{
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke(Ticket $data)
    {
        $html = $this->twig->render('ticket/pdf.html.twig', [
            'ticket' => $data,
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        $response = new Response($mpdf->Output('', 'S'));

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'ticket.pdf'
        );

        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
