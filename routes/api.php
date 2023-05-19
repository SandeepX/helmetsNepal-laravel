<?php

use App\Http\Controllers\api\front\AdBlockController;
use App\Http\Controllers\api\front\BlogController;
use App\Http\Controllers\api\front\CareerController;
use App\Http\Controllers\api\front\CartController;
use App\Http\Controllers\api\front\ContactUsController;
use App\Http\Controllers\api\front\CustomerController;

use App\Http\Controllers\api\front\FaqController;
use App\Http\Controllers\api\front\NewsLetterSubscriptionController;
use App\Http\Controllers\api\front\NotificationController;
use App\Http\Controllers\api\front\OrderController;
use App\Http\Controllers\api\front\PageBannerController;
use App\Http\Controllers\api\front\PageController;
use App\Http\Controllers\api\front\ProductController;
use App\Http\Controllers\api\front\ReviewController;
use App\Http\Controllers\api\front\SliderController;
use App\Http\Controllers\api\front\StoryController;
use App\Http\Controllers\api\front\TeamController;
use App\Http\Repositories\DeliveryChargeRepository;
use App\Http\Services\DeliveryChargeServices;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'front-end/1.0v'], static function () {
    Route::post('/customer-login', [CustomerController::class, 'login'])->name('api.customer.login');
    Route::post('/customer-logout', [CustomerController::class, 'logout'])->name('api.customer.logout');

    /**  register Customer **/
    Route::post('/customer-register', [CustomerController::class, 'register'])->name('api.customer.register');

    Route::get('/banner-list', [SliderController::class, 'getBannerList'])->name('api.getBannerList');
    Route::get('/category-list', [SliderController::class, 'getCategoryList'])->name('api.getCategoryList');
    Route::get('/brand-list', [SliderController::class, 'getBrandList'])->name('api.getBrandList');
    Route::get('/sliding-content', [SliderController::class, 'getSlidingContent'])->name('api.getSlidingContent');
    Route::get('/youtube-sliding-content', [SliderController::class, 'getYoutubeSlidingContent'])->name('api.getYoutubeSlidingContent');

    Route::get('/get-feature-item-list', [ProductController::class, 'getFeatureItemList'])->name('api.product.getFeatureItemList');
    Route::get('/get-recommended-item-list', [ProductController::class, 'getRecommendedItemList'])->name('api.product.getRecommendedItemList');
    Route::get('/get-feature-helmets', [ProductController::class, 'getFeatureHelmets'])->name('api.product.getFeatureHelmets');
    Route::get('/get-feature-riding-gears', [ProductController::class, 'getFeatureRidingGears'])->name('api.product.getFeatureRidingGears');
    Route::get('/get-feature-apparels', [ProductController::class, 'getFeatureApparels'])->name('api.product.getFeatureApparels');
    Route::get('/get-feature-accessories', [ProductController::class, 'getFeatureAccessories'])->name('api.product.getFeatureAccessories');

    Route::get('/get-flash-sales', [ProductController::class, 'getFlashSales'])->name('api.product.getFlashSales');


    Route::get('/get-product-by-brand', [ProductController::class, 'getProductByBrand'])->name('api.product.getProductByBrand');
    Route::get('/get-product-by-category', [ProductController::class, 'getProductByCategory'])->name('api.product.getProductByCategory');
    Route::get('/get-product-detail/{slug}', [ProductController::class, 'getProductDetails'])->name('api.product.getProductDetails');

    Route::get('/get-common-pages-name', [PageController::class, 'getCommonPagesNames'])->name('api.pages.getCommonPagesNames');
    Route::get('/get-common-page-details/{slug}', [PageController::class, 'getCommonPagesDetails'])->name('api.pages.getCommonPagesDetails');

    Route::get('/get-home-page-section-detail', [PageController::class, 'getHomePageDetail'])->name('api.pages.getHomePageDetail');
    Route::get('/get-news-letter-section-detail', [PageController::class, 'getNewsletterSectionDetail'])->name('api.pages.getNewsletterSectionDetail');
    Route::get('/get-blog-section-detail', [PageController::class, 'geBlogSectionDetail'])->name('api.pages.geBlogSectionDetail');
    Route::get('/get-about-us-detail', [PageController::class, 'geAboutUsDetail'])->name('api.pages.geAboutUsDetail');
    Route::get('/get-team-section-detail', [PageController::class, 'getTeamSectionDetail'])->name('api.pages.getTeamSectionDetail');
    Route::get('/get-core-value-section-detail', [PageController::class, 'getCoreValueSectionDetail'])->name('api.pages.getCoreValueSectionDetail');
    Route::get('/get-who-we-are-section-detail', [PageController::class, 'getWhoWeAreSectionDetail'])->name('api.pages.getWhoWeAreSectionDetail');
    Route::get('/get-showroom', [PageController::class, 'getShowroom'])->name('api.showroom.getShowroom');
    Route::get('/get-featured-showroom', [PageController::class, 'getFeaturedShowroom'])->name('api.showroom.getFeaturedShowroom');
    Route::get('/get-core-value', [PageController::class, 'getCoreValue'])->name('api.coreValue.getCoreValue');
    Route::get('/get-company-detail', [PageController::class, 'getCompanyDetail'])->name('api.companyDetail.getCompanyDetail');


    Route::get('/get-contact-us-detail', [ContactUsController::class, 'getContactUsDetail'])->name('api.contactUs.getContactUsDetail');
    Route::post('/send-message-contact-us', [ContactUsController::class, 'sendMessage'])->name('api.contactUs.sendMessage');

    Route::get('/get-testimonial-list', [StoryController::class, 'getTestimonialList'])->name('api.story.getTestimonialList');
    Route::get('/get-rider-story-list', [StoryController::class, 'getRiderStoryList'])->name('api.story.getRiderStoryList');
    Route::get('/rider-story-detail/{id}', [StoryController::class, 'riderStoryDetails'])->name('api.story.riderStoryDetails');


    Route::get('/get-feature-blog', [BlogController::class, 'getFeatureBlog'])->name('api.blog.getFeatureBlog');
    Route::get('/get-blog', [BlogController::class, 'getBlogList'])->name('api.blog.getBlogList');
    Route::get('/get-blog-category', [BlogController::class, 'getBlogCategory'])->name('api.blog.getBlogCategory');
    Route::get('/get-blog-by-category/{id}', [BlogController::class, 'getBlogByCategoryID'])->name('api.blog.getBlogByCategoryID');
    Route::get('/get-blog-detail/{id}', [BlogController::class, 'getBlogDetail'])->name('api.blog.getBlogDetail');


    Route::get('/get-feature-team', [TeamController::class, 'getFeatureTeam'])->name('api.team.getFeatureTeam');
    Route::get('/get-team', [TeamController::class, 'getActiveTeamList'])->name('api.team.getActiveTeamList');
    Route::get('/get-team-detail/{slug}', [TeamController::class, 'getTeamDetail'])->name('api.team.getTeamDetail');

    Route::get('/get-team', [TeamController::class, 'getActiveTeamList'])->name('api.team.getActiveTeamList');


    Route::get('/get-page-banner/{name}', [PageBannerController::class, 'getPageBanner'])->name('api.pageBanner.getPageBanner');

    Route::get('/get-aboutUs-callout', [PageBannerController::class, 'getAboutUsCallout'])->name('api.callout.getAboutUsCallout');
    Route::get('/get-shop-callout', [PageBannerController::class, 'getShopCallout'])->name('api.callout.getShopCallout');
    Route::get('/get-home-section-position', [PageBannerController::class, 'getHomeSectionPosition'])->name('api.homeSectionPosition.getHomeSectionPosition');


    Route::get('/get-career-department-list', [CareerController::class, 'getCareerDepartmentList'])->name('api.career.getCareerDepartmentList');
    Route::get('/get-career-by-department/{department_id}', [CareerController::class, 'getCareerByDepartment'])->name('api.career.getCareerByDepartment');
    Route::get('/get-career-detail/{career_id}', [CareerController::class, 'getCareerDetail'])->name('api.career.getCareerDetail');
    Route::post('/save-application-detail', [CareerController::class, 'saveApplicationDetail'])->name('api.career.saveApplicationDetail');

    Route::get('/get-shop-ad-block', [AdBlockController::class, 'getShopAdBlock'])->name('api.adBlock.getShopAdBlock');
    Route::get('/get-home-ad-block', [AdBlockController::class, 'getHomeAdBlock'])->name('api.adBlock.getHomeAdBlock');

    Route::post('/save-newsletter-sub', [NewsLetterSubscriptionController::class, 'saveNewsLetterSubscription'])->name('api.newsletter.saveNewsLetterSubscription');


    Route::get('/get-faq', [FaqController::class, 'getFaq'])->name('api.faq.getFaq');


    Route::get('/product-search-api', [ProductController::class, 'productSearchApi'])->name('api.product.productSearchApi');

    Route::get('/product-search', [ProductController::class, 'productSearch'])->name('api.product.productSearch');



//    Route::get('social/auth/redirect/{type}', [CustomerController::class, 'redirectToProvider']);
//    Route::get('social/auth/{type}', [CustomerController::class, 'handleProviderCallback']);




});
Route::group(['prefix' => 'front-end/1.0v', 'middleware' => ['auth:customerApi']], static function () {

    Route::post('/update-customer-profile', [CustomerController::class, 'updateCustomerProfile'])->name('api.customer.updateCustomerProfile');
    Route::post('/update-customer-email', [CustomerController::class, 'updateCustomerEmail'])->name('api.customer.updateCustomerEmail');
    //Route::post('/update-customer-address', [CustomerController::class, 'updateCustomerAddress'])->name('api.customer.updateCustomerAddress');
    Route::post('/update-customer-image', [CustomerController::class, 'updateCustomerImage'])->name('api.customer.updateCustomerImage');
    Route::post('/get-customer-details', [CustomerController::class, 'getCustomerDetails'])->name('api.customer.getCustomerDetails');
    Route::post('/reset-customer-password', [CustomerController::class, 'resetPassword'])->name('api.customer.resetPassword');

    Route::post('/save-wishlist', [CustomerController::class, 'saveWishlist'])->name('api.wishlist.saveWishlist');
    Route::get('/get-wishlist', [CustomerController::class, 'getWishlist'])->name('api.wishlist.getWishlist');
    Route::post('/delete-wishlist', [CustomerController::class, 'deleteWishlist'])->name('api.wishlist.deleteWishlist');

    Route::post('/add-cart', [CartController::class, 'addToCart'])->name('api.cart.addToCart');
    Route::post('/update-cart-item', [CartController::class, 'updateCartItem'])->name('api.cart.updateCartItem');
    Route::post('/get-cart-details', [CartController::class, 'getCartDetail'])->name('api.cart.getCartDetail');
    Route::post('/delete-cart-item', [CartController::class, 'deleteCartItem'])->name('api.cart.deleteCartItem');

    Route::get('/get-delivery-charge', static function () {
        return (new DeliveryChargeServices())->getDeliveryChargeList();
    });
    Route::get('/get-customer-address', [CustomerController::class, 'getCustomerAddress'])->name('api.customer.getCustomerAddress');


    Route::post('/check-coupon', [OrderController::class, 'checkCoupon'])->name('api.order.checkCoupon');
    Route::post('/save-order', [OrderController::class, 'saveOrder'])->name('api.order.saveOrder');
    Route::get('/get-order', [OrderController::class, 'getOrderList'])->name('api.order.getOrderList');
    Route::get('/get-past-order', [OrderController::class, 'getPastOrder'])->name('api.order.getPastOrder');
    Route::post('/cancel-order', [OrderController::class, 'cancelOrderProduct'])->name('api.order.cancelOrderProduct');
    Route::post('/return-order', [OrderController::class, 'returnOrderProduct'])->name('api.order.returnOrderProduct');
    Route::get('/get-return-order-list', [OrderController::class, 'getReturnOrderList'])->name('api.order.getReturnOrderList');
    Route::post('/get-order-detail', [OrderController::class, 'getOderDetail'])->name('api.order.getOderDetail');
    Route::post('/get-order-product-detail', [OrderController::class, 'getOderProductDetail'])->name('api.order.getOderProductDetail');

    Route::post('/order-payment', [OrderController::class, 'orderPayment'])->name('api.order.orderPayment');
    Route::post('/check-esewa-transaction', [OrderController::class, 'checkEsewaTransaction'])->name('api.payment.checkEsewaTransaction');



    Route::post('/save-review', [ReviewController::class, 'saveReview'])->name('api.review.saveReview');

    Route::get('/get-notification', [NotificationController::class, 'getNotification'])->name('api.notification.getNotification');
    Route::post('/delete-notification', [NotificationController::class, 'deleteNotification'])->name('api.notification.deleteNotification');
    Route::post('/clear-notification', [NotificationController::class, 'clearNotification'])->name('api.notification.clearNotification');

    Route::post('/get-email-verification', [CustomerController::class, 'getEmailVerification'])->name('api.customer.getEmailVerification');

});
