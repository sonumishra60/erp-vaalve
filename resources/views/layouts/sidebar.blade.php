<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="{{ route('home')}}">
            <img alt="Logo" src="{{ URL::asset('assets/media/logos/vaalve-logo.png')}}" class="h-35px logo" />
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="black" />
                    <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="black" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true" data-kt-menu-expand="false">


                @if(session('userinfo')->role_type == 2 )
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Outer Rectangle for Data Storage -->
                                    <rect x="8" y="12" width="48" height="40" rx="6" ry="6" fill="none" stroke="currentColor" />

                                    <!-- Horizontal Lines Representing Data Rows -->
                                    <line x1="8" y1="20" x2="56" y2="20" />
                                    <line x1="8" y1="28" x2="56" y2="28" />
                                    <line x1="8" y1="36" x2="56" y2="36" />
                                    <line x1="8" y1="44" x2="56" y2="44" />

                                    <!-- Data Icons -->
                                    <circle cx="16" cy="16" r="4" fill="none" stroke="currentColor" />
                                    <circle cx="32" cy="16" r="4" fill="none" stroke="currentColor" />
                                    <circle cx="48" cy="16" r="4" fill="none" stroke="currentColor" />
                                </svg>

                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Master data</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <!-- <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.index')}}">
                                
                                <span class="menu-title">Add Master Data</span>
                            </a>
                        </div> -->

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('mastermenu.index')}}">

                                <span class="menu-title">Add Master Menu</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.series')}}">

                                <span class="menu-title">Add Series</span>
                            </a>
                        </div>

                    </div>
                </div>
                @endif

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Network Connections -->
                                    <circle cx="32" cy="32" r="8" fill="none" stroke="currentColor" />
                                    <line x1="32" y1="32" x2="48" y2="16" />
                                    <line x1="32" y1="32" x2="48" y2="48" />
                                    <line x1="32" y1="32" x2="16" y2="16" />
                                    <line x1="32" y1="32" x2="16" y2="48" />

                                    <!-- Outer Circles -->
                                    <circle cx="48" cy="16" r="4" fill="none" stroke="currentColor" />
                                    <circle cx="48" cy="48" r="4" fill="none" stroke="currentColor" />
                                    <circle cx="16" cy="16" r="4" fill="none" stroke="currentColor" />
                                    <circle cx="16" cy="48" r="4" fill="none" stroke="currentColor" />
                                </svg>

                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Primary Dis. Network</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('customer.distributorlist')}}">

                                <span class="menu-title">Distributors</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('customer.dealerlist')}}">

                                <span class="menu-title">Dealer</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('customer.retailerlist')}}">

                                <span class="menu-title">Retailers</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('customer.ubslist')}}">

                                <span class="menu-title">UBS</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('customer.ubslist')}}">

                                <span class="menu-title">TGWC</span>
                            </a>
                        </div>


                    </div>
                </div>
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Shopping Cart -->
                                        <path d="M5 10h4l1 6h32l1-6h4" />
                                        <circle cx="18" cy="50" r="5" />
                                        <circle cx="46" cy="50" r="5" />
                                        <path d="M5 10h1l1 6h32l1-6h1" />

                                        <!-- Plus Sign -->
                                        <line x1="32" y1="20" x2="32" y2="10" />
                                        <line x1="27" y1="15" x2="37" y2="15" />

                                        <!-- Order Icon Text or Symbol -->
                                        <text x="16" y="8" font-family="Arial" font-size="12" fill="black">Order</text>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Orders</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('order.list') }}">
                                <span class="menu-title">Primary Order</span>
                            </a>

                            <a class="menu-link" href="{{ route('order.listsecondary') }}">
                                <span class="menu-title">Secondary Order</span>
                            </a>

                            <a class="menu-link" href="{{ route('order.listsecondary') }}">
                                <span class="menu-title">TGWC Order</span>
                            </a>
                        </div>

                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Clipboard -->
                                        <rect x="16" y="8" width="32" height="48" rx="4" fill="none" />
                                        <rect x="20" y="4" width="24" height="8" rx="2" fill="none" />

                                        <!-- List items -->
                                        <line x1="24" y1="20" x2="44" y2="20" />
                                        <line x1="24" y1="28" x2="44" y2="28" />
                                        <line x1="24" y1="36" x2="44" y2="36" />
                                        <line x1="24" y1="44" x2="44" y2="44" />

                                        <!-- Checkmarks -->
                                        <polyline points="18,20 22,24 26,16" />
                                        <polyline points="18,28 22,32 26,24" />
                                        <polyline points="18,36 22,40 26,32" />
                                        <polyline points="18,44 22,48 26,40" />
                                    </svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Dispatch</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link " href="{{ route('pending.dispatch') }}">

                                <span class="menu-title">Pending Dispatch</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('complete.dispatch') }}">

                                <span class="menu-title">Complete Dispatch</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('pending.dispatch') }}">

                                <span class="menu-title">TGWC Pend. Dispatch</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('complete.dispatch') }}">

                                <span class="menu-title">TGWC Comp. Dispatch</span>
                            </a>
                        </div>

                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="32" cy="32" r="5" fill="currentColor" />
                                    <circle cx="32" cy="10" r="5" fill="currentColor" />
                                    <line x1="32" y1="15" x2="32" y2="27" />
                                    <circle cx="15" cy="50" r="5" fill="currentColor" />
                                    <line x1="15" y1="45" x2="29" y2="35" />
                                    <circle cx="49" cy="50" r="5" fill="currentColor" />
                                    <line x1="49" y1="45" x2="35" y2="35" />
                                </svg>

                            </span>
                        </span>
                        <span class="menu-title">Scheme</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('dop_mop.list')}}">
                                <span class="menu-title">DOP/MOP List</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('order.schemelist')}}">
                                <span class="menu-title"> Scheme List </span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('order.schemelist')}}">
                                <span class="menu-title"> TGWC Scheme List </span>
                            </a>
                        </div>


                    </div>
                </div>

                @if(session('userinfo')->role_type == 2 )
           
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com013.svg-->
                                <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100" height="100">
                                    <g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <!-- Document -->
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z" />
                                        <path d="M14 2v6h6" />

                                        <!-- Person Icon -->
                                        <circle cx="12" cy="13" r="3" />
                                        <path d="M12 16c-3 0-5 1.5-5 3v1h10v-1c0-1.5-2-3-5-3z" />

                                        <!-- Bar chart / Stats -->
                                        <path d="M8 9h2" />
                                        <path d="M8 12h4" />
                                        <path d="M8 15h6" />
                                    </g>
                                </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">HR Report</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('attendancereport.hr')}}">
                                <span class="menu-title">Attendance Report</span>
                            </a>

                            <a class="menu-link" href="{{ route('detailreport.hr') }}">
                                <span class="menu-title">Detail Report</span>
                            </a>
                        </div>

                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <!-- Vertical tally marks -->
                                    <line x1="10" y1="10" x2="10" y2="50" /> <!-- First tally -->
                                    <line x1="20" y1="10" x2="20" y2="50" /> <!-- Second tally -->
                                    <line x1="30" y1="10" x2="30" y2="50" /> <!-- Third tally -->
                                    <line x1="40" y1="10" x2="40" y2="50" /> <!-- Fourth tally -->
                                    <!-- Diagonal tally -->
                                    <line x1="10" y1="50" x2="45" y2="10" /> <!-- Fifth diagonal tally -->
                                </svg>

                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Tally</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.ledger')}}">
                                <span class="menu-title"> Ledger </span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.inventory')}}">
                                <span class="menu-title"> Inventory </span>
                            </a>
                        </div>

                    </div>
                </div>
                @endif
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    width="48px"
                                    height="48px">
                                    <!-- Document Background -->
                                    <path
                                        d="M19 2H8c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H8V4h11v16z" />
                                    <!-- Bar Chart -->
                                    <rect x="10" y="12" width="2" height="5" fill="currentColor" />
                                    <rect x="13" y="10" width="2" height="7" fill="currentColor" />
                                    <rect x="16" y="8" width="2" height="9" fill="currentColor" />
                                    <!-- Lines for Report -->
                                    <line
                                        x1="9"
                                        y1="6"
                                        x2="17"
                                        y2="6"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <line
                                        x1="9"
                                        y1="8"
                                        x2="14"
                                        y2="8"
                                        stroke="currentColor"
                                        stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>

                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">DSR</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('attendance.index')}}">
                                <span class="menu-title"> Attendance </span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link " href="{{ route('dsr.index') }}">
                                <span class="menu-title">Existing Client</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('dsr.newindex') }}">

                                <span class="menu-title">New client</span>
                            </a>
                        </div>

                    </div>
                </div>

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                    <ellipse cx="32" cy="16" rx="20" ry="8" fill="none" />
                                    <rect x="12" y="16" width="40" height="32" rx="4" />
                                    <line x1="12" y1="24" x2="52" y2="24" />
                                    <ellipse cx="32" cy="48" rx="20" ry="8" fill="none" />
                                    <circle cx="12" cy="48" r="4" fill="currentColor" />
                                    <circle cx="52" cy="48" r="4" fill="currentColor" />
                                    <line x1="12" y1="48" x2="20" y2="48" />
                                    <line x1="52" y1="48" x2="44" y2="48" />
                                </svg>


                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">Master</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('product.list')}}">
                                <span class="menu-title">Product List</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-title">TGWC Product List</span>
                            </a>
                        </div>


                        @if(session('userinfo')->role_type == 2 )
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('user.list')}}">
                                <span class="menu-title">User List</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('user.targetlist')}}">
                                <span class="menu-title"> Target List </span>
                            </a>
                        </div>


                        @endif

                    </div>
                </div>


                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen009.svg-->
                            <span class="svg-icon svg-icon-2">
                                <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Warehouse Box -->
                                    <path d="M3 9L12 3L21 9V21H3V9Z" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9 22V12H15V22" stroke="#1976D2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    
                                    <!-- Checklist -->
                                    <rect x="4" y="12" width="6" height="8" fill="#1976D2"/>
                                    <path d="M6 14H8" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                    <path d="M6 16H8" stroke="white" stroke-width="1.5" stroke-linecap="round"/>

                                    <!-- Cogwheel (Management) -->
                                    <circle cx="18" cy="16" r="3" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M18 11V13" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M18 19V21" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M15 16H13" stroke="#1976D2" stroke-width="2"/>
                                    <path d="M23 16H21" stroke="#1976D2" stroke-width="2"/>
                                    
                                    <!-- IMS Label -->
                                    <text x="50%" y="95%" fill="#1976D2" font-size="5" font-family="Arial, sans-serif" font-weight="bold" 
                                        text-anchor="middle" alignment-baseline="middle">
                                        IMS
                                    </text>
                                </svg>



                            </span>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="menu-title">IMS</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('ims.inwardlist')}}">
                                <span class="menu-title">Inward List</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="#">
                                <span class="menu-title">Outword List</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('ims.list') }}">
                                <span class="menu-title">IMS List</span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('ims.dataupload') }}">
                                <span class="menu-title">IMS Data Upload</span>
                            </a>
                        </div>


                    </div>
                </div>

                <!-- ---------- test  -->
                <!-- <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z" fill="black"></path>
                                    <path d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z" fill="black"></path>
                                    <path opacity="0.3" d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z" fill="black"></path>
                                    <path opacity="0.3" d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z" fill="black"></path>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">Master</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion menu-active-bg">
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('product.list')}}">
                                <span class="menu-title">Product List</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('dop_mop.list')}}">
                                <span class="menu-title">DOP/MOP List</span>
                            </a>
                        </div>

                        @if(session('userinfo')->role_type == 2 )
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('user.list')}}">
                                <span class="menu-title">User List</span>
                            </a>
                        </div>
                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('user.targetlist')}}">
                                <span class="menu-title"> Target List </span>
                            </a>
                        </div>
                        @endif

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('order.schemelist')}}">
                                <span class="menu-title"> Scheme List </span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('attendance.index')}}">
                                <span class="menu-title"> Attendance </span>
                            </a>
                        </div>

                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                            <span class="menu-link">
                                <span class="menu-title">DSR</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">

                                <div class="menu-item">
                                    <a class="menu-link " href="{{ route('dsr.index') }}">
                                        <span class="menu-title">Existing Client</span>
                                    </a>
                                </div>

                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('dsr.newindex') }}">

                                        <span class="menu-title">New client</span>
                                    </a>
                                </div>

                            </div>
                        </div>


                        @if(session('userinfo')->role_type == 2 )
                   

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.ledger')}}">
                                <span class="menu-title"> Ledger </span>
                            </a>
                        </div>

                        <div class="menu-item">
                            <a class="menu-link" href="{{ route('master.inventory')}}">
                                <span class="menu-title"> Inventory </span>
                            </a>
                        </div>

                        @endif

                    </div>
                </div> -->

            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>