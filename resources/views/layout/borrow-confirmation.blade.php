<div class="modal fade" tabindex="-1" id="borrow_confirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Loan Details</h3>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body p-6">

                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Client Name</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientUniqueID"></span></span>
                    </div>
                </div>

                <div class="separator separator-dashed my-3"></div>

                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Rate</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientRate"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>

                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Tenurity</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientTenurity"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Disbursement Date</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientDisbursementDate"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Amount</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientAmount"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Interest</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientInterest"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Loan Outstanding</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientOutstanding"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Monthly</div>
                    <div class="d-flex align-items-senter">
                        <span class="text-gray-900 fw-bolder fs-6"><span id="displayClientMonthly"></span></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light text-uppercase fs-8 fw-bolder" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-light-success text-uppercase fs-8 fw-bolder" id="btn-borrow-confirmation">Confirm</button>
            </div>
        </div>
    </div>
</div>
