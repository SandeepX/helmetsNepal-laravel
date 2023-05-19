<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\TestimonialRepository;
use App\Http\Resources\TestimonialResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use JetBrains\PhpStorm\ArrayShape;

class TestimonialServices
{
    private string $notFoundMessage = "Sorry! Testimonial not found";
    private TestimonialRepository $testimonialRepository;


    public function __construct()
    {
        $this->testimonialRepository = new TestimonialRepository();
    }

    public function getList()
    {
        return $this->testimonialRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function savePeopleExperience($request)
    {
        $data = $request->all();
        if ($request->hasFile('testimonial_image')) {
            $_testimonial_image = Helper::uploadFile(file: $request->testimonial_image, file_folder_name: "testimonial", width: 128, height: 128);
        } else {
            throw new SMException("Testimonial Image not found");
        }
        return $this->testimonialRepository->save([
            'name' => $data['name'],
            'designation' => $data['designation'],
            'image' => $_testimonial_image,
            'description' => $data['description'],
            'status' => EStatus::active
        ]);
    }

    /**
     * @throws SMException
     */
    public function getPeopleExperience($testimonial_id)
    {
        $_testimonial = $this->testimonialRepository->find($testimonial_id);
        if ($_testimonial) {
            return $_testimonial;
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function updatePeopleExperience($testimonial_id, $request)
    {
        $data = $request->all();
        $_testimonial = $this->testimonialRepository->find($testimonial_id);
        if ($_testimonial) {
            if ($request->hasFile('testimonial_image')) {
                Helper::unlinkUploadedFile($_testimonial->image, "testimonial");
                $_testimonial_image = Helper::uploadFile(file: $request->testimonial_image, file_folder_name: "testimonial", width: 128, height: 128);
            } else {
                $_testimonial_image = $_testimonial->image;
            }
            return $this->testimonialRepository->update($_testimonial, [
                'name' => $data['name'],
                'designation' => $data['designation'],
                'image' => $_testimonial_image,
                'description' => $data['description'],
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deletePeopleExperience($testimonial_id)
    {
        $_testimonial = $this->testimonialRepository->find($testimonial_id);
        if ($_testimonial) {
            Helper::unlinkUploadedFile($_testimonial->image, "testimonial");
            return $this->testimonialRepository->delete($_testimonial);
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getSelectList()
    {
        return $this->testimonialRepository->getSelectList();
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_testimonial = $this->testimonialRepository->find($user_id);
        if ($_testimonial) {
            $this->testimonialRepository->update($_testimonial, ['status' => (($_testimonial->status === EStatus::active->value) ? EStatus::inactive->value : EStatus::active->value)]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

    public function getTestimonialList(): AnonymousResourceCollection
    {
        $_testimonial = $this->testimonialRepository->getActiveTestimonialList();
        return TestimonialResource::collection($_testimonial);
    }


}
