@extends('layouts._landing_master')
@section('title', 'Knote - Loans')
@section('content')

{{--
<section class="business-loan-page">
   <div class="fullHeight banner-text-container">
      <div class="business-loan-page">
         <div class="banner-img">
            <div class="container">
               <div class="business-loan-banner-txt">
                  <h1><strong>Business loans to<br>
                     fund your 2020 vision</strong>
                  </h1>
                  <p>To get started, all you’ll need is: </p>
                  <ul class="what-we-need-apply">
                     <li><i class="fa fa-check" aria-hidden="true"></i> Active ABN or ACN</li>
                     <li><i class="fa fa-check" aria-hidden="true"></i> 6+ months in business</li>
                     <li><i class="fa fa-check" aria-hidden="true"></i> $5,000+ in monthly sales</li>
                  </ul>
                  <a href="{{ url('register/loan-applicant') }}" class="btn btn-success btn-lg border-0">
                  	Get started 
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<section id="business-loan-page-menu">
   <div class="container">
      <div class="d-flex flex-column flex-md-row align-items-center">
         <h5 class="my-0 border-right pr-3 mb-md-0 mr-2">
         	<a href="{{url('/')}}">
         		<img src="{{ asset('user/images/knote-logo-icon.png') }}" width="43" height="33" alt=""/>
         	</a>
         </h5>
         <nav id="nav-menu-business-loan" class="my-2 my-md-0 mr-md-3 mr-md-auto">
            <ul class="nav-menu sf-js-enabled sf-arrows" style="touch-action: pan-y;">
               <li class="menu-active"><a class="p-2" href="#built-for-you">Overview</a></li>
               <li><a class="p-2" href="#features">Features</a></li>
               <li><a class="p-2" href="#easy-to-apply">How to apply</a></li>
            </ul>
         </nav>
         <a href="{{ url('register/loan-applicant') }}">
         <button class="btn btn-success btn-lg border-0 mt-0" type="submit"> Get started </button>
         </a> 
      </div>
   </div>
</section>
<main id="main">
   <!--==========================
      built-for-you
      ============================-->
   <section id="built-for-you">
      <div class="container">
         <div class="section-header section-header mt-5">
            <h2>Built for you</h2>
            <div class="service-block mb-5">
               <p>You’re at the right place if you need a quick and easy solution to:</p>
            </div>
         </div>
         <div class="row service-block text-center">
            <div class="col-lg-3 mb-4 mb-lg-0">
               <div class="box wow fadeInLeft">
                  <div class="icon">
                     <svg width="120px" height="120px" id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 511.68">
                        <defs>
                           <style>
                              .cls-1{fill:#37baa0;}
                           </style>
                        </defs>
                        <title>money-flow</title>
                        <path class="cls-1" d="M117.09,439l-8.18-57.8a15,15,0,0,0-29.8,4.21l1.83,12.95a226.3,226.3,0,0,1-36.68-64.71c-61-166.77,86.32-335,258.07-298.33A15.05,15.05,0,1,0,308.61,5.9C114.67-35.48-53.56,153.84,16,344a256.15,256.15,0,0,0,41.47,73.21l-14.54-2.79A15,15,0,1,0,37.25,444l60.81,11.68c11,3.09,20.48-6.39,19-16.64Z" transform="translate(0 -0.16)"/>
                        <path class="cls-1" d="M496.32,168.15a256.36,256.36,0,0,0-41.46-73.21l14.54,2.8a15.05,15.05,0,0,0,5.68-29.56L414.25,56.5a15.09,15.09,0,0,0-19,16.64l8.18,57.8a15,15,0,1,0,29.8-4.21l-1.84-13a226.15,226.15,0,0,1,36.68,64.7c42.72,116.81-17.36,246.65-133.94,289.44A224,224,0,0,1,210,476.82a15.05,15.05,0,0,0-6.28,29.44,254.23,254.23,0,0,0,140.78-10.08c132.46-48.63,200.36-195.34,151.83-328Z" transform="translate(0 -0.16)"/>
                        <path class="cls-1" d="M412.15,256.87c0-86.15-70-156.25-156-156.25s-156,70.1-156,156.25,70,156.25,156,156.25S412.15,343,412.15,256.87Zm-281.88,0c0-69.56,56.47-126.15,125.89-126.15s125.89,56.59,125.89,126.15S325.58,383,256.16,383,130.27,326.43,130.27,256.87Z" transform="translate(0 -0.16)"/>
                        <path class="cls-1" d="M271.21,341.39V328.83c26.07,0,44.22-20.46,44.22-43.5A43.54,43.54,0,0,0,272,241.82H240.35a13.41,13.41,0,1,1,.21-26.81h30.28a20.23,20.23,0,0,1,14.43,6.57,15,15,0,0,0,22-20.56,50.44,50.44,0,0,0-36-16.1V172.35a15.05,15.05,0,1,0-30.1,0v12.56c-26.07,0-44.22,20.47-44.22,43.5a43.54,43.54,0,0,0,43.46,43.51H272a13.41,13.41,0,0,1,0,26.82H238.72a20.45,20.45,0,0,1-11.23-3.83,15,15,0,1,0-17.18,24.71c10.31,7.16,19.9,9.21,30.8,9.21v12.56a15,15,0,1,0,30.1,0Z" transform="translate(0 -0.16)"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Help with cash flow</strong></a></h4>
                  <div class="description">
                     <p>Keep the cash flowing and ensure your business continues to run smoothly.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
               <div class="box wow fadeInLeft">
                  <div class="icon ">
                     <svg width="120px" height="120px" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400.02 480">
                        <defs>
                           <style>
                              .cls-1{fill:#36bba1;}
                           </style>
                        </defs>
                        <title>pay-overheads</title>
                        <g id="Bill-2">
                           <path class="cls-1" d="M442.53,16.41a8,8,0,0,0-8.93,2.79L416,42.66,398.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L368,42.66,350.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L320,42.66,302.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L272,42.66,254.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L224,42.66,206.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L176,42.66,158.4,19.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L128,42.66,110.4,19.2A8,8,0,0,0,96,24V89.71a87.84,87.84,0,0,0,0,156.58V488a8,8,0,0,0,14.4,4.8L128,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L176,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L224,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L272,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L320,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L368,469.34l17.6,23.46a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L416,469.34l17.6,23.46A8,8,0,0,0,448,488V24A8,8,0,0,0,442.53,16.41ZM64,168a72,72,0,1,1,72,72A72,72,0,0,1,64,168ZM432,464l-9.6-12.8a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L392,474.66,374.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L344,474.66,326.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L296,474.66,278.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L248,474.66,230.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L200,474.66,182.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L152,474.66,134.4,451.2a8.29,8.29,0,0,0-11.67-1.13,8.62,8.62,0,0,0-1.13,1.13L112,464V252.59a88,88,0,1,0,0-169.18V48l9.6,12.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L152,37.34,169.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L200,37.34,217.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L248,37.34,265.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L296,37.34,313.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L344,37.34,361.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L392,37.34,409.6,60.8a8.29,8.29,0,0,0,11.67,1.13,8.62,8.62,0,0,0,1.13-1.13L432,48Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M320,128h80v16H320Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M320,160h80v16H320Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M240,208H352v16H240Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,208h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M216,240H352v16H216Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,240h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M144,272H352v16H144Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,272h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M144,304H352v16H144Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,304h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M144,336H352v16H144Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,336h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M272,384h80v16H272Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M368,384h32v16H368Z" transform="translate(-47.98 -16)"/>
                           <path class="cls-1" d="M144,224V208a24,24,0,0,0,0-48H128a8,8,0,0,1,0-16h16a8,8,0,0,1,8,8h16a24,24,0,0,0-24-24V112H128v16a24,24,0,0,0,0,48h16a8,8,0,0,1,0,16H128a8,8,0,0,1-8-8H104a24,24,0,0,0,24,24v16Z" transform="translate(-47.98 -16)"/>
                        </g>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Pay overheads</strong></a></h4>
                  <div class="description">
                     <p>Whether it’s to pay utility bills or another business overhead, a business loan from Knote can help ease the pressure.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
               <div class="box wow fadeInRight" data-wow-delay="0.2s">
                  <div class="icon">
                     <svg width="120px" height="120px" id="Layer_2" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 104.28 104.28">
                        <defs>
                           <style>
                              .cls-1{fill:#39b9a0;}
                           </style>
                        </defs>
                        <title>repay-debt</title>
                        <path class="cls-1" d="M80.87,53H91.64a5.05,5.05,0,0,0,5-5V31.44l12.44-16.92a5.25,5.25,0,0,0,1-3.1v-.3a5.27,5.27,0,0,0-9-3.76l-4.5,4.41V10.9a5.05,5.05,0,0,0-5-5H24.36a5.05,5.05,0,0,0-5.05,5v.87l-4.5-4.41a5.27,5.27,0,0,0-8.95,3.76v.3a5.3,5.3,0,0,0,1,3.11L19.31,31.45V47.91a5.05,5.05,0,0,0,5.05,5H35.13L43.27,64,32.16,74.89A18.52,18.52,0,1,0,40,81.76l7.44-7.43L45,72l-7.13,7.13a18.61,18.61,0,0,0-2.74-2.43l10.11-9.89,2.95,4a1.73,1.73,0,0,0,1.23.68A1.71,1.71,0,0,0,50.78,71L58,63.74l18,18a18.6,18.6,0,1,0,7.82-6.87L72.73,64ZM24.36,106.78A15.14,15.14,0,1,1,39.5,91.64a15.15,15.15,0,0,1-15.14,15.14ZM70.3,61.65,61.41,53H76.69ZM91.64,49.59H58v0L33.91,26H93.32V47.91a1.68,1.68,0,0,1-1.68,1.68Zm1.68-26.91H30.47L23.59,16H93.32ZM103.55,9.76a1.86,1.86,0,0,1,1.33-.54,1.9,1.9,0,0,1,1.9,1.9v.3a1.89,1.89,0,0,1-.36,1.11L96.69,25.77v-9.3ZM24.36,9.22H91.64a1.68,1.68,0,0,1,1.68,1.68v1.69H22.68V10.9a1.68,1.68,0,0,1,1.68-1.68Zm0,40.37a1.68,1.68,0,0,1-1.68-1.68V36l10,13.57Zm82.42,42.05A15.14,15.14,0,1,1,91.64,76.5a15.15,15.15,0,0,1,15.14,15.14ZM78.09,79.08,59.19,60.17a1.7,1.7,0,0,0-2.38,0l-7,7L9.59,12.54a1.88,1.88,0,0,1-.37-1.12v-.3a1.9,1.9,0,0,1,1.9-1.9,1.86,1.86,0,0,1,1.33.54L80.83,76.65a18.61,18.61,0,0,0-2.74,2.43Zm0,0" transform="translate(-5.86 -5.86)"/>
                        <rect class="cls-1" x="43.73" y="48.78" width="3.36" height="3.36"/>
                        <path class="cls-1" d="M81.55,29.41a8.44,8.44,0,0,0-3.37.71,8.41,8.41,0,1,0-3.36,16.11,8.2,8.2,0,0,0,3.36-.72,8.28,8.28,0,0,0,3.37.72,8.41,8.41,0,0,0,0-16.82Zm-1.68,8.41a5,5,0,0,1-1.69,3.73,5,5,0,0,1,0-7.47,5,5,0,0,1,1.69,3.74Zm-10.1,0a5.06,5.06,0,0,1,5-5h0a8.26,8.26,0,0,0,0,10.09h0a5.05,5.05,0,0,1-5-5Zm11.78,5h0a8.26,8.26,0,0,0,0-10.09h0a5,5,0,0,1,0,10.09Zm0,0" transform="translate(-5.86 -5.86)"/>
                        <path class="cls-1" d="M24.36,79.87A11.77,11.77,0,1,0,36.13,91.64,11.78,11.78,0,0,0,24.36,79.87Zm0,20.18a8.41,8.41,0,1,1,8.41-8.41,8.42,8.42,0,0,1-8.41,8.41Zm0,0" transform="translate(-5.86 -5.86)"/>
                        <path class="cls-1" d="M91.64,103.41A11.77,11.77,0,1,0,79.87,91.64a11.78,11.78,0,0,0,11.77,11.77Zm0-20.18a8.41,8.41,0,1,1-8.41,8.41,8.42,8.42,0,0,1,8.41-8.41Zm0,0" transform="translate(-5.86 -5.86)"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>To repay debt</strong></a></h4>
                  <div class="description">
                     <p>Get on top of your debt and refinance it into manageable repayments to help your business continue to grow.</p>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 mb-4 mb-lg-0">
               <div class="box wow fadeInRight" data-wow-delay="0.2s">
                  <div class="icon">
                     <svg width="120px" height="120px" id="Layer_3" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 110 110">
                        <defs>
                           <style>
                              .cls-1{fill:#38bba1;}
                           </style>
                        </defs>
                        <title>Invest-in-growth</title>
                        <path class="cls-1" d="M106.08,24.36l-6.37-8.49L109.63,0h-6.75a5.62,5.62,0,0,0-4.44,2.38c-.77.88-1.08,1.17-1.77,1.17s-1-.29-1.77-1.17a5.33,5.33,0,0,0-8.88,0c-.77.88-1.08,1.17-1.77,1.17s-1-.29-1.76-1.17A5.62,5.62,0,0,0,78.05,0H71.3l9.92,15.88-6.36,8.48A19.64,19.64,0,0,0,71,36.07v1.18a19.52,19.52,0,0,0,39,0V36.07a19.68,19.68,0,0,0-3.9-11.71Zm-28-20.81c.69,0,1,.28,1.76,1.17a5.33,5.33,0,0,0,7.39,1.49,5.29,5.29,0,0,0,1.49-1.49c.77-.89,1.08-1.17,1.77-1.17s1,.28,1.77,1.17a5.33,5.33,0,0,0,7.39,1.49,5.29,5.29,0,0,0,1.49-1.49c.78-.89,1.08-1.17,1.77-1.17h.35L96.58,14.19H84.36L77.7,3.55Zm28.38,33.7a16,16,0,0,1-31.93,2.12,15,15,0,0,1,0-2.12V36.07a16.08,16.08,0,0,1,3.2-9.58l6.56-8.75H96.68l6.56,8.75a16.14,16.14,0,0,1,3.19,9.58Z" transform="translate(0.01 0.01)"/>
                        <path class="cls-1" d="M92.24,28.38A1.78,1.78,0,0,1,94,30.16h3.55a5.33,5.33,0,0,0-5.32-5.33V21.29H88.69v3.54H83.37v5.33a5.33,5.33,0,0,0,5.32,5.32h3.55A1.77,1.77,0,0,1,94,37.25V39h-5.3a1.78,1.78,0,0,1-1.77-1.78H83.37a5.32,5.32,0,0,0,5.32,5.32v3.55h3.55V42.57h5.32V37.25a5.32,5.32,0,0,0-5.32-5.32H88.69a1.77,1.77,0,0,1-1.77-1.77V28.38Z" transform="translate(0.01 0.01)"/>
                        <path class="cls-1" d="M26.61,42.57a16,16,0,1,0-16-16A16,16,0,0,0,26.61,42.57Zm0-28.38A12.42,12.42,0,1,1,14.19,26.61h0A12.43,12.43,0,0,1,26.61,14.19Z" transform="translate(0.01 0.01)"/>
                        <path class="cls-1" d="M26.61,35.48a8.87,8.87,0,1,0-8.87-8.87A8.87,8.87,0,0,0,26.61,35.48Zm0-14.19a5.32,5.32,0,1,1-5.32,5.32h0A5.32,5.32,0,0,1,26.61,21.29Z" transform="translate(0.01 0.01)"/>
                        <path class="cls-1" d="M99.34,67.41H89.73L85.15,72v23.8H81.6V74.5H72l-4.58,4.59v16.7H63.86V78.05h-9.6l-4.59,4.59V95.79H46.12V81.6h-9.6l-4.59,4.59v9.6H14.19v-.61L34.87,74.5H56.16l7.91-7.92,6.53,6.53,2.31-25.4L47.51,50,54,56.52l-3.76,3.76H29L14.19,75.11V49.17l2.72-1.65c.59.28,1.18.52,1.77.74l1.22,5H33.32l1.22-5c.59-.22,1.18-.46,1.76-.74l4.38,2.65,9.49-9.5L47.52,36.3c.28-.58.52-1.17.74-1.76l5-1.22V19.9l-5-1.22c-.22-.59-.46-1.18-.74-1.77l2.65-4.37-9.5-9.49L36.3,5.7c-.58-.28-1.17-.52-1.76-.74L33.32,0H19.9L18.68,5c-.59.22-1.18.46-1.77.74L12.54,3.05,3.05,12.54,5.7,16.91c-.28.59-.52,1.18-.75,1.77L0,19.9V110H110V95.79H99.34Zm-10.65,6L91.2,71h4.59v24.8h-7.1ZM71,80.56l2.51-2.51h4.59V95.79H71ZM53.22,84.11l2.5-2.51h4.59V95.79H53.22ZM35.48,87.65,38,85.15h4.58V95.79H35.48Zm-5-23.79H51.75l7.31-7.31-3.69-3.68L69,51.63,67.76,65.25l-3.68-3.68L54.69,71H33.4L14.19,90.16v-10ZM3.55,22.68l4.16-1,.3-.94a18.76,18.76,0,0,1,1.28-3.07l.46-.88L7.52,13.11l5.56-5.56,3.68,2.23.89-.46A19.16,19.16,0,0,1,20.7,8l1-.3,1-4.16h7.86l1,4.16,1,.3a18.66,18.66,0,0,1,3.06,1.28l.89.46,3.68-2.22,5.55,5.55-2.22,3.68.46.89a20,20,0,0,1,1.28,3.06l.3,1,4.16,1v7.86l-4.16,1-.3,1A20,20,0,0,1,44,35.61l-.46.89,2.22,3.68-5.61,5.51-3.67-2.22-.89.46a20,20,0,0,1-3.06,1.28l-1,.3-1,4.16H22.68l-1-4.16-.94-.3a20.14,20.14,0,0,1-3.07-1.29l-.88-.45-3.71,2.22L7.52,40.13l2.23-3.67-.46-.89A18.74,18.74,0,0,1,8,32.51l-.3-1-4.16-1ZM5,34.54c.22.59.46,1.18.74,1.76L3.55,39.85V34.19Zm101.47,64.8v7.09H3.55V41.18l7.09,7.09V99.34Z" transform="translate(0.01 0.01)"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Invest in growth</strong></a></h4>
                  <div class="description">
                     <p>Give your working capital a boost, and ensure you’ll always be able to seize opportunities.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- #built-for-you -->
   <section id="features" class="mt-0 mb-0 mt-lg-5 mb-lg-5">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6" style="background-image: url({{asset('user/images/features.jpg')}}); background-repeat: no-repeat; background-size: cover; background-position:bottom center;"></div>
            <div class="col-lg-6 feature-area">
               <div class="offset-lg-1">
                  <div class="section-header">
                     <h2>Features</h2>
                  </div>
                  <div class="d-flex mb-3">
                     <i class="fa fa-check" aria-hidden="true"></i>
                     <h4> No security assets needed </h4>
                  </div>
                  <div class="d-flex mb-3">
                     <i class="fa fa-check" aria-hidden="true"></i>
                     <h4> Access $5,000 – $500,000 </h4>
                  </div>
                  <div class="d-flex mb-3">
                     <i class="fa fa-check" aria-hidden="true"></i>
                     <div class="flex-fill">
                        <h4> 6 – 36 month loan terms </h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section id="easy-to-apply" class="simple-steps mb-lg-5">
      <div class="container">
         <div class="section-header section-header mt-5">
            <h2>Easy to apply. Simple Steps.</h2>
            <div class="service-block mb-5">
               <p>Apply for a business loan online in just ten minutes, by following these three easy steps:</p>
            </div>
         </div>
         <div class="row text-center">
            <div class="col-12 col-sm-4">
               <div class="box wow fadeInLeft steps">
                  <div class="steps-count">1</div>
                  <div class="icon">
                     <svg width="120px" height="120px" id="Layer_4" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 92.28 112.72">
                        <defs>
                           <style>
                              .cls-1{fill:#38bba1;}
                           </style>
                        </defs>
                        <title>get-started</title>
                        <path class="cls-1" d="M0,0V112.72H92.25V0Zm85.7,106.12H6.61V6.6H26.4V22.09H65.88V6.6H85.67ZM59.27,6.6v8.88H33V6.6Z" transform="translate(0.03)"/>
                        <rect class="cls-1" x="32.7" y="34.27" width="40.47" height="6.6"/>
                        <rect class="cls-1" x="19.16" y="34.27" width="6.94" height="6.6"/>
                        <rect class="cls-1" x="32.7" y="48.36" width="40.47" height="6.6"/>
                        <rect class="cls-1" x="19.16" y="48.36" width="6.94" height="6.6"/>
                        <rect class="cls-1" x="19.16" y="62.45" width="6.94" height="6.6"/>
                        <rect class="cls-1" x="32.7" y="62.45" width="40.47" height="6.6"/>
                        <rect class="cls-1" x="19.16" y="83.59" width="17.61" height="6.6"/>
                        <path class="cls-1" d="M55.53,86.92l-4.71-4.71-4.67,4.67,9.38,9.38L69.61,82.18,65,77.51Z" transform="translate(0.03)"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Get started</strong></a></h4>
                  <div class="description">
                     <p>Complete some basic business and personal information to get started.</p>
                  </div>
               </div>
            </div>
            <div class="col-12 col-sm-4">
               <div class="box wow fadeInCenter steps">
                  <div class="steps-count">2</div>
                  <div class="icon">
                     <svg width="120px" height="120px" id="Capa_2" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 178.57 178.58">
                        <defs>
                           <style>
                              .cls-1{fill:#38bba1;}
                           </style>
                        </defs>
                        <title>expert-will-help</title>
                        <path class="cls-1" d="M2.57,120.39a2.48,2.48,0,0,0,2.23,1.4,2.1,2.1,0,0,0,1.4-.28l67-41.6h31.54L96.36,104.2a2.66,2.66,0,0,0,.56,2.79,3.43,3.43,0,0,0,2.23,1.12h.28l10.89-1.68a2.86,2.86,0,0,0,2-1.11l16.47-25.13h6.7l-2.51,8.38h-8.1a2.79,2.79,0,1,0,0,5.58H131l-.55,2.51H122a2.8,2.8,0,0,0,0,5.59h6.7L127.9,105h-8.65a2.79,2.79,0,1,0,0,5.58h7l-.84,2.79h-53a3,3,0,0,0-1.95.84L13.45,164.77a3,3,0,0,0-.27,3.91,3,3,0,0,0,2,.84,3,3,0,0,0,1.95-.84l26.24-23.45a71.74,71.74,0,0,0,48,18.43,72.79,72.79,0,0,0,72.57-72.58,70.75,70.75,0,0,0-10-36.57l25.41-17a2.82,2.82,0,0,0-3.07-4.74L134.32,60.65l-.83.84L107.8,100.57l-5,.84L115.9,64a2.82,2.82,0,1,0-5.3-2l-3.91,12.28H83V68.47l38-28.19a2.79,2.79,0,1,0-3.35-4.47l-39.08,29a2.55,2.55,0,0,0-1.11,2.23v7.26h-5a12.33,12.33,0,0,0-1.39.28L3.4,116.48A2.8,2.8,0,0,0,2.57,120.39ZM83,119h36.29v5.59H83Zm55-53.87,11.45-7.54a67,67,0,0,1-101.61,84.3L73.47,119h3.91v8.38a2.63,2.63,0,0,0,2.79,2.79H122a2.63,2.63,0,0,0,2.79-2.79V119h2.79a3.36,3.36,0,0,0,2.8-1.95L141.58,78a2.83,2.83,0,0,0-.56-2.51,2.53,2.53,0,0,0-2.23-1.12h-6.7Z" transform="translate(-2.01 -1.82)"/>
                        <path class="cls-1" d="M133.49,28.55a2.52,2.52,0,0,0,2.23,1.12,3.9,3.9,0,0,0,1.67-.56l31-22.33a3,3,0,0,0,.56-3.91A3,3,0,0,0,165,2.31L134,24.64A3,3,0,0,0,133.49,28.55Z" transform="translate(-2.01 -1.82)"/>
                        <path class="cls-1" d="M53.37,35.25a2.14,2.14,0,0,0,1.4-.56A68.71,68.71,0,0,1,91.34,24.08a67.22,67.22,0,0,1,34.89,9.77,2.82,2.82,0,1,0,3.07-4.74,72.84,72.84,0,0,0-38-10.61A70.65,70.65,0,0,0,52,30.23a2.73,2.73,0,0,0-.84,3.9A3.43,3.43,0,0,0,53.37,35.25Z" transform="translate(-2.01 -1.82)"/>
                        <path class="cls-1" d="M43,40.55a2.7,2.7,0,0,0-3.9,0A72.59,72.59,0,0,0,18.76,91.08c0,2.79.28,5.86.56,8.65a3,3,0,0,0,2.79,2.52h.28a3.28,3.28,0,0,0,2.51-3.08,78.53,78.53,0,0,1-.56-8.09A67.59,67.59,0,0,1,43,44.46,2.7,2.7,0,0,0,43,40.55Z" transform="translate(-2.01 -1.82)"/>
                        <path class="cls-1" d="M2.85,179.57a2.51,2.51,0,0,0,1.95.84,2.51,2.51,0,0,0,2-.84l2.8-2.79a2.76,2.76,0,1,0-3.91-3.91l-2.79,2.79A2.7,2.7,0,0,0,2.85,179.57Z" transform="translate(-2.01 -1.82)"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Our expert will help</strong></a></h4>
                  <div class="description">
                     <p>Our experts will help you and support you.</p>
                  </div>
               </div>
            </div>
            <div class="col-12 col-sm-4">
               <div class="box wow fadeInRight steps">
                  <div class="steps-count">3</div>
                  <div class="icon">
                     <svg width="120px" height="120px" id="Layer_8" data-name="Layer_7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 116 116">
                        <defs>
                           <style>
                              .cls-1{fill:#38bba1;}
                           </style>
                        </defs>
                        <title>get-funds-fast</title>
                        <path class="cls-1" d="M56.07,52.2h3.86a1.94,1.94,0,1,1,0,3.87H52.2v3.86h3.87V63.8h3.86V59.93h0a5.8,5.8,0,0,0,0-11.6H56.07a1.93,1.93,0,1,1,0-3.86H63.8V40.6H59.93V36.73H56.07V40.6a5.8,5.8,0,1,0,0,11.6Zm0,0"/>
                        <path class="cls-1" d="M1.93,85.07h11.6a1.94,1.94,0,0,0,1.94-1.94h1.3a31.08,31.08,0,0,0,18,5.8h9.67v5.8a1.94,1.94,0,0,0-1.94,1.94v17.4A1.94,1.94,0,0,0,44.47,116H71.53a1.94,1.94,0,0,0,1.94-1.93V96.67a1.94,1.94,0,0,0-1.94-1.94H71a24.63,24.63,0,0,0,2-5.8H83.13a31.12,31.12,0,0,0,17.45-5.39,1.94,1.94,0,0,0,1.89,1.53h11.6A1.94,1.94,0,0,0,116,83.13V59.93A1.94,1.94,0,0,0,114.07,58h-11.6a1.94,1.94,0,0,0-1.94,1.93V63.8H99.07a21.63,21.63,0,0,0-14.36,5.42,7.72,7.72,0,0,0-3.51-4.38V44.47A19.35,19.35,0,0,0,67,25.82l.17-.26A14.74,14.74,0,0,0,69.6,17.4a1.93,1.93,0,0,0-1.93-1.93H48.33A1.93,1.93,0,0,0,46.4,17.4a14.74,14.74,0,0,0,2.47,8.16l.17.26A19.35,19.35,0,0,0,34.8,44.47v19.1a1.55,1.55,0,0,1-.86,1.4,5.42,5.42,0,0,0-2.59,2.77A21.63,21.63,0,0,0,18.86,63.8H15.47V59.93A1.94,1.94,0,0,0,13.53,58H1.93A1.94,1.94,0,0,0,0,59.93v23.2a1.94,1.94,0,0,0,1.93,1.94ZM104.4,61.87h7.73V81.2H104.4ZM69.6,112.13H46.4V98.6H69.6ZM48.33,94.73V77.33H61.86A15.05,15.05,0,0,0,58,87.43V89.7h3.87V87.43a11.19,11.19,0,0,1,3.3-8,1.92,1.92,0,0,0,.56-1.36V71.53a1.94,1.94,0,0,1,3.87,0V83.9a21,21,0,0,1-3,10.83ZM99.07,67.67h1.46v11.6a1.94,1.94,0,0,0-1.16.38,27.23,27.23,0,0,1-16.24,5.42H73.44c0-.39,0-.78,0-1.17l11.6-2.7V77.33h-10a1.78,1.78,0,0,1-1.59-1.93A2.08,2.08,0,0,1,74,74a1.45,1.45,0,0,1,1.06-.5h10a1.93,1.93,0,0,0,1.36-.57,17.75,17.75,0,0,1,12.64-5.23Zm-47-44.26a10.62,10.62,0,0,1-1.65-4.08H65.56a10.62,10.62,0,0,1-1.65,4.08l-1.16,1.75c-.29,0-.59,0-.88,0H54.13c-.29,0-.59,0-.88,0Zm-16.43,45a5.42,5.42,0,0,0,3-4.86V44.47A15.49,15.49,0,0,1,54.13,29h7.74A15.49,15.49,0,0,1,77.33,44.47V63.8H73.47v3.87h3.86a3.88,3.88,0,0,1,3.35,1.93H75.06a5.14,5.14,0,0,0-1.82.33,5.8,5.8,0,0,0-11.37,1.6v1.94H46.07A5.8,5.8,0,0,0,40.6,69.6H34.82a1.57,1.57,0,0,1,.84-1.17Zm-16.8-.76A17.72,17.72,0,0,1,31.5,72.9a1.94,1.94,0,0,0,1.37.57H40.6a1.93,1.93,0,0,1,0,3.86H30.93V81.2H44.47v3.87H34.8a27.26,27.26,0,0,1-16.24-5.42,1.92,1.92,0,0,0-1.16-.38H15.47V67.67Zm-15-5.8H11.6V81.2H3.87Zm0,0"/>
                        <rect class="cls-1" x="25.13" y="30.93" width="5.8" height="3.87"/>
                        <rect class="cls-1" x="85.07" y="30.93" width="5.8" height="3.87"/>
                        <path class="cls-1" d="M75.77,12.36l4.1-4.1L82.61,11l-4.1,4.11Zm0,0"/>
                        <rect class="cls-1" x="56.07" width="3.87" height="5.8"/>
                        <path class="cls-1" d="M33.39,11l2.74-2.73,4.1,4.1L37.49,15.1Zm0,0"/>
                     </svg>
                  </div>
                  <h4 class="title"><a href="#"><strong>Our expert will help</strong></a></h4>
                  <div class="description">
                     <p>Once approved, provide us with your preferred business bank account, and we’ll have the funds to you fast.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</main>
--}}

@endsection

