<?php

namespace Webkul\SAASSubscription\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\SAASSubscription\Http\Controllers\Controller;
use Webkul\SAASSubscription\Repositories\InvoiceRepository;
use Webkul\SAASCustomizer\Facades\Company;

class InvoiceController extends Controller
{
    /**
     * InvoiceRepository object
     *
     * @var \Webkul\SAASSubscription\Repositories\InvoiceRepository
     */
    protected $invoiceRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\SAASSubscription\Repositories\InvoiceRepository  $invoiceRepository
     * @return void
     */
    public function __construct(InvoiceRepository $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $invoices = $this->invoiceRepository->findByField([
            'company_id' => Company::getCurrent()->id
        ]);

        return view($this->_config['view'], compact('invoices'));
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        return view($this->_config['view'], compact('invoice'));
    }
}