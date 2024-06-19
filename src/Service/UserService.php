<?php
namespace App\Service;
use App\Service\Data\UserData;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository =  $userRepository;
    }   
    public function find(int $id): UserData
    {
        $user = $this->userRepository->findById($id);
        $userData = $this->userToUserData($user);
        return $userData;
    }

    public function findAll(): ?array
    {
        $allUsers = $this->userRepository->findAll();
        $allUsersAsUserData = [];
        foreach ($allUsers as $user) {
            $allUsersAsUserData[] = $this->userToUserData($user);
        }
        return $allUsersAsUserData;
    }
   
    public function updateInfo(UserData $userData)
    {
        if ($this->isEmailUniq($userData) && $this->isPhoneUniq($userData))
        {
            $user = $this->userDataToUser($userData);
            // $user->setFirstName($userData->getFirstName());
            // $user->setLastName($userData->getLastName());
            // $user->setMiddleName($userData->getMiddleName());
            // $user->setBirthDay($userData->getBirthDate());
            // $user->setAvatarPath($userData->getAvatarPath());
            // $user->setGender($userData->getGender());
            // $user->setEmail($userData->getEmail());
            // $user->setPhone($userData->getPhone());
            $this->userRepository->store($user);
        }
    }
    private function isEmailUniq(UserData $userData) 
    {
        $user = $this->userRepository->findBy('email', $userData->getEmail());
        if ($user === null)
        {
            return true;
        } else 
        {
            if ($user->getEmail() === $userData->getEmail() || $user === null)
            {
                return true;
            }
            return false;
        }
    }
    private function isPhoneUniq(UserData $userData) 
    {
        $user = $this->userRepository->findBy('phone', $userData->getPhone());
        if ($user === null)
        {
            return true;
        } else 
        {
            if ($user->getPhone() === $userData->getPhone() || $user === null)
            {
                return true;
            }
            return false;
        }        
    }

    public function create(UserData $userData): int
    {
        $user = $this->userDataToUser($userData);
        return $this->userRepository->store($user);
    }

    public function delete(int $id)
    {
        $this->userRepository->delete($this->userRepository->findById($id));
    }

    public function parseDateTime(string $value, string $format): \DateTimeImmutable
    {
        try { 
            $result = \DateTimeImmutable::createFromFormat($format, $value);
            if (!$result)
            {
                throw new \InvalidArgumentException(message:"Inavlid datetime value");
            }
            return $result;
        } catch (\InvalidArgumentException $e) {echo $e->getMessage(); die();}
    }
    private function userDataToUser(UserData $userData): User
    {
        $user = new User(
            null,
            $userData->getFirstName(),
            $userData->getLastName(),
            empty($userData->getMiddleName()) ? null : $userData->getMiddleName(),
            $userData->getGender(),
            $userData->getBirthDate(),
            $userData->getEmail(),
            empty($userData->getPhone()) ? null : $userData->getPhone(),
            empty($userData->getAvatarPath()) ? null : $userData->getAvatarPath(),
        );
        return $user;
    }
    private function userToUserData(User $user): UserData
    {
        $userData = new UserData(
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            empty($user->getMiddleName()) ? null : $user->getMiddleName(),
            $user->getGender(),
            $user->getBirthDate(),
            $user->getEmail(),
            empty($user->getPhone()) ? null : $user->getPhone(),
            empty($user->getAvatarPath()) ? null : $user->getAvatarPath(),
        );
        return $userData;
    }
}