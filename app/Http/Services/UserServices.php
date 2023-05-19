<?php

namespace App\Http\Services;

use App\Exceptions\SMException;
use App\Helper\Helper;
use App\Http\Enums\EStatus;
use App\Http\Repositories\UserRepository;
use JetBrains\PhpStorm\ArrayShape;

class UserServices
{
    private string $notFoundMessage = "Sorry! User not found";
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function getList()
    {
        return $this->userRepository->findALl();
    }

    /**
     * @throws SMException
     */
    public function saveUser($request)
    {
        $data = $request->all();
        if ($request->hasFile('user_image')) {
            $_user_image = Helper::uploadFile($data['user_image'], file_folder_name: "users", type: "admin");
        } else {
            throw new SMException("User image not found");
        }
        $password = Helper::passwordHashing($data['password']);
        return $this->userRepository->save([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $password,
            'user_type' => $data['user_type'] ?? "",
            'user_image' => $_user_image,
            'status' => 1,
            'role_id' => $data['role_id'] ?? null,
        ]);
    }

    /**
     * @throws SMException
     */
    public function getUser($user_id)
    {
        $_user = $this->userRepository->find($user_id);
        if ($_user) {
            return $_user;
        }
        throw new SMException($this->notFoundMessage);
    }

    public function findUserDetailByUnexpiredOtpCode($otpCode)
    {
        $_user = $this->userRepository->findUserDetailByUnexpiredOtpCode($otpCode);
        if ($_user) {
            return $_user;
        }
        throw new SMException('Invalid/Expired OTP Code.');
    }

    /**
     * @throws SMException
     */
    public function updateUser($user_id, $request)
    {
        $data = $request->all();
        $_user = $this->userRepository->find($user_id);
        if ($_user) {

            if ($request->hasFile('user_image')) {
                Helper::unlinkUploadedFile(fileName: $_user->user_image, file_folder_name: "users", type: "admin");
                $_user_image = Helper::uploadFile(file: $data['user_image'], file_folder_name: "users", type: "admin");
            } else {
                $_user_image = $_user->user_image;
            }
            return $this->userRepository->update($_user, [
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'user_image' => $_user_image
            ]);
        }
        throw new SMException($this->notFoundMessage);
    }


    /**
     * @throws SMException
     */
    public function updatePassword($user_id, $request)
    {
        $data = $request->all();
        $_user = $this->userRepository->find($user_id);
        if ($_user) {
            if(isset($data['password'])){
                return $this->userRepository->update($_user, [
                    'password' => Helper::passwordHashing($data['password']),
                ]);
            }
            throw new SMException("Password is required");

        }
        throw new SMException($this->notFoundMessage);
    }

    /**
     * @throws SMException
     */
    public function deleteUser($user_id)
    {
        $_user = $this->userRepository->find($user_id);
        if ($_user) {
            return $this->userRepository->delete($_user);
        }
        throw new SMException($this->notFoundMessage);
    }


    public function checkUserByUsername($username)
    {
        return $this->userRepository->getUserByUsername($username);
    }

    public function checkUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function updateUserLoginDetail($user_id, $last_login_ipAddress)
    {
        $_user = $this->userRepository->find($user_id);
        return $this->userRepository->update($_user, [
            'last_login' => now()->format('Y-m-d H:i:s'),
            'last_login_ipAddress' => $last_login_ipAddress,
            'otp_verify_status' => 1,
        ]);
    }

    public function generateTwoFactorCodeForOtpVerification($userDetail)
    {
        return $this->userRepository->update($userDetail, [
            'two_factor_code' => rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(60),
            'otp_verify_status' => 0,
        ]);
    }

    public function resetUserOtpDetail($userDetail)
    {
        return $this->userRepository->update($userDetail, [
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'otp_verify_status' => 0,
        ]);
    }

    /**
     * @throws SMException
     */
    #[ArrayShape(['success' => "bool", 'message' => "string"])]
    public function changeStatus($user_id): array
    {
        $_user = $this->userRepository->find($user_id);
        if ($_user) {
            $this->userRepository->update($_user, ['status' => !$_user->status]);
            return ['success' => true, 'message' => 'Status has been updated successfully'];
        }
        throw new SMException($this->notFoundMessage);
    }

}
