<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\AboutUsRepository;
use App\Models\AboutUS\AboutUs;
use JetBrains\PhpStorm\ArrayShape;

class AboutUsServices
{
    private string $notFoundMessage = "Sorry! About Us not found";


    public function __construct()
    {
        $this->aboutUsRepository = new AboutUsRepository();
    }

    /**
     * @throws SMException
     */
    public function saveAboutUs($request)
    {
        $_aboutUs = $this->aboutUsRepository->find();
        if ($_aboutUs) {
            return $this->updateAboutUs($_aboutUs, $request);
        }
        return $this->storeAboutUs($request);
    }

    /**
     * @throws SMException
     */
    public function updateAboutUs(AboutUs $_aboutUs, $request)
    {
        $data = $request->all();

        $_rider_story_image = $_aboutUs->rider_story_image;
        $_career_image = $_aboutUs->career_image;
        $_who_we_are_image = $_aboutUs->who_we_are_image;

        if ($request->hasFile('career_image')) {
            if ($_aboutUs->career_image) {
                Helper::unlinkUploadedFile($_aboutUs->career_image, "aboutUs");
            }
            $_career_image = Helper::uploadFile(file: $request->career_image, file_folder_name: "aboutUs", width: 1725, height: 645);
        }

        if ($request->hasFile('who_we_are_image')) {
            if ($_aboutUs->who_we_are_image) {
                Helper::unlinkUploadedFile($_aboutUs->who_we_are_image, "aboutUs");
            }
            $_who_we_are_image = Helper::uploadFile(file: $request->who_we_are_image, file_folder_name: "aboutUs", width: 1725, height: 645);
        }

        if ($request->hasFile('rider_story_image')) {
            if ($_aboutUs->rider_story_image) {
                Helper::unlinkUploadedFile($_aboutUs->rider_story_image, "aboutUs");
            }
            $_rider_story_image = Helper::uploadFile(file: $request->rider_story_image, file_folder_name: "aboutUs", width: 1725, height: 645);
        }

        return $this->aboutUsRepository->update($_aboutUs, [
            'about_us_title' => $data['about_us_title'],
            'about_us_sub_title' => $data['about_us_sub_title'],
            'about_us_description' => $data['about_us_description'],

            'core_value_title' => $data['core_value_title'],
            'core_value_sub_title' => $data['core_value_sub_title'],
            'core_value_description' => $data['core_value_description'],

            'who_we_are_title' => $data['who_we_are_title'],
            'who_we_are_sub_title' => $data['who_we_are_sub_title'],
            'who_we_are_description' => $data['who_we_are_description'],
            'who_we_are_image' => $_who_we_are_image,
            'who_we_are_youtube' => $data['who_we_are_youtube'],

            'slogan_title' => $data['slogan_title'],
            'slogan_sub_title' => $data['slogan_sub_title'],
            'slogan_description' => $data['slogan_description'],
            'slogan_title_1' => $data['slogan_title_1'],
            'slogan_description_1' => $data['slogan_description_1'],
            'slogan_title_2' => $data['slogan_title_2'],
            'slogan_description_2' => $data['slogan_description_2'],

            'team_title' => $data['team_title'],
            'team_description' => $data['team_description'],

            'career_title' => $data['career_title'],
            'career_sub_title' => $data['career_sub_title'],
            'career_image' => $_career_image,

            'testimonial_title' => $data['testimonial_title'],
            'testimonial_sub_title' => $data['testimonial_sub_title'],
            'testimonial_description' => $data['testimonial_description'],

            'rider_story_title' => $data['rider_story_title'],
            'rider_story_sub_title' => $data['rider_story_sub_title'],
            'rider_story_description' => $data['rider_story_description'],
            'rider_story_image' => $_rider_story_image,

            'showroom_title' => $data['showroom_title'],
            'showroom_description' => $data['showroom_description'],

            'brand_title' => $data['brand_title'],
            'brand_description' => $data['brand_description'],

            'newsletter_title' => $data['newsletter_title'],
            'newsletter_description' => $data['newsletter_description'],

            'blog_title' => $data['blog_title'],
            'blog_sub_title' => $data['blog_sub_title'],
            'blog_description' => $data['blog_description'],

            'contactUs_title' => $data['contactUs_title'],
            'contactUs_description' => $data['contactUs_description'],

            'contactUsGetInTouch_title' => $data['contactUsGetInTouch_title'],
            'contactUsGetInTouch_description' => $data['contactUsGetInTouch_description'],

            'flash_sale_title' => $data['flash_sale_title'],
            'flash_sale_description' => $data['flash_sale_description'],

        ]);

    }

    /**
     * @throws SMException
     */
    public function storeAboutUs($request): mixed
    {
        $data = $request->all();

        if ($request->hasFile('career_image')) {
            $_career_image = Helper::uploadFile(file: $request->career_image, file_folder_name: "aboutUs");
        } else {
            throw new SMException("Career image not found");
        }

        if ($request->hasFile('who_we_are_image')) {
            $_who_we_are_image = Helper::uploadFile(file: $request->who_we_are_image, file_folder_name: "aboutUs");
        } else {
            throw new SMException("who we are image not found");
        }

        if ($request->hasFile('rider_story_image')) {
            $_rider_story_image = Helper::uploadFile(file: $request->rider_story_image, file_folder_name: "aboutUs");
        } else {
            throw new SMException("Rider story image not found");
        }

        return $this->aboutUsRepository->save([
            'about_us_title' => $data['about_us_title'],
            'about_us_sub_title' => $data['about_us_sub_title'],
            'about_us_description' => $data['about_us_description'],

            'core_value_title' => $data['core_value_title'],
            'core_value_sub_title' => $data['core_value_sub_title'],
            'core_value_description' => $data['core_value_description'],

            'who_we_are_title' => $data['who_we_are_title'],
            'who_we_are_sub_title' => $data['who_we_are_sub_title'],
            'who_we_are_description' => $data['who_we_are_description'],
            'who_we_are_image' => $_who_we_are_image,
            'who_we_are_youtube' => $data['who_we_are_youtube'],

            'slogan_title' => $data['slogan_title'],
            'slogan_sub_title' => $data['slogan_sub_title'],
            'slogan_description' => $data['slogan_description'],
            'slogan_title_1' => $data['slogan_title_1'],
            'slogan_description_1' => $data['slogan_description_1'],
            'slogan_title_2' => $data['slogan_title_2'],
            'slogan_description_2' => $data['slogan_description_2'],

            'team_title' => $data['team_title'],
            'team_description' => $data['team_description'],

            'career_title' => $data['career_title'],
            'career_sub_title' => $data['career_sub_title'],
            'career_image' => $_career_image,

            'testimonial_title' => $data['testimonial_title'],
            'testimonial_sub_title' => $data['testimonial_sub_title'],
            'testimonial_description' => $data['testimonial_description'],

            'rider_story_title' => $data['rider_story_title'],
            'rider_story_sub_title' => $data['rider_story_sub_title'],
            'rider_story_description' => $data['rider_story_description'],
            'rider_story_image' => $_rider_story_image,

            'showroom_title' => $data['showroom_title'],
            'showroom_description' => $data['showroom_description'],

            'brand_title' => $data['brand_title'],
            'brand_description' => $data['brand_description'],

            'newsletter_title' => $data['newsletter_title'],
            'newsletter_description' => $data['newsletter_description'],

            'blog_title' => $data['blog_title'],
            'blog_sub_title' => $data['blog_sub_title'],
            'blog_description' => $data['blog_description'],

            'contactUs_title' => $data['contactUs_title'],
            'contactUs_description' => $data['contactUs_description'],

            'contactUsGetInTouch_title' => $data['contactUsGetInTouch_title'],
            'contactUsGetInTouch_description' => $data['contactUsGetInTouch_description'],


            'flash_sale_title' => $data['flash_sale_title'],
            'flash_sale_description' => $data['flash_sale_description'],

        ]);
    }

    public function getAboutUs(): mixed
    {
        return $this->aboutUsRepository->find();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus(): array
    {
        $_aboutUs = $this->aboutUsRepository->find();
        if ($_aboutUs) {
            $this->aboutUsRepository->update($_aboutUs, ['status' => (($_aboutUs->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getHomePageDetail(): array
    {
        $_about_us = $this->aboutUsRepository->find();
        return [
            'who_we_are_title' => $_about_us->who_we_are_title ?? '',
            'who_we_are_sub_title' => $_about_us->who_we_are_sub_title ?? '',
            'who_we_are_description' => $_about_us->who_we_are_description ?? '',
            'who_we_are_image' => $_about_us->who_we_are_image ?? '',
            'who_we_are_youtube' => $_about_us->who_we_are_youtube ?? '',

            'slogan_title' => $_about_us->slogan_title ?? '',
            'slogan_sub_title' => $_about_us->slogan_sub_title ?? '',
            'slogan_description' => $_about_us->slogan_description ?? '',
            'slogan_title_1' => $_about_us->slogan_title_1 ?? '',
            'slogan_description_1' => $_about_us->slogan_description_1 ?? '',
            'slogan_title_2' => $_about_us->slogan_title_2 ?? '',
            'slogan_description_2' => $_about_us->slogan_description_2 ?? '',

            'brand_title' => $_about_us->brand_title ?? '',
            'brand_description' => $_about_us->brand_description ?? '',

            'newsletter_title' => $_about_us->newsletter_title ?? '',
            'newsletter_description' => $_about_us->newsletter_description ?? '',

            'blog_title' => $_about_us->blog_title ?? '',
            'blog_sub_title' => $_about_us->blog_sub_title ?? '',
            'blog_description' => $_about_us->blog_description ?? '',

            'testimonial_title' => $_about_us->testimonial_title ?? '',
            'testimonial_sub_title' => $_about_us->testimonial_sub_title ?? '',
            'testimonial_description' => $_about_us->testimonial_description ?? '',

            'rider_story_title' => $_about_us->rider_story_title ?? '',
            'rider_story_sub_title' => $_about_us->rider_story_sub_title ?? '',
            'rider_story_description' => $_about_us->rider_story_description ?? '',
            'rider_story_image' => $_about_us->rider_story_image_path ?? '',

            'contactUs_title' => $_about_us->contactUs_title ?? '',
            'contactUs_description' => $_about_us->contactUs_description ?? '',

            'contactUsGetInTouch_title' => $_about_us->contactUsGetInTouch_title ?? '',
            'contactUsGetInTouch_description' => $_about_us->contactUsGetInTouch_description ?? '',
        ];
    }

    public function getNewsletterSectionDetail(): array
    {
        $_about_us = $this->aboutUsRepository->find();
        return [
            'newsletter_title' => $_about_us->newsletter_title ?? '',
            'newsletter_description' => $_about_us->newsletter_description ?? '',
        ];
    }

    public function geBlogSectionDetail(): array
    {
        $_about_us = $this->aboutUsRepository->find();
        return [
            'blog_title' => $_about_us->blog_title ?? '',
            'blog_sub_title' => $_about_us->blog_sub_title ?? '',
            'blog_description' => $_about_us->blog_description ?? '',
        ];
    }

    public function getContactUsSectionDetail(): array
    {
        $_about_us = $this->aboutUsRepository->find();
        return [
            'contactUs_title' => $_about_us->contactUs_title ?? '',
            'contactUs_description' => $_about_us->contactUs_description ?? '',

            'contactUsGetInTouch_title' => $_about_us->contactUsGetInTouch_title ?? '',
            'contactUsGetInTouch_description' => $_about_us->contactUsGetInTouch_description ?? '',
        ];
    }

    public function geAboutUsDetail(): array
    {
        $_about_us = $this->aboutUsRepository->find();
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, ($_about_us->who_we_are_youtube ?? ''), $matches);
        $video_id = $matches[1] ?? false;
        return [
            'about_us_title' => $_about_us->about_us_title ?? '',
            'about_us_sub_title' => $_about_us->about_us_sub_title ?? '',
            'about_us_description' => $_about_us->about_us_description ?? '',

            'core_value_title' => $_about_us->core_value_title ?? '',
            'core_value_sub_title' => $_about_us->core_value_sub_title ?? '',
            'core_value_description' => $_about_us->core_value_description ?? '',

            'who_we_are_title' => $_about_us->who_we_are_title ?? '',
            'who_we_are_sub_title' => $_about_us->who_we_are_sub_title ?? '',
            'who_we_are_description' => $_about_us->who_we_are_description ?? '',
            'who_we_are_image' => $_about_us->who_we_are_image_path ?? '',
            'who_we_are_youtube' => $video_id ?? '',

            'slogan_title' => $_about_us->slogan_title ?? '',
            'slogan_sub_title' => $_about_us->slogan_sub_title ?? '',
            'slogan_description' => $_about_us->slogan_description ?? '',

            'slogan_title_1' => $_about_us->slogan_title_1 ?? '',
            'slogan_description_1' => $_about_us->slogan_description_1 ?? '',

            'slogan_title_2' => $_about_us->slogan_title_2 ?? '',
            'slogan_description_2' => $_about_us->slogan_description_2 ?? '',

            'team_title' => $_about_us->team_title ?? '',
            'team_description' => $_about_us->team_description ?? '',

            'career_title' => $_about_us->career_title ?? '',
            'career_sub_title' => $_about_us->career_sub_title ?? '',
            'career_image' => $_about_us->career_image_path ?? '',

            'testimonial_title' => $_about_us->testimonial_title ?? '',
            'testimonial_sub_title' => $_about_us->testimonial_sub_title ?? '',
            'testimonial_description' => $_about_us->testimonial_description ?? '',

            'rider_story_title' => $_about_us->rider_story_title ?? '',
            'rider_story_sub_title' => $_about_us->rider_story_sub_title ?? '',
            'rider_story_description' => $_about_us->rider_story_description ?? '',
            'rider_story_image' => $_about_us->rider_story_image_path ?? '',

            'showroom_title' => $_about_us->showroom_title ?? '',
            'showroom_description' => $_about_us->showroom_description ?? '',

            'brand_title' => $_about_us->brand_title ?? '',
            'brand_description' => $_about_us->brand_description ?? '',

            'newsletter_title' => $_about_us->newsletter_title ?? '',
            'newsletter_description' => $_about_us->newsletter_description ?? '',

            'blog_title' => $_about_us->blog_title ?? '',
            'blog_sub_title' => $_about_us->blog_sub_title ?? '',
            'blog_description' => $_about_us->blog_description ?? '',

            'contactUs_title' => $_about_us->contactUs_title ?? '',
            'contactUs_description' => $_about_us->contactUs_description ?? '',

            'contactUsGetInTouch_title' => $_about_us->contactUsGetInTouch_title ?? '',
            'contactUsGetInTouch_description' => $_about_us->contactUsGetInTouch_description ?? '',

            'flash_sale_title' => $_about_us->flash_sale_title ?? '',
            'flash_sale_description' => $_about_us->flash_sale_description ?? '',
        ];
    }


}
