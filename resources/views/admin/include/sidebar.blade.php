@php
    $currentRoute = Request::route()->getName();
    $Route = explode('.',$currentRoute);
@endphp
<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <span><img src=" {{asset('admin/assets/helmet-nepal.jpg')}} "></span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item @if($Route[1] === 'dashboard') active @endif">
                <a href="{{route('admin.dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'companyDetail') active @endif">
                <a href="{{route('admin.companyDetail.companyDetailCreate')}}" class="nav-link">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">Company Details</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'companySetting') active @endif">
                <a href="{{route('admin.companySetting.companySettingCreate')}}" class="nav-link">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">Company Setting</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'users' && ($Route[2]==='index' || $Route[2]==='create')) active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                   aria-controls="users">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">User Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'users' && ($Route[2]==='index' || $Route[2]==='create')) show @endif" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}"
                               class="nav-link @if($Route[1] === 'users' && $Route[2]==='index') active @endif">All User
                                Lists</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.users.create')}}"
                               class="nav-link @if($Route[1] === 'users' && $Route[2]==='create') active @endif ">Add
                                User</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'colors' || $Route[1] === 'size') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#productAttribute" role="button"
                   aria-expanded="false" aria-controls="productAttribute">
                    <i class="link-icon" data-feather="shuffle"></i>
                    <span class="link-title">Product Attribute</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'colors' || $Route[1] === 'size')  show @endif"
                     id="productAttribute">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.colors.index')}}"
                               class="nav-link @if($Route[1] === 'colors') active @endif ">Color</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.size.index')}}"
                               class="nav-link @if($Route[1] === 'size') active @endif ">Size</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'category' || $Route[1] === 'product' || $Route[1] === 'brands' || $Route[1] === 'manufacture' || $Route[1] === 'productModel' || $Route[1] === 'productGraphic' || $Route[1] === 'featureCategory' || $Route[1] === 'feature-category') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#product" role="button" aria-expanded="false"
                   aria-controls="product">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Product Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div
                    class="collapse @if($Route[1] === 'category' || $Route[1] === 'product' || $Route[1] === 'brands' || $Route[1] === 'manufacture' || $Route[1] === 'productModel' || $Route[1] === 'productGraphic' || $Route[1] === 'featureCategory' || $Route[1] === 'feature-category')  show @endif"
                    id="product">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.category.index')}}"
                               class="nav-link @if($Route[1] === 'category') active @endif ">Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.index')}}"
                               class="nav-link @if($Route[1] === 'product' && ($Route[2]==='index' || $Route[2]==='edit')) active @endif ">Product
                                List</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.product.create')}}"
                               class="nav-link @if($Route[1] === 'product' && $Route[2]==='create') active @endif ">Product
                                Create</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.productModel.index')}}"
                               class="nav-link @if($Route[1] === 'productModel') active @endif ">Product Model Management</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.productGraphic.index')}}"
                               class="nav-link @if($Route[1] === 'productGraphic') active @endif ">Product Graphic Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.manufacture.index')}}"
                               class="nav-link @if($Route[1] === 'manufacture') active @endif ">Manufacture Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.brands.index')}}"
                               class="nav-link @if($Route[1] === 'brands') active @endif ">Brand Management</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.feature-category.index')}}"
                               class="nav-link @if($Route[1] === 'feature-category' && $Route[2] === 'index') active @endif ">Feature Product Category </a>
                        </li>
                        @foreach($_featureCategoryList as $value)
                            @if($value->name  != 'Recommended Items')
                            <li class="nav-item">
                                <a href="{{route('admin.featureCategory.listFeatureCategory', ['feature_category'=> $value->slug])}}"
                                   class="nav-link @if($Route[1] === 'featureCategory' && $Route[2] === 'listFeatureCategory')) active @endif ">{{$value->name}}</a>
                            </li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'order') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#order" role="button" aria-expanded="false"
                   aria-controls="order">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Order Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div
                    class="collapse @if($Route[1] === 'order')  show @endif"
                    id="order">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.order.orderList')}}"
                               class="nav-link @if($Route[1] === 'order' && $Route[2]==='orderList') active @endif ">All Order Lists</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.order.returnOrderList')}}"
                               class="nav-link @if($Route[1] === 'order' && $Route[2]==='returnOrderList') active @endif ">All Return Order Lists</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item  @if($Route[1] === 'customer') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false"
                   aria-controls="users">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Customer Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'customer' && ($Route[2]==='customerList' || $Route[2]==='vendorList')) show @endif" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.customer.customerList')}}"
                               class="nav-link @if($Route[1] === 'customer' && $Route[2]==='customerList') active @endif">Customer List</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.customer.vendorList')}}"
                               class="nav-link @if($Route[1] === 'customer' && $Route[2]==='vendorList') active @endif ">Vendor List</a>
                        </li>
                    </ul>
                </div>
            </li>



            <li class="nav-item  @if($Route[1] === 'review') active @endif">
                <a href="{{route('admin.review.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="book"></i>
                    <span class="link-title">Review</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'banners') active @endif">
                <a href="{{route('admin.banners.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="image"></i>
                    <span class="link-title">Banner Management</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'riderStory') active @endif">
                <a href="{{route('admin.riderStory.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="truck"></i>
                    <span class="link-title">Riders Story</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'testimonial') active @endif">
                <a href="{{route('admin.testimonial.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="book-open"></i>
                    <span class="link-title">Testimonial</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'showroom') active @endif">
                <a href="{{route('admin.showroom.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="archive"></i>
                    <span class="link-title">Showroom Management</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'deliveryCharge') active @endif">
                <a href="{{route('admin.deliveryCharge.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="upload"></i>
                    <span class="link-title">Delivery Charge Management</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'coupon') active @endif">
                <a href="{{route('admin.coupon.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">coupon Management</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'adBlock') active @endif">
                <a href="{{route('admin.adBlock.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="target"></i>
                    <span class="link-title">Ad Block Management</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'newsLetterSubscription') active @endif">
                <a href="{{route('admin.newsLetterSubscription.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="bookmark"></i>
                    <span class="link-title">NewsLetter Subscription</span>
                </a>
            </li>
            <li class="nav-item  @if($Route[1] === 'contactUs') active @endif">
                <a href="{{route('admin.contactUs.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Contact Us Message</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'callout') active @endif">
                <a href="{{route('admin.callout.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="message-circle"></i>
                    <span class="link-title">Callout Management</span>
                </a>
            </li>

            <li class="nav-item  @if($Route[1] === 'faq-category' || $Route[1] === 'faq') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#faq" role="button" aria-expanded="false"
                   aria-controls="faq">
                    <i class="link-icon" data-feather="message-circle"></i>
                    <span class="link-title">FAQ Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'faq-category' || $Route[1] === 'faq')  show @endif" id="faq">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.faq-category.index')}}"
                               class="nav-link @if($Route[1] === 'faq-category') active @endif ">Faq Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.faq.index')}}"
                               class="nav-link @if($Route[1] === 'faq' ) active @endif ">FAQ</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'designation' || $Route[1] === 'team') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#designation" role="button" aria-expanded="false"
                   aria-controls="designation">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Team Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'team' || $Route[1] === 'designation')  show @endif"
                     id="designation">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.designation.index')}}"
                               class="nav-link @if($Route[1] === 'designation') active @endif ">Designation</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.team.index')}}"
                               class="nav-link @if($Route[1] === 'team' ) active @endif ">Team </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'pages' || $Route[1] === 'coreValue' || $Route[1] === 'aboutUs' || $Route[1] === 'slidingContent' || $Route[1] === 'pageBanner' || $Route[1] === 'homePageSection') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#pages" role="button" aria-expanded="false"
                   aria-controls="designation">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Pages Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div
                    class="collapse @if($Route[1] === 'pages' || $Route[1] === 'coreValue' || $Route[1] === 'aboutUs' || $Route[1] === 'slidingContent' || $Route[1] === 'pageBanner' || $Route[1] === 'homePageSection' )  show @endif"
                    id="pages">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.pages.index')}}"
                               class="nav-link @if($Route[1] === 'pages') active @endif ">Pages</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.coreValue.index')}}"
                               class="nav-link @if($Route[1] === 'coreValue') active @endif ">Core Value</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.aboutUs.aboutUsCreate')}}"
                               class="nav-link @if($Route[1] === 'aboutUs') active @endif ">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.slidingContent.indexImageType')}}"
                               class="nav-link @if($Route[1] === 'slidingContent' && ($Route[2] === ('indexImageType') || $Route[2] === ('createImageType') || $Route[2] === 'editImageType')) active @endif ">Services</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.slidingContent.indexYoutubeType')}}"
                               class="nav-link @if($Route[1] === 'slidingContent' && ($Route[2] === ('indexYoutubeType') || $Route[2] === ('createYoutubeType') || $Route[2] === 'editYoutubeType')) active @endif ">Youtube
                                Slider</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{route('admin.pageBanner.index')}}"
                               class="nav-link @if($Route[1] === 'pageBanner') active @endif ">Pages Banner</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.homePageSection.index')}}"
                               class="nav-link @if($Route[1] === 'homePageSection') active @endif "> Home Section Position</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item  @if($Route[1] === 'blogCategory' || $Route[1] === 'blog') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#blog" role="button" aria-expanded="false"
                   aria-controls="designation">
                    <i class="link-icon" data-feather="rss"></i>
                    <span class="link-title">Blog Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'blogCategory' || $Route[1] === 'blog')  show @endif" id="blog">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.blogCategory.index')}}"
                               class="nav-link @if($Route[1] === 'blogCategory') active @endif ">Blog Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.blog.index')}}"
                               class="nav-link @if($Route[1] === 'blog' ) active @endif ">Blog </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item  @if($Route[1] === 'department' || $Route[1] === 'career') active @endif">
                <a class="nav-link" data-bs-toggle="collapse" href="#blog" role="button" aria-expanded="false"
                   aria-controls="designation">
                    <i class="link-icon" data-feather="send"></i>
                    <span class="link-title">Career Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse @if($Route[1] === 'department' || $Route[1] === 'career')  show @endif" id="blog">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('admin.department.index')}}"
                               class="nav-link @if($Route[1] === 'department') active @endif ">Department</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.career.index')}}"
                               class="nav-link @if($Route[1] === 'career' && $Route[2] === 'index') active @endif ">Career </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.career.applicationList')}}"
                               class="nav-link @if($Route[1] === 'career' && $Route[2] === 'applicationList' ) active @endif ">Application List </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
