<?php

namespace App\Http\Controllers\Pages\Transactions\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PaymentServiceInterface;
class DownloadAgreementController extends Controller
{
    private $agreement;
    public function __construct(PaymentServiceInterface $agreement)
    {
        $this->agreement = $agreement;
    }

    public function download($soa_id,$reference)
    {
        return $this->agreement->download_agreement($soa_id,$reference);
    }
}
