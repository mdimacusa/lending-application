<div class="row p-0 justify-content-center">
    <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Today's Transaction</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="36899" data-kt-initialized="1">₱{{number_format($today_transaction,2)}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Overall Transaction</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="36899" data-kt-initialized="1">₱{{number_format($overall_transaction,2)}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Today's Income</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="72" data-kt-initialized="1">₱{{number_format($today_income,2)}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Overall Income</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="291" data-kt-initialized="1">₱{{number_format($overall_income,2)}}</span>
         </div>
     </div>
 </div>
 <div class="row p-0 justify-content-center">
    <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Company Fund</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="36899" data-kt-initialized="1">₱{{number_format($total_fund,2)}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Total Unpaid</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="291" data-kt-initialized="1">{{$total_unpaid}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Total Partially Paid</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="291" data-kt-initialized="1">{{$total_partially_paid}}</span>
         </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-12">
         <div class="card text-center min-w-125px rounded pt-4 pb-4 my-3">
             <span class="fs-4 fw-semibold text-gray-400 d-block">Total Paid</span>
             <span class="fs-2hx fw-bold text-gray-900 counted" data-kt-countup="true" data-kt-countup-value="291" data-kt-initialized="1">{{$total_paid}}</span>
         </div>
     </div>
 </div>
