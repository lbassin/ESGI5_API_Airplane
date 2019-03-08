<?php

declare(strict_types=1);

namespace App\Controller\Ticket;

use App\Entity\Ticket;
use Dompdf\Dompdf;
use Dompdf\Options;
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
        $dompdf = new Dompdf(new Options(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]));
        $dompdf->setPaper('A4', 'portrait');

        $html = $this->twig->render('ticket/pdf.html.twig');

        $dompdf->loadHtml($html);

        $dompdf->render();

        $dompdf->stream('ticket.pdf');
    }
}
