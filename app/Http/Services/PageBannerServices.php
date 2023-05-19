<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Repositories\PageBannerRepository;

class PageBannerServices
{
    private string $notFoundMessage = "Sorry! PageBanner not found";
    private PageBannerRepository $pageBannerRepository;


    public function __construct()
    {
        $this->pageBannerRepository = new PageBannerRepository();
    }

    public function getList()
    {
        return $this->pageBannerRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function savePageBanner($request)
    {
        $data = $request->all();
        $_page_image = "";
        if ($request->hasFile('page_image')) {
            $_page_image = Helper::uploadFile(file: $request->page_image, file_folder_name: "pageBanner",);
        }
        return $this->pageBannerRepository->save([
            'page_title' => $data['name'],
            'page_sub_title' => $data['name'],
            'page_title_description' => $data['name'],
            'page_image' => $_page_image
        ]);
    }

    /**
     * @throws SMException
     */
    public function getPageBanner($pageBanner_id)
    {
        $_pageBanner = $this->pageBannerRepository->find($pageBanner_id);
        if ($_pageBanner) {
            return $_pageBanner;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updatePageBanner($pageBanner_id, $request)
    {
        $data = $request->all();
        $_pageBanner = $this->pageBannerRepository->find($pageBanner_id);
        if ($_pageBanner) {
            if ($request->hasFile('page_image')) {
                if ($_pageBanner->page_image) {
                    Helper::unlinkUploadedFile($_pageBanner->page_image, "pageBanner");
                }
                $_page_image = Helper::uploadFile(file: $request->page_image, file_folder_name: "pageBanner", width: 1725, height: 645);
            } else {
                $_page_image = $_pageBanner->page_image;
            }
            return $this->pageBannerRepository->update($_pageBanner, [
                'page_title' => $data['page_title'],
                'page_sub_title' => $data['page_sub_title'],
                'page_title_description' => $data['page_title_description'],
                'page_image' => $_page_image
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deletePageBanner($pageBanner_id)
    {
        $_pageBanner = $this->pageBannerRepository->find($pageBanner_id);
        if ($_pageBanner) {
            if ($_pageBanner->page_image) {
                Helper::unlinkUploadedFile($_pageBanner->page_image, "pageBanner");
            }
            return $this->pageBannerRepository->delete($_pageBanner);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getPageBannerByName($name): array
    {
        $_pageBanner = $this->pageBannerRepository->getPageBannerByName($name);
        if ($_pageBanner) {
            return [
                'page_title' => $_pageBanner->page_title ?? "",
                'page_sub_title' => $_pageBanner->page_sub_title ?? "",
                'page_title_description' => $_pageBanner->page_title_description ?? "",
                'page_image_path' => (($_pageBanner->page_image) ? $_pageBanner->page_image_path : ""),
            ];
        }
        return [
            'page_title' => "",
            'page_sub_title' => "",
            'page_title_description' => "",
            'page_image_path' => "",
        ];
    }


}
