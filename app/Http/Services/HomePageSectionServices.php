<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\HomePageSectionRepository;
use JetBrains\PhpStorm\ArrayShape;

class HomePageSectionServices
{
    private string $notFoundMessage = "Sorry! Home Page Section not found";

    public function __construct()
    {
        $this->homePageSectionRepository = new HomePageSectionRepository();
    }

    public function getList()
    {
        return $this->homePageSectionRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function getHomePageSection($homePageSection_id)
    {
        $_homePageSection = $this->homePageSectionRepository->find($homePageSection_id);
        if ($_homePageSection) {
            return $_homePageSection;
        }
        throw new SMException($this->notFoundMessage);
    }

    public function updateHomePageSection($request): void
    {
        $homePageSection_ids = $request->homePageSection_id ?? [];
        $initial_position = 0;
        foreach ($homePageSection_ids as $homePageSection_id) {
            $_homePageSection = $this->homePageSectionRepository->find($homePageSection_id);
            if ($_homePageSection) {
                $this->homePageSectionRepository->update($_homePageSection, [
                    'position' => $initial_position,
                ]);
                ++$initial_position;
            }
        }
    }

    public function getSelectList()
    {
        $_homePageSection = $this->homePageSectionRepository->getSelectList();
        $return_array = [];
        foreach ($_homePageSection as $homePageSection) {
            $return_array[] = [
                'section' => Helper::getSlugSimple2($homePageSection->name),
                'show' => $homePageSection->status === EStatus::active->value,
            ];
        }
        return $return_array;
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_homePageSection = $this->homePageSectionRepository->find($user_id);
        if ($_homePageSection) {
            $this->homePageSectionRepository->update($_homePageSection, ['status' => (($_homePageSection->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }
}
