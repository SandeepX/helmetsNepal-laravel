<?php

use App\Http\Controllers\admin\AboutUsController;
use App\Http\Controllers\admin\AdBlockController;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\BlogCategoryController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\CalloutController;
use App\Http\Controllers\admin\CareerController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\CompanySettingController;
use App\Http\Controllers\admin\ContactUsController;
use App\Http\Controllers\admin\CoreValueController;
use App\Http\Controllers\admin\CouponController;
use App\Http\Controllers\admin\CustomerController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DeliveryChargeController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\DesignationController;
use App\Http\Controllers\admin\EmailVerificationController;
use App\Http\Controllers\admin\FaqCategoryController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\FeatureCategoryController;
use App\Http\Controllers\admin\FeatureCategoryItemController;
use App\Http\Controllers\admin\HomePageSectionController;
use App\Http\Controllers\admin\ManufactureController;
use App\Http\Controllers\admin\NewsLetterSubscriptionController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageBannerController;
use App\Http\Controllers\admin\PagesController;
use App\Http\Controllers\admin\ReviewController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductGraphicController;
use App\Http\Controllers\admin\ProductModelController;
use App\Http\Controllers\admin\RiderStoryController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\ShowroomController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\SlidingContentController;
use App\Http\Controllers\admin\TeamController;
use App\Http\Controllers\admin\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'cn-admin', 'as' => 'admin.', 'middleware' => ['web']], static function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'getAuthenticate']);
    Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/otp-verify', [AuthController::class, 'otpVerify'])->name('otp-verify');
    Route::post('/verified-login', [AuthController::class, 'loginUserWithOtpVerification'])->name('otp-verified-login');
});

Route::group(['prefix' => 'cn-admin', 'as' => 'admin.', 'middleware' => ['admin.auth', 'web']], static function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');


    Route::resource('users', UserController::class);
    Route::post('/users/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::get('/users/{id}/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
    Route::post('/users/{id}/save-password', [UserController::class, 'savePassword'])->name('users.savePassword');

    Route::resource('roles', RoleController::class);
    Route::post('/roles/{id}/change-status', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');

    Route::resource('banners', BannerController::class);
    Route::post('/banners/{id}/change-status', [BannerController::class, 'changeStatus'])->name('banners.changeStatus');
    Route::post('/banners/{id}/change-feature-status', [BannerController::class, 'changeFeatureStatus'])->name('banners.changeFeatureStatus');

    Route::resource('adBlock', AdBlockController::class);
    Route::post('/adBlock/{id}/change-status', [AdBlockController::class, 'changeStatus'])->name('adBlock.changeStatus');

    Route::resource('brands', BrandController::class);
    Route::post('/brands/{id}/change-status', [BrandController::class, 'changeStatus'])->name('brands.changeStatus');

    Route::resource('colors', ColorController::class);
    Route::post('/colors/{id}/change-status', [ColorController::class, 'changeStatus'])->name('colors.changeStatus');

    Route::resource('category', CategoryController::class);
    Route::post('/category/{id}/change-status', [CategoryController::class, 'changeStatus'])->name('category.changeStatus');
    Route::get('/category/{id}/get-child', [CategoryController::class, 'getChildCategory'])->name('category.getChildCategory');

    Route::resource('size', SizeController::class);
    Route::post('/size/{id}/change-status', [SizeController::class, 'changeStatus'])->name('size.changeStatus');

    Route::resource('faq-category', FaqCategoryController::class);
    Route::post('/faq-category/{id}/change-status', [FaqCategoryController::class, 'changeStatus'])->name('faq-category.changeStatus');

    Route::resource('faq', FaqController::class);
    Route::post('/faq/{id}/change-status', [FaqController::class, 'changeStatus'])->name('faq.changeStatus');

    Route::resource('designation', DesignationController::class);
    Route::post('/designation/{id}/change-status', [DesignationController::class, 'changeStatus'])->name('designation.changeStatus');

    Route::resource('team', TeamController::class);
    Route::post('/team/{id}/change-status', [TeamController::class, 'changeStatus'])->name('team.changeStatus');
    Route::post('/team/{id}/change-feature-status', [TeamController::class, 'changeFeaturedStatus'])->name('team.changeFeaturedStatus');

    Route::resource('pages', PagesController::class);
    Route::post('/pages/{id}/change-status', [PagesController::class, 'changeStatus'])->name('pages.changeStatus');

    Route::resource('product', ProductController::class);
    Route::post('/product/{id}/change-status', [ProductController::class, 'changeStatus'])->name('product.changeStatus');
    Route::get('/product/{id}/change-approval-status', [ProductController::class, 'changeApproveStatus'])->name('product.changeApproveStatus');
    Route::post('/product/{id}/change-color-status', [ProductController::class, 'changeColorStatus'])->name('product.changeColorStatus');
    Route::get('/product/{id}/edit-product-image', [ProductController::class, 'editProductImages'])->name('product.editProductImages');
    Route::post('/product/{id}/save-product-image', [ProductController::class, 'updateProductImages'])->name('product.updateProductImages');
    Route::post('/product/{id}/delete-product-image', [ProductController::class, 'deleteProductImages'])->name('product.deleteProductImages');

    Route::get('/product/{type}/product-attribute/{section}', [ProductController::class, 'productAttribute'])->name('product.productAttribute');

    Route::post('/product/{productAttributeDetail_id}/delete-product-attribute-image', [ProductController::class, 'deleteProductAttributeImages'])->name('product.deleteProductAttributeImages');
    Route::get('/product-search/search', [ProductController::class, 'productSearch'])->name('product.productSearch');
    Route::get('/product-search/{product_id}/product-search-detail', [ProductController::class, 'productSearchDetails'])->name('product.productSearchDetails');

    Route::get('/product-color-row', [ProductController::class, 'productColorRow'])->name('product.productColorRow');

    Route::get('/{product_id}/product-discount', [ProductController::class, 'productDiscount'])->name('product.productDiscount');
    Route::get('/{product_id}/product-discount/create', [ProductController::class, 'productDiscountCreate'])->name('product.productDiscountCreate');
    Route::post('/{product_id}/product-discount', [ProductController::class, 'productDiscountSave'])->name('product.productDiscountSave');
    Route::get('/{productDiscount_id}/product-discount/edit', [ProductController::class, 'productDiscountEdit'])->name('product.productDiscountEdit');
    Route::put('/{productDiscount_id}/product-discount/update', [ProductController::class, 'productDiscountUpdate'])->name('product.productDiscountUpdate');
    Route::delete('/{productDiscount_id}/product-discount/delete', [ProductController::class, 'productDiscountDelete'])->name('product.productDiscountDelete');
    Route::post('/{productDiscount_id}/product-discount-change-status', [ProductController::class, 'productDiscountChangeStatus'])->name('product.productDiscountChangeStatus');


    Route::get('/{product_id}/product-color-index', [ProductController::class, 'productColorIndex'])->name('product.productColorIndex');
    Route::get('/{product_id}/product-color-create', [ProductController::class, 'productColorCreate'])->name('product.productColorCreate');
    Route::post('/{product_id}/product-color-save', [ProductController::class, 'productColorSave'])->name('product.productColorSave');
    Route::get('/{product_id}/product-color-edit/{productColor_id}', [ProductController::class, 'productColorEdit'])->name('product.productColorEdit');
    Route::post('/{product_id}/product-color-update/{productColor_id}', [ProductController::class, 'productColorUpdate'])->name('product.productColorUpdate');
    Route::delete('/{product_id}/product-color-delete/{productColor_id}', [ProductController::class, 'productColorDelete'])->name('product.productColorDelete');



    Route::get('/{product_id}/product-tag', [ProductController::class, 'productTag'])->name('product.productTag');
    Route::post('/{product_id}/product-tag-save', [ProductController::class, 'productTagSave'])->name('product.productTagSave');


//    Route::resource('feature-category', FeatureCategoryController::class);
    Route::get('/feature-category', [FeatureCategoryController::class, 'index'])->name('feature-category.index');
    Route::post('/feature-category/{id}/change-status', [FeatureCategoryController::class, 'changeStatus'])->name('feature-category.changeStatus');
    Route::get('/feature-category/{id}', [FeatureCategoryController::class, 'edit'])->name('feature-category.edit');
    Route::put('/feature-category/{id}/update', [FeatureCategoryController::class, 'update'])->name('feature-category.update');
    Route::post('/{feature_category}/update-flash-sale', [FeatureCategoryController::class, 'updateFlashSale'])->name('feature-category.updateFlashSale');

    Route::get('/{feature_category}/category', [FeatureCategoryItemController::class, 'listFeatureCategory'])->name('featureCategory.listFeatureCategory');
    Route::get('/{feature_category}/category/create', [FeatureCategoryItemController::class, 'createFeatureCategory'])->name('featureCategory.createFeatureCategory');
    Route::post('/{feature_category}/category/save', [FeatureCategoryItemController::class, 'storeFeatureCategory'])->name('featureCategory.storeFeatureCategory');
    Route::delete('/{feature_category_item_id}/delete/{feature_category}', [FeatureCategoryItemController::class, 'deleteFeatureCategoryItem'])->name('featureCategory.deleteFeatureCategoryItem');
    Route::post('/{feature_category_item_id}/upload-image/{feature_category}', [FeatureCategoryItemController::class, 'uploadImageFeatureCategoryItem'])->name('featureCategory.uploadImageFeatureCategoryItem');


    Route::resource('riderStory', RiderStoryController::class);
    Route::post('/riderStory/{id}/change-status', [RiderStoryController::class, 'changeStatus'])->name('riderStory.changeStatus');

    Route::resource('testimonial', TestimonialController::class);
    Route::post('/testimonial/{id}/change-status', [TestimonialController::class, 'changeStatus'])->name('testimonial.changeStatus');

    Route::resource('blogCategory', BlogCategoryController::class);
    Route::post('/blogCategory/{id}/change-status', [BlogCategoryController::class, 'changeStatus'])->name('blogCategory.changeStatus');

    Route::resource('blog', BlogController::class);
    Route::post('/blog/{id}/change-status', [BlogController::class, 'changeStatus'])->name('blog.changeStatus');
    Route::post('/blog/{id}/change-feature-status', [BlogController::class, 'changeFeaturedStatus'])->name('blog.changeFeaturedStatus');


    Route::get('/services', [SlidingContentController::class, 'indexImageType'])->name('slidingContent.indexImageType');
    Route::get('/services/create', [SlidingContentController::class, 'createImageType'])->name('slidingContent.createImageType');
    Route::post('/services', [SlidingContentController::class, 'storeImageType'])->name('slidingContent.storeImageType');
    Route::get('/services/{slidingContent}/edit', [SlidingContentController::class, 'editImageType'])->name('slidingContent.editImageType');
    Route::put('/services/{slidingContent}', [SlidingContentController::class, 'updateImageType'])->name('slidingContent.updateImageType');
    Route::delete('/services/{slidingContent}', [SlidingContentController::class, 'destroyImageType'])->name('slidingContent.destroyImageType');
    Route::post('/services/{slidingContent}/change-status', [SlidingContentController::class, 'changeStatus'])->name('slidingContent.changeStatusImageType');

    Route::get('/sliding-youtube-content', [SlidingContentController::class, 'indexYoutubeType'])->name('slidingContent.indexYoutubeType');
    Route::get('/sliding-youtube-content/create', [SlidingContentController::class, 'createYoutubeType'])->name('slidingContent.createYoutubeType');
    Route::post('/sliding-youtube-content', [SlidingContentController::class, 'storeYoutubeType'])->name('slidingContent.storeYoutubeType');
    Route::get('/sliding-youtube-content/{slidingContent}/edit', [SlidingContentController::class, 'editYoutubeType'])->name('slidingContent.editYoutubeType');
    Route::put('/sliding-youtube-content/{slidingContent}', [SlidingContentController::class, 'updateYoutubeType'])->name('slidingContent.updateYoutubeType');
    Route::delete('/sliding-youtube-content/{slidingContent}', [SlidingContentController::class, 'destroyYoutubeType'])->name('slidingContent.destroyYoutubeType');
    Route::post('/sliding-youtube-content/{slidingContent}/change-status', [SlidingContentController::class, 'changeStatus'])->name('slidingContent.changeStatusYoutubeType');


    Route::get('/aboutUs', [AboutUsController::class, 'aboutUsCreate'])->name('aboutUs.aboutUsCreate');
    Route::post('/aboutUs', [AboutUsController::class, 'aboutUsSave'])->name('aboutUs.aboutUsSave');

    Route::resource('coreValue', CoreValueController::class);
    Route::post('/coreValue/{id}/change-status', [CoreValueController::class, 'changeStatus'])->name('coreValue.changeStatus');

    Route::resource('callout', CalloutController::class);
    Route::post('/callout/{id}/change-status', [CalloutController::class, 'changeStatus'])->name('callout.changeStatus');

    Route::resource('showroom', ShowroomController::class);
    Route::post('/showroom/{id}/change-status', [ShowroomController::class, 'changeStatus'])->name('showroom.changeStatus');
    Route::post('/showroom/{id}/change-is-feature', [ShowroomController::class, 'changeIsFeature'])->name('showroom.changeIsFeature');
    Route::post('/showroom/{id}/change-show-in-contactUs', [ShowroomController::class, 'changeShowInContactUs'])->name('showroom.changeShowInContactUs');

    Route::resource('department', DepartmentController::class);
    Route::post('/department/{id}/change-status', [DepartmentController::class, 'changeStatus'])->name('department.changeStatus');

    Route::resource('career', CareerController::class);
    Route::post('/career/{id}/change-status', [CareerController::class, 'changeStatus'])->name('career.changeStatus');
    Route::get('/application-list', [CareerController::class, 'applicationList'])->name('career.applicationList');

    Route::resource('deliveryCharge', DeliveryChargeController::class);
    Route::post('/deliveryCharge/{id}/change-status', [DeliveryChargeController::class, 'changeStatus'])->name('deliveryCharge.changeStatus');

    Route::resource('productModel', ProductModelController::class);
    Route::post('/productModel/{id}/change-status', [ProductModelController::class, 'changeStatus'])->name('productModel.changeStatus');

    Route::resource('productGraphic', ProductGraphicController::class);
    Route::post('/productGraphic/{id}/change-status', [ProductGraphicController::class, 'changeStatus'])->name('productGraphic.changeStatus');

    Route::resource('manufacture', ManufactureController::class);
    Route::post('/manufacture/{id}/change-status', [ManufactureController::class, 'changeStatus'])->name('manufacture.changeStatus');

    Route::resource('coupon', CouponController::class);
    Route::post('/coupon/{id}/change-status', [CouponController::class, 'changeStatus'])->name('coupon.changeStatus');
    Route::get('/coupon/apply-on/{couponFor}', [CouponController::class, 'getListToApplyCoupon'])->name('coupon.getListToApplyCoupon');


    Route::get('/order-list', [OrderController::class, 'orderList'])->name('order.orderList');
    Route::get('/order-detail/{order_id}', [OrderController::class, 'orderDetail'])->name('order.orderDetail');
    Route::get('/order-invoice', [OrderController::class, 'orderInvoice'])->name('order.orderInvoice');
    Route::post('/change-order-status/{order_id}', [OrderController::class, 'changeOrderStatus'])->name('order.changeOrderStatus');
    Route::delete('/delete/{order_id}', [OrderController::class, 'deleteOrder'])->name('order.deleteOrder');

    Route::get('/return-order-list', [OrderController::class, 'returnOrderList'])->name('order.returnOrderList');
    Route::get('/return-order-detail/{return_order_id}', [OrderController::class, 'returnOrderDetail'])->name('order.returnOrderDetail');
    Route::post('/change-return-order-status/{return_order_id}', [OrderController::class, 'changeReturnOrderStatus'])->name('order.changeReturnOrderStatus');

    Route::get('/customer-list', [CustomerController::class, 'customerList'])->name('customer.customerList');
    Route::get('/vendor-list', [CustomerController::class, 'vendorList'])->name('customer.vendorList');
    Route::get('/{customer_id}/customer-detail', [CustomerController::class, 'customerDetail'])->name('customer.customerDetail');
    Route::get('/{customer_id}/customer-order-history', [CustomerController::class, 'customerOrderHistory'])->name('customer.customerOrderHistory');
    Route::get('/customer-order-detail', [CustomerController::class, 'customerOrderDetail'])->name('customer.customerOrderDetail');
    Route::post('/customer/{id}/change-status', [CustomerController::class, 'changeStatus'])->name('customer.changeStatus');


    Route::resource('pageBanner', PageBannerController::class)->only(['index', 'edit', 'update']);

    Route::get('/company-detail', [CompanySettingController::class, 'companyDetailCreate'])->name('companyDetail.companyDetailCreate');
    Route::post('/company-detail', [CompanySettingController::class, 'companyDetailSave'])->name('companyDetail.companyDetailSave');


    Route::get('/company-setting', [CompanySettingController::class, 'companySettingCreate'])->name('companySetting.companySettingCreate');
    Route::post('/company-setting', [CompanySettingController::class, 'companySettingSave'])->name('companySetting.companySettingSave');

    Route::resource('news-letter-subscription', NewsLetterSubscriptionController::class ,['names' => 'newsLetterSubscription'])->only(['index', 'destroy']);
    Route::post('/news-letter-subscription/{id}/change-status', [NewsLetterSubscriptionController::class, 'changeStatus'])->name('newsLetterSubscription.changeStatus');

    Route::resource('contact-us', ContactUsController::class ,['names' => 'contactUs'])->only(['index', 'destroy','show']);
    Route::post('/contact-us/{id}/change-status', [ContactUsController::class, 'changeStatus'])->name('contactUs.changeStatus');


    Route::get('/home-page-section', [HomePageSectionController::class, 'index'])->name('homePageSection.index');
    Route::post('/home-page-section', [HomePageSectionController::class, 'update'])->name('homePageSection.update');
    Route::post('/home-page-section/{id}/change-status', [HomePageSectionController::class, 'changeStatus'])->name('homePageSection.changeStatus');

    Route::get('/review-list', [ReviewController::class, 'index'])->name('review.index');
    Route::post('/review/{id}/change-status', [ReviewController::class, 'changeStatus'])->name('review.changeStatus');

});

/** customer Email Verify */
Route::get('/email/verify/{id}/{hash}',  [EmailVerificationController::class, 'verifyCustomerEmailAddress'])
    ->name('verification.verify');

Route::get('social/auth/redirect/{type}', [App\Http\Controllers\api\front\CustomerController::class, 'redirectToProvider']);
Route::get('social/auth/{type}', [App\Http\Controllers\api\front\CustomerController::class, 'handleProviderCallback']);
