<?php
namespace App\Service;
use App\Service\Data\UserData;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;
    private PasswordHasher $passwordHasher;

    public function __construct(UserRepository $userRepository, PasswordHasher $passwordHasher)
    {
        $this->userRepository =  $userRepository;
        $this->passwordHasher =  $passwordHasher;
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
        if ($this->isEmailUniq($userData))
        {
            $user = $this->userRepository->findById($userData->getId());
            empty($userData->getEmail()) ? null : $user->setEmail($userData->getEmail());
            empty($userData->getPassword()) ? null : $user->setPassword($userData->getPassword());
            empty($userData->getAdress()) ? null : $user->setAdress($userData->getAdress());
            empty($userData->getAvatarPath()) ? null : $user->setAvatarPath($userData->getAvatarPath());
            empty($userData->getPhone()) ? null : $user->setPhone($userData->getPhone());
            empty($userData->getFirstName()) ? null : $user->setFirstName($userData->getFirstName());
            empty($userData->getLastName()) ? null : $user->setLastName($userData->getLastName());
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
            $userData->getEmail(),
            empty($userData->getPassword()) ? null : $this->passwordHasher->hash($userData->getPassword()),
            empty($userData->getFirstName()) ? null : $userData->getFirstName(),
            empty($userData->getLastName()) ? null : $userData->getLastName(),
            empty($userData->getPhone()) ? null : $userData->getPhone(),
            empty($userData->getAdress()) ? null : $userData->getAdress(),
            empty($userData->getAvatarPath()) ? null : $userData->getAvatarPath()
        );
        return $user;
    }
    private function userToUserData(User $user): UserData
    {
        $userData = new UserData(
            $user->getId(),
            $user->getEmail(),
            $user->getPassword(),
            empty($user->getFirstName()) ? null : $user->getFirstName(),
            empty($user->getLastName()) ? null : $user->getLastName(),
            empty($user->getPhone()) ? null : $user->getPhone(),
            empty($user->getAdress()) ? null : $user->getAdress(),
            empty($user->getAvatarPath()) ? null : $user->getAvatarPath()
        );
        return $userData;
    }
}